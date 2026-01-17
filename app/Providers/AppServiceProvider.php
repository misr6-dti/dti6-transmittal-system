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
        \Illuminate\Pagination\Paginator::useBootstrap();
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Transmittal::class, \App\Policies\TransmittalPolicy::class);

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
