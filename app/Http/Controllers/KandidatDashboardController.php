<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\KandidatKompetensi;

class KandidatDashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            Log::info('KandidatDashboard accessed by user: ' . $user->id . ' (' . $user->username . ')');
            
            // Hanya kandidat yang bisa akses dashboard ini
            if ($user->role !== 'kandidat') {
                Log::warning('Non-kandidat user ' . $user->username . ' tried to access kandidat dashboard');
                abort(403, 'Hanya kandidat yang bisa mengakses dashboard ini.');
            }
            
            // Fetch kompetensi dari tabel kandidat_kompetensi
            $kompetensi = $user->kandidatKompetensi ?? null;
            
            if (!$kompetensi) {
                Log::warning('User ' . $user->username . ' has no competency data');
            }
            
            // Return ke view dengan data
            return view('kandidat.dashboard', compact('user', 'kompetensi'));
        } catch (\Exception $e) {
            Log::error('KandidatDashboard error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function idpMonitoring()
    {
        try {
            $user = Auth::user();
            
            if ($user->role !== 'kandidat') {
                abort(403, 'Hanya kandidat yang bisa mengakses halaman ini.');
            }

            return view('kandidat.idp-monitoring', compact('user'));
        } catch (\Exception $e) {
            Log::error('KandidatDashboard idpMonitoring error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function notifikasi()
    {
        try {
            $user = Auth::user();
            
            if ($user->role !== 'kandidat') {
                abort(403, 'Hanya kandidat yang bisa mengakses halaman ini.');
            }

            return view('kandidat.notifikasi', compact('user'));
        } catch (\Exception $e) {
            Log::error('KandidatDashboard notifikasi error: ' . $e->getMessage());
            throw $e;
        }
    }
}
