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
     * @param string $identifier
     * @return float
     */
    function price($identifier)
    {

        /**
         * Find Stock
         */
        $stock = Stock::query()
            ->where('symbol', $identifier)
            ->first();

        /**
         * Return Stock Price
         */
        return StockPrice::query()
            ->where('stock_id', $stock->id)
            ->latest()
            ->first()
            ->price;

    }

    /**
     * Returns change percentage for stock
     * @param  string $identifier
     * @return mixed
     */
    function changePercentage($identifier)
    {

        /**
         * Find Stock
         */
        $stock = Stock::query()
            ->where('symbol', $identifier)
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
        if(isset($stock_price_today) && isset($stock_price_yesterday)){

            return (1 - floatval($stock_price_yesterday->price) / floatval($stock_price_today->price));

        } else {

            return 0;

        }

    }

    /**
     * Prepare chart
     *
     * @param  string $identifier
     * @param  string $range
     * @return array
     */
    function chart($identifier, $range)
    {

        /**
         * Determine start and end date
         */
        switch ($range) {

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
            ->where('symbol', $identifier)
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
                    'close' => floatval($item->price),
                ];

            });

        /**
         * Return Prices
         */
        return $prices;

    }
}
