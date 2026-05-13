<?php
# app/routes/console.php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

// Audit dependency setiap Senin jam 07:00
Schedule::command('security:dependency-audit --notify')
    ->weeklyOn(1, '07:00')
    ->withoutOverlapping()
    ->onFailure(function () {
        Log::channel('security_log')->critical('Dependency audit schedule gagal dijalankan!');
    });