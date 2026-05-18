<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SecurityAlerter
{
    // Email penerima alert keamanan (set di .env)
    protected static function alertEmail(): string
    {
        return config('app.security_alert_email', env('SECURITY_ALERT_EMAIL', 'hamidizzudin4@gmail.com'));
    }

    /**
     * Alert: Login brute force terdeteksi.
     * Dipanggil dari LoginRequest ketika attempt melebihi threshold.
     */
    public static function loginBruteForce(string $email, string $ip, int $attempts): void
    {
        $message = "⚠️ BRUTE FORCE ALERT: {$attempts} kali percobaan login gagal untuk email [{$email}] dari IP [{$ip}]";

        Log::channel('security_log')->warning('[SECURITY] LOGIN_BRUTE_FORCE', [
            'email'    => $email,
            'ip'       => $ip,
            'attempts' => $attempts,
        ]);

        // Anti-spam: hanya kirim email alert sekali per 10 menit per IP
        $cacheKey = "brute_force_alert_{$ip}";
        if (!Cache::has($cacheKey)) {
            Cache::put($cacheKey, true, now()->addMinutes(10));
            self::sendEmailAlert('⚠️ Brute Force Login Terdeteksi', $message);
        }
    }

    /**
     * Alert: Percobaan akses file yang tidak diizinkan.
     * Dipanggil dari DocumentController ketika policy gagal.
     */
    public static function unauthorizedFileAccess(int $userId, int $documentId, string $ip): void
    {
        $message = "🚫 UNAUTHORIZED FILE: User ID [{$userId}] mencoba akses Document ID [{$documentId}] dari IP [{$ip}]";

        Log::channel('security_log')->warning('[SECURITY] UNAUTHORIZED_FILE_ACCESS', [
            'user_id'     => $userId,
            'document_id' => $documentId,
            'ip'          => $ip,
        ]);

        self::sendEmailAlert('🚫 Akses File Tidak Sah Terdeteksi', $message);
    }

    /**
     * Alert: Lonjakan error aplikasi dalam window waktu tertentu.
     * Dipanggil dari Handler.php atau middleware error monitor.
     */
    public static function errorSpike(string $errorType, int $count, string $threshold): void
    {
        $message = "🔴 ERROR SPIKE: [{$errorType}] terjadi {$count}x dalam {$threshold} (threshold terlampaui)";

        Log::channel('security_log')->error('[SECURITY] ERROR_SPIKE', [
            'error_type' => $errorType,
            'count'      => $count,
            'threshold'  => $threshold,
        ]);

        // Anti-spam: hanya kirim 1x per jam per error type
        $cacheKey = "error_spike_alert_{$errorType}";
        if (!Cache::has($cacheKey)) {
            Cache::put($cacheKey, true, now()->addHour());
            self::sendEmailAlert('🔴 Lonjakan Error Terdeteksi', $message);
        }
    }

    /**
     * Kirim email alert ke security team.
     * Menggunakan Mail::raw (tidak perlu template blade).
     */
    protected static function sendEmailAlert(string $subject, string $body): void
    {
        try {
            $appName = config('app.name', 'Dashboard IDP');
            $fullBody = $body . "\n\n---\nDikirim otomatis oleh {$appName}\nWaktu: " . now()->format('Y-m-d H:i:s T');

            Mail::raw($fullBody, function ($msg) use ($subject) {
                $msg->to(self::alertEmail())
                    ->subject("[SECURITY ALERT] {$subject}");
            });
        } catch (\Throwable $e) {
            // Jika email gagal, minimal tulis ke security log
            Log::channel('security_log')->error('[SECURITY] Alert email GAGAL dikirim: ' . $e->getMessage());
        }
    }
}
