<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use App\Models\IdpActivity;
use App\Models\User;
use App\Policies\ExportPdfPolicy;
use App\Policies\FilePolicy;
use App\Policies\PenilaianPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\TalentDataPolicy;
use Illuminate\Support\Facades\Gate;

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

        // Force HTTPS in production / ngrok to prevent 419 Expired errors on mobile
        if (str_contains(config('app.url'), 'https://')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');

        }

        // Jika aplikasi diakses melalui proxy aman seperti Ngrok (HTTPS), 
        // maka paksa semua routing & assets menjadi HTTPS.
        // Jika diakses lokal murni (php artisan serve), biarkan tetap HTTP/Normal.
        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // ── Registrasi Policy via Gate::policy ───────────────────
        Gate::policy(IdpActivity::class, FilePolicy::class);
        Gate::policy(User::class, ProfilePolicy::class);
        // ── Gate berbasis closure untuk yang tidak butuh model ────
        Gate::define('export-pdf', function (User $user, User $talent) {
            return (new ExportPdfPolicy)->export($user, $talent);
        });
        Gate::define('submit-penilaian', function (User $user, int $talentId) {
            return (new PenilaianPolicy)->submit($user, $talentId);
        });
        Gate::define('view-talent-data', function (User $user, User $talent) {
            return (new TalentDataPolicy)->view($user, $talent);
        });
        Gate::define('manage-all-talent', function (User $user) {
            return (new TalentDataPolicy)->manageAll($user);
        });
        Gate::define('view-all-penilaian', function (User $user) {
            return (new PenilaianPolicy)->viewAll($user);
        });
    }

}
