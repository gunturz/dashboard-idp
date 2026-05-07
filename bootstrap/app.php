<?php

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
        //
    })->create();
