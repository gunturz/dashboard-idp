<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TwoFactorController extends Controller
{
    public function index()
    {
        // Generate dan kirim OTP jika belum ada di sesi ini
        if (!session()->has('email_otp_code')) {
            $this->sendEmailOtp();
        }

        return view('auth.2fa_verify');
    }

    public function resend(Request $request)
    {
        // Validasi backend: cegah spam brutal sebelum 60 detik berlalu
        $lastResend = session('last_resend_time', 0);
        if (time() - $lastResend < 60) {
            return back()->withErrors(['error' => 'Terlalu banyak permintaan. Tunggu 1 menit sebelum mengirim ulang.']);
        }

        $this->sendEmailOtp();
        
        // Simpan waktu eksekusi resend kali ini
        session(['last_resend_time' => time()]);

        return back()->with('status', 'Kode keamanan (OTP) terbaru telah dikirim ulang ke email Anda. Cek juga folder spam!');
    }

    private function sendEmailOtp()
    {
        // 6 angka acak
        $otp = random_int(100000, 999999); // ✅ Cryptographically secure
        // Simpan HASH OTP, bukan plaintext
        session(['email_otp_hash' => hash('sha256', (string) $otp)]);
        session(['email_otp_expires' => now()->addMinutes(10)]);
        session(['email_otp_attempts' => 0]); // Counter percobaan

        $user = auth()->user();

        try {
            Mail::raw("Halo {$user->name},\n\Kode verifikasi keamanan untuk login Anda adalah: {$otp}\n\nKode ini berlaku selama 10 menit. Abaikan pesan ini jika Anda tidak mencoba masuk.", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Kode Keamanan Login IDP Dashboard');
            });
        } catch (\Exception $e) {
            // Error handling bila SMTP mail belum diseting agar aplikasi tak crash
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }
    }

    // public function verify(Request $request)
    // {
    //     $request->validate([
    //         'one_time_password' => 'required|numeric',
    //     ]);

    //     if (now()->greaterThan(session('email_otp_expires'))) {
    //         return back()->withErrors(['error' => 'Kode OTP kedaluwarsa. Silakan klik tombol kirim ulang.']);
    //     }

    //     if ((int) $request->one_time_password === (int) session('email_otp_code')) {
    //         session(['2fa_passed' => true]);
    //         session()->forget(['email_otp_code', 'email_otp_expires']); // Cleanup

    //         return redirect()->route('dashboard');
    //     }

    //     return back()->withErrors(['error' => 'Kode OTP salah. Harap periksa angka terbaru di Email Anda.']);
    // },

    public function verify(Request $request)
    {
        // Rate limit percobaan
        $attempts = session('email_otp_attempts', 0);
        if ($attempts >= 5) {
            session()->forget(['email_otp_hash', 'email_otp_expires', 'email_otp_attempts']);
            return back()->withErrors(['error' => 'Terlalu banyak percobaan. Silakan minta OTP baru.']);
        }
        session(['email_otp_attempts' => $attempts + 1]);
        // Bandingkan hash, bukan plaintext
        if (hash('sha256', $request->one_time_password) === session('email_otp_hash')) {
            session(['2fa_passed' => true]);
            session()->forget(['email_otp_hash', 'email_otp_expires', 'email_otp_attempts']);
            return redirect()->route('dashboard');
        }
        return back()->withErrors(['error' => 'Kode OTP salah. Silakan coba lagi.']);
    }
}
