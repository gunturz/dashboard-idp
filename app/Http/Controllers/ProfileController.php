<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Company;
use App\Models\Department;
use App\Models\Position;
use App\Models\Role;
use App\Models\PromotionPlan;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profil
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->load(['company', 'department', 'position', 'role', 'promotion_plan.targetPosition', 'mentor', 'atasan']);
        $roleName = strtolower(trim($user->role->role_name ?? ''));

        if (in_array($roleName, ['talent', 'kandidat'])) {
            $view = 'talent.profile';
        }
        elseif ($roleName === 'mentor') {
            $view = 'mentor.profile';
        }
        elseif ($roleName === 'atasan') {
            $view = 'atasan.profile';
        }
        elseif (in_array($roleName, ['admin', 'pdc admin', 'pdc_admin'])) {
            $view = 'pdc_admin.profile';
        }
        elseif ($roleName === 'finance') {
            $view = 'finance.profile';
        }
        else {
            $view = 'profile.dashboard'; // fallback
        }

        return view($view, [
            'user' => $user,
            'notifications' => $this->getNotifications(),
            'companies' => Company::all(),
            'departments' => Department::all(),
            'roles' => Role::all(),
            'positions' => Position::all(),
        ]);
    }

    private function getNotifications()
    {
        return collect([
            [
                'id' => 1,
                'title' => 'Submit IDP Berhasil',
                'desc' => 'Formulir <span class="font-semibold">Exposure</span> Anda telah berhasil dikirim dan sedang menunggu tinjauan dari mentor/atasan.',
                'type' => 'success',
                'time' => '10 menit yang lalu',
                'is_read' => false,
                'badge' => 'Baru'
            ]
        ]);
    }

    /**
     * Update profil user
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        \Illuminate\Support\Facades\Log::info('Profile Update Data:', $data);

        // Normalize email to lowercase
        if (!empty($data['email'])) {
            $data['email'] = strtolower($data['email']);
        }

        // Handle password hashing
        if (!empty($data['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        }
        else {
            unset($data['password']); // Jangan update password jika kosong
        }

        // Handle upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto-profil', 'public');
        }
        elseif ($request->boolean('should_delete_foto')) {
            // Hapus foto jika diminta (tanpa upload baru)
            if ($user->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = null;
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