<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\ASX;

class ASXServiceProvider extends ServiceProvider
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
        $this->app->singleton('asx', function ($app) {
            return new ASX();
        });
    }
}
