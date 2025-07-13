<?php

namespace MrIncognito\DateConverter\Providers;

use Illuminate\Support\ServiceProvider;
use MrIncognito\DateConverter\Facades\DateConverter;
use MrIncognito\DateConverter\Services\DateConverterService;

class DateConverterServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton('dateConverter', function ($app) {
            return new DateConverterService;
        });

        $this->app->alias('dateConverter', DateConverter::class);
    }

    /**
     * @return void
     */
    public function boot()
    {
        //
    }
}
