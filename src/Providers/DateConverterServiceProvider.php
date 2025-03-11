<?php

namespace MrIncognito\DateConverter\Providers;

use Illuminate\Support\ServiceProvider;
use MrIncognito\DateConverter\Services\DateConverterService;

class DateConverterServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('dateConverter', function ($app) {
            return new DateConverterService();
        });
    }

    /**
     * @return void
     */
    public function boot()
    {
        // Publish configuration or other bootstrapping logic if needed
    }
}