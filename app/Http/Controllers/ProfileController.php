<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil kandidat (gambar 3)
     */
    public function show(Request $request): View
    {
        $user = $request->user()->load(['mentor', 'atasan']);
        $notifications = $this->getNotifications();
        return view('profile.dashboard', compact('user', 'notifications'));
    }

    private function getNotifications()
    {
        $allRead = session('notifications_all_read', false);

        return collect([
            [
                'id' => 1,
                'title' => 'Submit IDP Berhasil',
                'desc' => 'Formulir <span class="font-semibold">Exposure</span> Anda telah berhasil dikirim dan sedang menunggu tinjauan dari mentor/atasan.',
                'type' => 'success', // success, info, warning
                'time' => '10 menit yang lalu',
                'is_read' => $allRead ? true : false,
                'badge' => $allRead ? null : 'Baru'
            ],
            [
                'id' => 2,
                'title' => 'Review Mentor Selesai',
                'desc' => 'Project Improvement Anda berjudul <span class="font-semibold">"Sistem Logistik Baru"</span> telah direview oleh mentor Anda. Klik untuk melihat feedback.',
                'type' => 'info',
                'time' => '2 jam yang lalu',
                'is_read' => true,
                'badge' => null
            ],
            [
                'id' => 3,
                'title' => 'Pengingat LogBook',
                'desc' => 'Anda belum mengisi LogBook untuk aktivitas <span class="font-semibold">Mentoring</span> minggu ini. Pastikan untuk memperbaruinya segera.',
                'type' => 'warning',
                'time' => 'Kemarin, 14:30',
                'is_read' => true,
                'badge' => null
            ],
            [
                'id' => 4,
                'title' => 'Pembaruan Kompetensi',
                'desc' => 'Atasan Anda telah memberikan penilaian kompetensi terbaru untuk Anda. Periksa grafik pada dashboard.',
                'type' => 'success',
                'time' => '3 hari yang lalu',
                'is_read' => true,
                'badge' => null
            ]
        ]);
    }

    /**
     * Tampilkan form edit profil
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
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

        return Redirect::route('profile.show')->with('status', 'profile-updated');
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