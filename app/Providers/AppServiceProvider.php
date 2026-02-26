<?php

namespace App\Providers;

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
        // Dynamically resolve the application base URL from the request.
        // This ensures asset(), url(), and route() work correctly in
        // subdirectory deployments (e.g. /dti6-tms/public) without
        // requiring a perfectly configured APP_URL in .env.
        if (isset($_SERVER['HTTP_HOST'])) {
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
            $basePath = str_replace('/index.php', '', $scriptName);
            $baseUrl = $scheme . '://' . $_SERVER['HTTP_HOST'] . $basePath;

            \Illuminate\Support\Facades\URL::forceRootUrl($baseUrl);
            if ($scheme === 'https') {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }
        } else {
            // Fallback for CLI (artisan commands)
            $appUrl = config('app.url');
            if ($appUrl) {
                \Illuminate\Support\Facades\URL::forceRootUrl($appUrl);
                if (strpos($appUrl, 'https://') === 0) {
                    \Illuminate\Support\Facades\URL::forceScheme('https');
                }
            }
        }

        \Illuminate\Pagination\Paginator::useBootstrap();
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Transmittal::class, \App\Policies\TransmittalPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\DocumentLog::class, \App\Policies\DocumentLogPolicy::class);
        \App\Models\DocumentLog::observe(\App\Observers\DocumentLogObserver::class);

        // Track Login Statistics
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            function ($event) {
                $event->user->update([
                    'last_login_at' => now(),
                    'login_count' => $event->user->login_count + 1,
                ]);
            }
        );
    }
}
