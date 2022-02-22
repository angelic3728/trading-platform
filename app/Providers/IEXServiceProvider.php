<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\IEX;

class IEXServiceProvider extends ServiceProvider
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
        $this->app->singleton('iex', function ($app) {
            return new IEX();
        });
    }
}
