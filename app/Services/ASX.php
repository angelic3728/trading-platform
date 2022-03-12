<?php

namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;
use Exception;

class ASX
{

    public function getAvailableSymbols()
    {
        /**
         * Get all Symbols
         */
        $symbols = $this->makeApiCall('get', 'symbols', ['format' => 'json']);

        // only Get ASX stocks
        $symbols = $symbols->where('exchange', 'ASX');

        /**
         * Map data to individual collections
         */
        $results = [];

        foreach ($symbols as $item) {
            array_push($results, collect([
                'symbol' => $item['symbol'],
                'company_name' => $item['name'],
                'currency' => 'AUS',
                'exchange' => 'ASX',
            ]));
        }

        /**
         * Return symbols
         */
        return $results;
    }

    public function getDetails($symbol)
    {
        /**
         * Get Detailed ASX Information
         */
        $intro = [];
        $details = [];

        try {
            $details = $this->makeApiCall('get', 'quote/' . $symbol, ['format' => 'json']);
        } catch(Exception $e) {
            $details = null;
        }

        try {
            $intro = $this->makeApiCall('get', 'search', ['query' => $symbol, 'limit' => 1, 'format' => 'json']);
        } catch(Exception $e) {
            $intro = null;
        }

        /**
         * Map data to individual collections
         */

        $details = collect([
            'price' => $details ? $details[0]['open'] : 0,
            'change_percentage' => $details ? $details[0]['changesPercentage']*0.01 : 0,
            'description' => $intro[0]['name'],
            'exchange' => 'ASX',
            'industry' => $intro[0]['industry'],
            'sector' => $intro[0]['sector'],
            'website' => '',
            'latest_price' => $details ? $details[0]['previousClose'] : 0,
            'previous_close' => $details ? $details[0]['previousClose'] : 0,
            'market_cap' => $details ? $details[0]['marketCap'] : 0,
            'volume' => $details ? $details[0]['volume'] : 0,
            'avg_total_volume' => $details ? $details[0]['avgVolume'] : 0,
            'pe_ratio' => $details ? $details[0]['pe'] : 0,
        ]);

        /**
         * Return symbols
         */
        return $details;
    }

    public function getChart(string $symbol, string $range = '1m')
    {

        $chartInfo = $this->makeApiCall('GET', 'daily-price/' . $symbol, []);

        /**
         * Add interval on url depending on the range
         */

        $start_date = '';


        switch ($range) {

            case '1m':
                $start_date = Carbon::now()->subMonths(1);
                break;

            case '3m':
                $start_date = Carbon::now()->subMonths(3);
                break;

            case '6m':
                $start_date = Carbon::now()->subMonths(3);

            case 'ytd':
                $start_date = Carbon::now()->startOfYear();
                break;

            case '1y':
                $start_date = Carbon::now()->subYears(1);
                break;

            case '2y':
                $start_date = Carbon::now()->subYears(2);
                break;

            case '5y':
                $start_date = Carbon::now()->subYears(5);
                break;

            default:
                return [];
                break;
        }

        $start_date_str = $start_date->toDateString();
        /**
         * News Articles
         */
        $results = collect();

        for ($i = 0; $i < count($chartInfo[0]['historical']); $i++) {
            if ($chartInfo[0]['historical'][$i]['date'] >= $start_date_str)
                $results->push($chartInfo[0]['historical'][$i]);
            else
                break;
        }

        /**
         * Order news articles
         */
        $sorted = $results->sortBy('date');
        $results = $sorted->values()->all();

        return ['results' => $results];
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
