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
        // Jika aplikasi diakses melalui proxy aman seperti Ngrok (HTTPS), 
        // maka paksa semua routing & assets menjadi HTTPS.
        // Jika diakses lokal murni (php artisan serve), biarkan tetap HTTP/Normal.
        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
