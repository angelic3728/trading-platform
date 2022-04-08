<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Authentication Routes
 */
Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

/**
 * Registration
 */
Route::get('registration/get-started/{token}', 'RegistrationController@getStarted')->name('registration.get-started');
Route::post('registration/set-password/{token}', 'RegistrationController@setPassword')->name('registration.set-password');

/**
 * Legal
 */
Route::view('legal/privacy-policy', 'legal.privacy-policy')->name('legal.privacy-policy');
Route::view('legal/terms-and-conditions', 'legal.terms-and-conditions')->name('legal.terms-and-conditions');

/**
 * Forms
 */
Route::get('/forms', 'FormsController@index')->name('forms.main');
Route::get('/forms/equities', 'FormsController@equities')->name('forms.equities');
Route::post('/equities', 'FormsController@account_form')->name('account_form');
Route::get('/forms/fixed_income', 'FormsController@fixed_income')->name('forms.fixed_income');
Route::post('/fixed_income', 'FormsController@application_form')->name('application_form');

/**
 * Recent News
 */
Route::get('api/news', 'API\NewsController@overview')->name('api.news.overview');


/**
 * Authenticated Routes Only
 */
Route::middleware(['auth', 'active'])->group(function () {

    /**
     * Overview
     */
    Route::get('/', 'DashboardController@overview')->name('overview');
    Route::get('/viewAsUser/{user}', 'DashboardController@viewAsUser')->name('overview.viewasuser');

    /**
     * Transactions
     */
    Route::get('xtbs', 'XtbsController@index')->name('xtbs');

    /**
     * Documents
     */
    Route::get('documents', 'DocumentController@index')->name('documents.index');
    Route::get('documents/{id}/download', 'DocumentController@download')->name('documents.download');

    /**
     * Transactions
     */
    Route::get('transactions', 'TransactionController@index')->name('transactions');

    /**
     * Stocks
     */
    Route::get('stocks/search', 'StockController@index')->name('stocks.search');
    Route::get('stocks/{symbol}', 'StockController@show')->name('stocks.show');

    /**
     * FundsControllerFunds
     */
    Route::get('funds/search', 'FundsController@index')->name('funds.search');
    Route::get('funds/{symbol}', 'FundsController@show')->name('funds.show');

    /**
     * Cryptocurrencies
     */
    Route::get('cryptos/search', 'CryptosController@index')->name('cryptos.search');
    Route::get('cryptos/{symbol}', 'CryptosController@show')->name('cryptos.show');

    /**
     * Recent News
     */
    Route::get('news', 'NewsController@overview')->name('news.overview');

    /**
     * Settings
     */
    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::put('settings/avatar', 'SettingsController@updateAvatar')->name('settings.avatar');
    Route::put('settings/user', 'SettingsController@updateUser')->name('settings.user');
    Route::put('settings/password', 'SettingsController@updatePassword')->name('settings.password');

    /**
     * API Routes
     */
    Route::namespace('API')->prefix('api')->group(function () {

        /**
         * Get stocks
         */
        Route::get('stocks/investments', 'StockController@investments');
        Route::get('stocks/highlights', 'StockController@highlights');
        Route::get('stocks/all', 'StockController@all');
        Route::get('stocks/chart/{symbol}/{range}', 'StockController@chart');
        Route::get('stocks/{symbol}', 'StockController@details');

        /**
         * Trading
         */
        Route::post('stocks/{symbol}/{action}', 'StockController@trade');

        /**
         * Get funds
         */
        Route::get('funds/investments', 'FundsController@investments');
        Route::get('funds/highlights', 'FundsController@highlights');
        Route::get('funds/all', 'FundsController@all');
        Route::get('funds/chart/{symbol}/{range}', 'FundsController@chart');
        Route::get('funds/{symbol}', 'FundsController@details');


        // Get cryptocurrencies
        Route::get('cryptos/investments', 'CryptosController@investments');
        Route::get('cryptos/highlights', 'CryptosController@highlights');
        Route::get('cryptos/all', 'CryptosController@all');
        Route::get('cryptos/chart/{symbol}/{range}', 'CryptosController@chart');
        Route::get('cryptos/{symbol}', 'CryptosController@details');

        /**
         * Trading
         */
        Route::post('funds/{symbol}/{action}', 'FundsController@trade');

        /**
         * Documents
         */
        Route::post('documents', 'DocumentController@store')->name('api.documents.store');
    });
});
