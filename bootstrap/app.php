<?php

use App\Services\SecurityAlerter;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->trustProxies(at: '*');
        $middleware->trustProxies(
            at: env('TRUSTED_PROXIES', '127.0.0.1'),
            headers: \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO
        );

        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);

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
            try {
                // Jangan gunakan facade di bootstrap exception handler:
                // saat error awal terjadi, facade root bisa belum tersedia.
                app('log')->channel('app_log')->error('[APP_ERROR] ' . get_class($e) . ': ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'url' => request()?->fullUrl(),
                    'user' => auth()->id(),
                ]);

                // Deteksi error spike dalam jendela 5 menit.
                $errorCountKey = 'error_spike_count_' . date('YmdHi');
                $cache = app('cache')->store();
                $currentCount = $cache->increment($errorCountKey);

                if ($currentCount === 1) {
                    $cache->put($errorCountKey, 1, now()->addMinutes(5));
                }

                $threshold = 20;
                if ($currentCount >= $threshold) {
                    SecurityAlerter::errorSpike(
                        errorType: get_class($e),
                        count: $currentCount,
                        threshold: '5 menit'
                    );
                }
            } catch (\Throwable $loggingError) {
                // Hindari exception handler memicu exception baru saat bootstrap.
            }
        });
    })->create();
