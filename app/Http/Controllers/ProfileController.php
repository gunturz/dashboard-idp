<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Company;
use App\Models\Department;
use App\Models\Position;
use App\Models\Role;
use App\Models\PromotionPlan;
use App\Services\AuditLogger;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profil
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->load(['company', 'department', 'position', 'role', 'promotion_plan.targetPosition', 'mentor', 'atasan']);
        $activeRole = session('active_role');
        $roleName = strtolower(trim($activeRole ?: ($user->role->role_name ?? '')));

        if (in_array($roleName, ['talent', 'kandidat'])) {
            $layoutName = 'talent.layout';
        } elseif ($roleName === 'mentor') {
            $layoutName = 'mentor.layout';
        } elseif ($roleName === 'atasan') {
            $layoutName = 'atasan.layout';
        } elseif (in_array($roleName, ['admin', 'pdc admin', 'pdc_admin'])) {
            $layoutName = 'pdc_admin.layout';
        } elseif ($roleName === 'finance') {
            $layoutName = 'finance.layout';
        } elseif (in_array($roleName, ['Panelis', 'panelis', 'panelist', 'Panelist'])) {
            $layoutName = 'panelis.layout';
        } else {
            $layoutName = 'app-layout'; // fallback
        }

        if (in_array($roleName, ['talent', 'kandidat', 'mentor', 'atasan'])) {
            $hasDevPlan = \App\Models\PromotionPlan::where('is_active', true)
                ->whereNotIn('status_promotion', ['Promoted', 'Not Promoted'])
                ->where(function ($query) use ($user) {
                    $query->where('user_id_talent', $user->id)
                        ->orWhereJsonContains('mentor_ids', (string) $user->id)
                        ->orWhereIn('user_id_talent', function ($subquery) use ($user) {
                            $subquery->select('id')->from('users')->where('atasan_id', $user->id);
                        });
                })->exists();
        } else {
            $hasDevPlan = false;
        }

        return view('profile.dashboard', [
            'user' => $user,
            'notifications' => $this->getNotifications(),
            'companies' => Company::all(),
            'departments' => $user->company_id ? Department::where('company_id', $user->company_id)->orderBy('nama_department')->get() : collect(),
            'roles' => Role::all(),
            'positions' => Position::all(),
            'activeRoleName' => $roleName,
            'hasDevPlan' => $hasDevPlan,
            'layoutName' => $layoutName,
        ]);
    }



    /**
     * Update profil user
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();



        // Normalize email to lowercase
        if (!empty($data['email'])) {
            $data['email'] = strtolower($data['email']);
        }

        // Handle password hashing
        if (!empty($data['password'])) {
            \Illuminate\Support\Facades\Log::info('Profile Update - password IS set, hashing now');
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        } else {
            \Illuminate\Support\Facades\Log::info('Profile Update - password is EMPTY, skipping');
            unset($data['password']); // Jangan update password jika kosong
        }


        // Handle upload foto (base64 from cropper)
        if (!empty($data['foto_base64'])) {
            $image_parts = explode(";base64,", $data['foto_base64']);
            if (count($image_parts) == 2) {
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = strtolower($image_type_aux[1] ?? '');
                $image_base64 = base64_decode($image_parts[1], true);

                if ($image_base64 === false) {
                    return back()->withErrors(['foto' => 'Data gambar tidak valid.'])->withInput();
                }

                $allowedTypes = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                if (!in_array($image_type, $allowedTypes, true)) {
                    return back()->withErrors(['foto' => 'Format gambar tidak valid.'])->withInput();
                }

                $tempPath = tempnam(sys_get_temp_dir(), 'foto_');
                if ($tempPath === false) {
                    return back()->withErrors(['foto' => 'Gagal memproses gambar.'])->withInput();
                }

                file_put_contents($tempPath, $image_base64);
                $imageInfo = getimagesize($tempPath);

                if (!$imageInfo || !in_array($imageInfo[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP], true)) {
                    unlink($tempPath);
                    return back()->withErrors(['foto' => 'File bukan gambar yang valid.'])->withInput();
                }

                unlink($tempPath);

                if ($user->foto) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto);
                }

                $fileName = 'foto-profil/' . Str::uuid() . '.' . $image_type;
                \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $image_base64);
                $data['foto'] = $fileName;
            }
        }


        // Handle upload foto (regular file, fallback)
        elseif ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto-profil', 'public');
        } elseif ($request->boolean('should_delete_foto')) {
            // Hapus foto jika diminta (tanpa upload baru)
            if ($user->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = null;
        }

        if (array_key_exists('foto_base64', $data)) {
            unset($data['foto_base64']);
        }

        // Hapus password jika kosong, agar tidak ikut ke-update menjadi null hash
        if (empty($data['password'])) {
            unset($data['password']);
        }

        // Buang should_delete_foto dari array data agar tidak ikut diupdate ke DB
        if (array_key_exists('should_delete_foto', $data)) {
            unset($data['should_delete_foto']);
        }

        // Buang target_position_id dari $data agar tidak di-update ke tabel users
        $targetPositionId = null;
        if (array_key_exists('target_position_id', $data)) {
            $targetPositionId = $data['target_position_id'];
            unset($data['target_position_id']);
        }

        // Bypassing the Eloquent model to prevent "Unknown Column" cache issues
        \Illuminate\Support\Facades\DB::table('users')
            ->where('id', $user->id)
            ->update($data);

        // ✅ LOG: Data profil diperbarui
        // Menggunakan array keys dari $data karena update bypass metode getChanges() eloquent
        $changedFields = array_keys($data);
        if (($key = array_search('password', $changedFields)) !== false) {
            unset($changedFields[$key]); // keamanan tambahan, meski di atas $data['password'] sudah disaring hash-nya jika ada
        }
        $changedFields = array_values($changedFields);

        AuditLogger::log(
            event: 'user_updated',
            description: "User [{$user->email}] memperbarui profil: " . implode(', ', $changedFields),
            properties: [
                'changed_fields' => $changedFields,
            ]
        );

        // Update target position ke tabel promotion_plan jika ada
        if (!is_null($targetPositionId)) {
            PromotionPlan::updateOrCreate(
                ['user_id_talent' => $user->id],
                ['target_position_id' => $targetPositionId]
            );
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Hapus akun user
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
