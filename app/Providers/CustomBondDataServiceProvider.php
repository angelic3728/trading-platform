<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\CustomBondData;

class CustomBondDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('custom-bond-data', function ($app) {
            return new CustomBondData();
        });
    }
}
