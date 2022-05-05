<?php
namespace App\Services;

use App\Bond;
use App\BondPrice;

use Carbon\Carbon;

class CustomBondData
{

    /**
     * Finds latest price for Bond
     *
     * @param string $symbol
     * @return float
     */
    function price($symbol)
    {

        /**
         * Find Bond
         */
        $bond = Bond::query()
            ->where('symbol', $symbol)
            ->first();

        /**
         * Return Bond Price
         */

        $item = BondPrice::query()
        ->where('bond_id', $bond->id)
        ->latest()
        ->first();

        return ($item)?$item->price:0;

    }

    /**
     * Returns change percentage for bond
     * @param  string $symbol
     * @return mixed
     */
    function changePercentage($symbol)
    {

        /**
         * Find Bond
         */
        $bond = Bond::query()
            ->where('symbol', $symbol)
            ->first();

        /**
         * Get Yesterdays Price
         */
        $bond_price_yesterday = BondPrice::query()
            ->where('bond_id', $bond->id)
            ->where('date', Carbon::yesterday())
            ->first();

        /**
         * Get Todays Price
         */
        $bond_price_today = BondPrice::query()
            ->where('bond_id', $bond->id)
            ->where('date', Carbon::today())
            ->first();

        /**
         * Show change percentage if both are available
         */
        if(isset($bond_price_today) && isset($bond_price_yesterday)){

            return (1 - floatval($bond_price_yesterday->price) / floatval($bond_price_today->price));

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
    function chart($bond_id, $range="1m")
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
         * Get all bond prices between those dates
         */
        $prices = BondPrice::query()
            ->where('bond_id', $bond_id)
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
