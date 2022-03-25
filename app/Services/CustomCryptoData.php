<?php

namespace App\Services;

use App\CryptoCurrency;
use App\CryptoCurrencyPrice;

use Carbon\Carbon;

class CustomCryptoData
{

    /**
     * Finds latest price for crypto
     *
     * @param string $symbol
     * @return float
     */
    function price($symbol)
    {

        /**
         * Find Crypto
         */
        $crypto = CryptoCurrency::query()
            ->where('symbol', $symbol)
            ->first();

        /**
         * Return Crypto Price
         */

        $item = CryptoCurrencyPrice::query()
        ->where('crypto_currency_id', $crypto->id)
        ->latest()
        ->first();

        return $item->price;
    }

    /**
     * Returns change percentage for crypto
     * @param  string $symbol
     * @return mixed
     */
    function changePercentage($symbol)
    {

        /**
         * Find Crypto
         */
        $crypto = CryptoCurrency::query()
            ->where('symbol', $symbol)
            ->first();

        /**
         * Get Yesterdays Price
         */
        $crypto_price_yesterday = CryptoCurrencyPrice::query()
            ->where('crypto_currency_id', $crypto->id)
            ->where('date', Carbon::yesterday())
            ->first();

        /**
         * Get Todays Price
         */
        $crypto_price_today = CryptoCurrencyPrice::query()
            ->where('crypto_currency_id', $crypto->id)
            ->where('date', Carbon::today())
            ->first();

        /**
         * Show change percentage if both are available
         */
        if (isset($crypto_price_today) && isset($crypto_price_yesterday)) {

            return (1 - floatval($crypto_price_yesterday->price) / floatval($crypto_price_today->price));
        } else {

            return 0;
        }
    }

    /**
     * Prepare chart
     *
     * @param  string $symbol
     * @param  string $range
     * @return array
     */
    function chart($symbol, $range)
    {

        /**
         * Determine start and end date
         */
        switch ($range) {

            case '1d':
                $start_date = Carbon::now()->startOfDay();
                break;

            case '5d':
                $start_date = Carbon::now()->subDays(5);
                break;

            case '1m':
                $start_date = Carbon::now()->subMonths(1);

            case '6m':
                $start_date = Carbon::now()->subMonths(6);

            case 'ytd':
                $start_date = Carbon::now()->startOfYear();
                break;

            case '1y':
                $start_date = Carbon::now()->subYears(1);
                break;

            case '5y':
                $start_date = Carbon::now()->subYears(5);
                break;

            default:
                return [];
                break;
        }

        /**
         * Find Crypto
         */
        $crypto = CryptoCurrency::query()
            ->where('symbol', $symbol)
            ->first();

        /**
         * Get all crypto prices between those dates
         */
        $prices = CryptoCurrencyPrice::query()
            ->where('crypto_currency_id', $crypto->id)
            ->whereBetween('date', [$start_date, Carbon::now()])
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item, $key) {
                return [$item->date->toDateString(), floatval($item->price)];
            });

        /**
         * Return Prices
         */
        return $prices;
    }
}
