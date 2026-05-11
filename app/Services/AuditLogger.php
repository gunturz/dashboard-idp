<?php

namespace App\Services;

use App\Models\AuditActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    /**
     * Catat event audit ke FILE LOG + DATABASE bersamaan.
     *
     * @param string      $event       Kode event (contoh: 'login_success')
     * @param string      $description Deskripsi human-readable
     * @param array       $properties  Data tambahan (bebas)
     * @param int|null    $userId      Paksa user ID (opsional, default: user yang sedang login)
     */
    public static function log(
        string $event,
        string $description,
        array  $properties = [],
        ?int   $userId = null
    ): void {
        $userId    = $userId ?? Auth::id();
        $ipAddress = Request::ip();
        $userAgent = Request::userAgent();

        // ── 1. Tulis ke FILE LOG (channel audit_log) ──────────────────────
        Log::channel('audit_log')->info("[AUDIT] {$event}", [
            'user_id'     => $userId,
            'description' => $description,
            'ip'          => $ipAddress,
            'agent'       => $userAgent,
            'properties'  => $properties,
        ]);

        // ── 2. Simpan ke DATABASE ──────────────────────────────────────────
        // Wrap try-catch agar jika DB error, aplikasi tidak crash
        try {
            AuditActivity::create([
                'user_id'     => $userId,
                'event'       => $event,
                'description' => $description,
                'properties'  => $properties,
                'ip_address'  => $ipAddress,
                'user_agent'  => $userAgent,
            ]);
        } catch (\Throwable $e) {
            // Jika gagal simpan ke DB, tulis ke app log sebagai fallback
            Log::channel('app_log')->error('AuditLogger DB write failed: ' . $e->getMessage(), [
                'event' => $event,
            ]);
        }
    }
}
