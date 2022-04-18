<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\User;
use App\Observers\UserObserver;

use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        /**
         * Observers
         */
        User::observe(UserObserver::class);


        /**
         * Create View Composers
         */
        View::composer([
            'dashboard.overview',
            'dashboard.xtbs.all',
            'dashboard.documents.all',
            'dashboard.stocks.search',
            'dashboard.stocks.details',
            'dashboard.funds.search',
            'dashboard.funds.details',
            'dashboard.bonds.search',
            'dashboard.bonds.details',
            'dashboard.cryptos.search',
            'dashboard.cryptos.details',
            'dashboard.transactions.all',
            'dashboard.news',
            'dashboard.settings',
            'forms.main',
            'forms.equities',
            'forms.fixed_income',
        ], 'App\Http\View\Composers\WidgetItemsComposer');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
