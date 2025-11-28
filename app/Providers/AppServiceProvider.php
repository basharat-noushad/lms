<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

if (!function_exists('format_currency')) {
    function format_currency($value)
    {
        return '$' . number_format($value, 2);
    }
}

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // require_once app_path('Helpers/helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register welcome email listener
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Registered::class,
            \App\Listeners\SendWelcomeEmail::class,
        );
    }
}
