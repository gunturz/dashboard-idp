<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

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

        return $this->sendLoginResponse();
    }

    public function redirectToGoogle(): RedirectResponse
    {
        return $this->googleDriver()->redirect();
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        try {
            $googleUser = $this->googleDriver()->user();
        }
        catch (Throwable $exception) {
            Log::error('Google login callback failed.', [
                'message' => $exception->getMessage(),
                'type' => $exception::class ,
                'url' => $request->fullUrl(),
            ]);

            return redirect()->route('login')
                ->withErrors(['google' => 'Login dengan Google gagal. Silakan coba lagi.']);
        }

        $email = strtolower((string)$googleUser->getEmail());

        if ($email === '') {
            return redirect()->route('login')
                ->withErrors(['google' => 'Akun Google tidak memiliki email yang dapat digunakan untuk login.']);
        }

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->first();

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Email Google Anda belum terdaftar di sistem IDP.']);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return $this->sendLoginResponse();
    }

    protected function sendLoginResponse(): RedirectResponse
    {


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

        $roles = Auth::user()->roles;
        if ($roles && $roles->count() > 1) {
            return redirect()->route('role.select');
        }

        if ($roles && $roles->count() === 1) {
            $role = strtolower($roles->first()->role_name);
            session(['active_role' => $role]);
        }
        else {
            $role = strtolower(Auth::user()->role->role_name ?? '');
            session(['active_role' => $role]);
        }

        // Set flag for PDC Admin so the layout can show the registration toast on first load
        // Use put instead of flash to survive the double redirect from /dashboard -> /pdc_admin/dashboard
        if (in_array($role, ['admin', 'pdc_admin'])) {
            session()->put('pdc_admin_just_logged_in', true);
        }
        if (in_array($role, ['panelis', 'bo_director', 'board_of_directors', 'board_of_director'])) {
            session()->put('panelis_just_logged_in', true);
        }
        if ($role === 'atasan') {
            session()->put('atasan_just_logged_in', true);
        }
        if ($role === 'talent') {
            session()->put('talent_just_logged_in', true);
        }
        if ($role === 'mentor') {
            session()->put('mentor_just_logged_in', true);
        }

        return redirect()->intended(route('dashboard'));
    }

    protected function googleDriver()
    {
        return Socialite::driver('google')->stateless();
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
