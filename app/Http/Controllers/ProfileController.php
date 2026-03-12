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
        return view('profile.dashboard', [
            'user'          => $request->user()->load(['company', 'department', 'position', 'role', 'promotion_plan.targetPosition', 'mentor', 'atasan']),
            'notifications' => $this->getNotifications(),
            'companies'     => Company::all(),
            'departments'   => Department::all(),
            'roles'         => Role::all(),
            'positions'     => Position::all(),
        ]);
    }

    private function getNotifications() {
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
        } else {
            unset($data['password']); // Jangan update password jika kosong
        }

        // Handle upload foto
        if ($request->hasFile('foto')) {
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

        $user->fill($data)->save();

        if (array_key_exists('target_position_id', $data)) {
            PromotionPlan::updateOrCreate(
                ['user_id_talent' => $user->id],
                ['target_position_id' => $data['target_position_id']]
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