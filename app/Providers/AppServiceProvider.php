<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Register the errors view namespace
        View::addNamespace('errors', resource_path('views/errors'));

        try {
            $timezone = SiteSetting::where('key', 'timezone')->value('value') ?? 'UTC';
            config(['app.timezone' => $timezone]);
            date_default_timezone_set($timezone);
        } catch (\Throwable $e) {
            config(['app.timezone' => 'UTC']);
            date_default_timezone_set('UTC');
        }
    }
}
