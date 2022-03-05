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
     * Mutual Funds
     */
    Route::get('mfds/search', 'MutualFundsController@index')->name('mfds.search');
    Route::get('mfds/{symbol}', 'MutualFundsController@show')->name('mfds.show');

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
         * Get mutual funds stocks
         */
        Route::get('mfds/investments', 'MutualFundsController@investments');
        Route::get('mfds/highlights', 'MutualFundsController@highlights');
        Route::get('mfds/all', 'MutualFundsController@all');
        Route::get('mfds/chart/{symbol}/{range}', 'MutualFundsController@chart');
        Route::get('mfds/{symbol}', 'MutualFundsController@details');

        /**
         * Trading
         */
        Route::post('mstocks/{symbol}/{action}', 'MutualFundsController@trade');

        /**
         * Documents
         */
        Route::post('documents', 'DocumentController@store')->name('api.documents.store');

        /**
         * Recent News
         */
        Route::get('news', 'NewsController@overview')->name('api.news.overview');

    });

});
