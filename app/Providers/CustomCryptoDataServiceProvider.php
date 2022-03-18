<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\CustomCryptoData;

class CustomCryptoDataServiceProvider extends ServiceProvider
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
        $this->app->singleton('custom-crypto-data', function ($app) {
            return new CustomCryptoData();
        });
    }
}
