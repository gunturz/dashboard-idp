<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set Carbon locale ke Bahasa Indonesia agar translatedFormat()
        // menampilkan nama bulan dalam bahasa Indonesia (Januari, Februari, dst.)
        Carbon::setLocale('id');
    }
}
