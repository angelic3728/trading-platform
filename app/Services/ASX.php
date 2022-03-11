<?php

namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;

class ASX
{

    public function getAvailableSymbols()
    {
        /**
         * Get all ASX Symbols
         */
        $symbols = $this->makeApiCall('get', 'companies/list-by-exchange', ['ExchangeCode' => 'ASX']);

        /**
         * Map data to individual collections
         */
        $symbols = $symbols->map(function ($symbol) {
            return collect([
                'symbol' => $symbol['symbol'],
                'company_name' => $symbol['companyName'],
                'currency' => 'AUS',
                'exchange' => 'ASX',
            ]);
        });

        /**
         * Return symbols
         */
        return $symbols;
    }

    public function getDetails($symbol)
    {
        /**
         * Get all ASX Symbols
         */
        $details = $this->makeApiCall('get', 'stock-metadata', ['Symbol' => $symbol]);

        /**
         * Map data to individual collections
         */
        $details = collect([
            'price' => $details['result']['regularMarketPrice'],
            'change_percentage' => $details['regularMarketChangePercent'],
            'description' => $details['quoteSourceName'],
            'exchange' => $details['exchange'],
            'change_percentage' => $details['regularMarketChangePercent'],
            'industry' => $details['shortName'],
            'sector' => '',
            'website' => '',
            'latest_price' => $details['regularMarketOpen'],
            'previous_close' => $details['regularMarketPreviousClose'],
            'market_cap' => '',
            'volume' => $details['regularMarketVolume'],
            'avg_total_volume' => $details['averageDailyVolume3Month'],
            'pe_ratio' => '',
        ]);

        /**
         * Return symbols
         */
        return $details;
    }

    public function getChart(string $symbol, string $range = '1m')
    {

        /**
         * Add interval on url depending on the range
         */

        $start_date = '';
        $end_date = '';


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


        return $this->makeApiCall('GET', 'stock-prices', [
            'EndDateInclusive' => $start_date,
            'StartDateInclusive' => $end_date,
            'Symbol' => $symbol,
            'OrderBy' => 'Ascending'
        ]);
    }

    /**
     * Make API Call
     *
     * @param  string $path
     * @param  string $method
     * @param  array  $query
     * @return Collection
     */
    protected function makeApiCall($method, $path, $query = [])
    {

        /**
         * Prepare Client
         */
        $client = new Client([
            'base_uri' => config('services.asx.url'),
        ]);

        $api_host = str_replace(config('services.asx.url'), 'https://', '');

        /**
         * Make API Call
         */
        $response = $client->request($method, $path, [
            'headers' => ['x-rapidapi-host' => $api_host, 'x-rapidapi-key' => config('services.asx.apikey')],
            'query' => $query
        ]);

        /**
         * Decode response
         */
        $response = json_decode($response->getBody(), true);

        /**
         * Create collection for response
         */
        return collect($response);
    }
}
