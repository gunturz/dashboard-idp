<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Services\SecurityAlerter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureRole::class,
            'talent.only' => \App\Http\Middleware\EnsureTalentRole::class,
            'atasan.only' => \App\Http\Middleware\EnsureAtasanRole::class,
            'mentor.only' => \App\Http\Middleware\EnsureMentorRole::class,
            'finance.only' => \App\Http\Middleware\EnsureFinanceRole::class,
            'panelis.only' => \App\Http\Middleware\EnsurePanelisRole::class,
            'pdc_admin.only' => \App\Http\Middleware\EnsurePdcAdminRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (\Throwable $e) {
            // Log error ke channel app_log
            Log::channel('app_log')->error('[APP_ERROR] ' . get_class($e) . ': ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'url'  => request()->fullUrl(),
                'user' => auth()->id(),
            ]);
            // ── Deteksi Error Spike ──────────────────────────────────────
            // Hitung berapa kali error terjadi dalam 5 menit terakhir
            $errorCountKey = 'error_spike_count_' . date('YmdHi'); // key per menit
            $currentCount  = Cache::increment($errorCountKey);
            // Set TTL hanya pada increment pertama
            if ($currentCount === 1) {
                Cache::put($errorCountKey, 1, now()->addMinutes(5));
            }
            // Jika dalam 5 menit ada lebih dari 20 error, kirim alert
            $THRESHOLD = 20;
            if ($currentCount >= $THRESHOLD) {
                SecurityAlerter::errorSpike(
                    errorType: get_class($e),
                    count:     $currentCount,
                    threshold: '5 menit'
                );
            }
        });
    })->create();
