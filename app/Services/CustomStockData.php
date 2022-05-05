<?php

namespace App\Services;

use App\Stock;
use App\StockPrice;

use Carbon\Carbon;

class CustomStockData
{

    /**
     * Finds latest price for stock
     *
     * @param string $symbol
     * @return float
     */
    function price($symbol)
    {

        /**
         * Find Stock
         */
        $stock = Stock::query()
            ->where('symbol', $symbol)
            ->first();

        /**
         * Return Stock Price
         */

        $item = StockPrice::query()
            ->where('stock_id', $stock->id)
            ->latest()
            ->first();

        return $item->price;
    }

    /**
     * Returns change percentage for stock
     * @param  string $symbol
     * @return mixed
     */
    function changePercentage($symbol)
    {

        /**
         * Find Stock
         */
        $stock = Stock::query()
            ->where('symbol', $symbol)
            ->first();

        /**
         * Get Yesterdays Price
         */
        $stock_price_yesterday = StockPrice::query()
            ->where('stock_id', $stock->id)
            ->where('date', Carbon::yesterday())
            ->first();

        /**
         * Get Todays Price
         */
        $stock_price_today = StockPrice::query()
            ->where('stock_id', $stock->id)
            ->where('date', Carbon::today())
            ->first();

        /**
         * Show change percentage if both are available
         */
        if (isset($stock_price_today) && isset($stock_price_yesterday)) {

            return (1 - floatval($stock_price_yesterday->price) / floatval($stock_price_today->price));
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
            case '7d':
                $start_date = Carbon::now()->subDays(7);
                break;

            case '1m':
                $start_date = Carbon::now()->subMonths(1);
                $end_date = Carbon::now();
                break;

            case '3m':
                $start_date = Carbon::now()->subMonths(3);
                $end_date = Carbon::now();
                break;

            case '6m':
                $start_date = Carbon::now()->subMonths(3);
                $end_date = Carbon::now();

            case 'ytd':
                $start_date = Carbon::now()->startOfYear();
                $end_date = Carbon::now();
                break;

            case '1y':
                $start_date = Carbon::now()->subYears(1);
                $end_date = Carbon::now();
                break;

            case '2y':
                $start_date = Carbon::now()->subYears(2);
                $end_date = Carbon::now();
                break;

            case '5y':
                $start_date = Carbon::now()->subYears(5);
                $end_date = Carbon::now();
                break;

            default:
                return [];
                break;
        }

        /**
         * Find Stock
         */
        $stock = Stock::query()
            ->where('symbol', $symbol)
            ->first();

        /**
         * Get all stock prices between those dates
         */
        $prices = StockPrice::query()
            ->where('stock_id', $stock->id)
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item, $key) {

                return [
                    'date' => $item->date->toDateString(),
                    'fClose' => floatval($item->price),
                ];
            });

        /**
         * Return Prices
         */
        return $prices;
    }
}
