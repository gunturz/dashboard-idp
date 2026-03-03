<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
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
            'username' => ['required', 'string'],
            'email'    => ['required', 'email'],
        ]);

        // Pastikan kombinasi username & email cocok
        $user = User::where('username', $request->username)
                     ->where('email', $request->email)
                     ->first();

        if (! $user) {
            return back()
                ->withInput($request->only('username', 'email'))
                ->withErrors(['email' => 'Username dan email tidak cocok dengan data kami.']);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('username', 'email'))
                        ->withErrors(['email' => __($status)]);
    }
}
