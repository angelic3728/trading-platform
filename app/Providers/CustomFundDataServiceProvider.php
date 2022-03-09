<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\CustomFundData;

class CustomFundDataServiceProvider extends ServiceProvider
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
        $this->app->singleton('custom-fund-data', function ($app) {
            return new CustomFundData();
        });
    }
}
