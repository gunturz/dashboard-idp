<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Auth\Events\Registered;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();


        // Verifikasi intent kandidat (dari session storeKompetensi)
        if (session()->has('register_kandidat')) {
            $intent = session('register_kandidat');
            // Pastikan user yang login adalah user_id yang baru registrasi
            if (Auth::user()->id !== $intent['user_id']) {
                Auth::logout();
                return back()->withErrors(['username' => 'Akun yang Anda login bukan akun yang baru didaftarkan. Silakan gunakan akun terbaru.']);
            }
            // Trigger event Registered (yang seharusnya dipanggil di storeKompetensi)
            event(new Registered(Auth::user()));
            session()->forget('register_kandidat');
        }



        // setelah Auth::attempt / setelah user di-retrieve dan login dilakukan
        // Verifikasi intent non-kandidat (dari flow registrasi non-kandidat)
        if (session()->has('register_non_kandidat')) {
            $intent = session('register_non_kandidat');
            if (Auth::user()->role !== $intent['role']) {
                Auth::logout();
                return back()->withErrors(['username' => 'Role akun tidak sesuai dengan yang dipilih saat registrasi.']);
            }
            // Role cocok → hapus session intent
            session()->forget('register_non_kandidat');
        }

        $role = strtolower(Auth::user()->role ?? '');

        // Simple redirect based on role
        if ($role === 'kandidat') {
            return redirect()->route('kandidat.dashboard');
        }
        elseif ($role === 'atasan') {
            return redirect()->route('atasan.dashboard');
        }
        elseif ($role === 'mentor') {
            return redirect()->route('mentor.dashboard');
        }
        elseif ($role === 'finance') {
            return redirect()->route('finance.dashboard');
        }
        elseif ($role === 'admin_pdc') {
            return redirect()->route('admin_pdc.dashboard');
        }
        elseif ($role === 'bo_director') {
            return redirect()->route('bo_director.dashboard');
        }
        else {
            return redirect('/');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
