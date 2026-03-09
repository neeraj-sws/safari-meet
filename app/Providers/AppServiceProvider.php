<?php

namespace App\Providers;

use App\Contracts\Repositories\ParkRepositoryInterface;
use App\Models\SiteSetting;
use App\Repositories\ParkRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
        public function register(): void
    {
        $this->app->bind(ParkRepositoryInterface::class, ParkRepository::class);
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
