<?php

namespace App\Providers;

use App\Services\EndpointService;
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
        $this->app->singleton(EndpointService::class, function () {
            return new EndpointService();
        });
    }
}
