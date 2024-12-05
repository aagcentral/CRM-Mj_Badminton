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
        // Register helper function globally
        if (!function_exists('havePermission')) {
            function havePermission($permission)
            {
                return auth()->check() && auth()->user()->hasPermission($permission);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
