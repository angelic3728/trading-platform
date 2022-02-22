<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\CustomStockData;

class CustomStockDataServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('custom-stock-data', function ($app) {
            return new CustomStockData();
        });
    }
}
