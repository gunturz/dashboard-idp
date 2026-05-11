<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Ensure2FaIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $activeRole = strtolower(session('active_role', ''));

        // Memasukkan SEMUA variasi penulisan nama Role yang mungkin ada di database Anda
        $rolesYangButuh2FA = [
            'pdc_admin',
            'pdc admin',
            'admin',
            'admin.pdc', // Group PDC
            'panelis',
            'panelist',                          // Group Panelis
            'finance',
            'atasan',
            'talent',
            'mentor'
        ];

        // Cek apakah user baru saja mendaftar (Memberikan "Grace Period" 30 Menit)
        // Jadi, langsung masuk dashboard tanpa OTP bila umur akun belum 30 menit.
        $user = $request->user();
        $isBaruRegister = false;

        if ($user && $user->created_at) {
            $isBaruRegister = now()->diffInMinutes($user->created_at) < 30;
        }

        // Jika masuk radar role, OTO belum lulus, DAN DIA BUKAN akun baru
        if (in_array($activeRole, $rolesYangButuh2FA) && !session()->has('2fa_passed') && !$isBaruRegister) {
            // Redirect ke route spesifik halaman ketik OTP
            return redirect()->route('2fa.index');
        }
        return $next($request);
    }
}
