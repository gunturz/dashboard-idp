<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPasswordLinkNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'],
        ]);

        // Cari user berdasarkan username atau email
        $login = $request->input('login');
        $user = User::where('email', $login)
                    ->orWhere('username', $login)
                    ->first();

        if (! $user) {
            return back()
                ->withInput($request->only('login'))
                ->withErrors(['login' => 'Username atau email tidak ditemukan.']);
        }

        $plainToken = Str::random(64);

        DB::table('password_resets')
            ->where('user_id', $user->id)
            ->delete();

        DB::table('password_resets')->insert([
            'user_id' => $user->id,
            'email' => $user->email,
            'token' => hash('sha256', $plainToken),
            'expires_at' => now()->addMinutes(60),
            'is_used' => false,
            'created_at' => now(),
        ]);

        $resetUrl = URL::route('password.reset', [
            'token' => $plainToken,
            'email' => $user->email,
        ]);

        $user->notify(new ResetPasswordLinkNotification($resetUrl));

        return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
    }
}
