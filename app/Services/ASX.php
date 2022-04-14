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
         * Get all asx Symbols
         */
        $symbols = $this->makeApiCall('get', 'search', ['limit' => 10000, 'exchange' => 'ASX', 'country' => 'AU', 'format' => 'json']);

        /**
         * Map data to individual collections
         */
        $results = [];

        foreach ($symbols as $item) {
            array_push($results, collect([
                'symbol' => $item['symbol'],
                'company_name' => $item['name'],
                'currency' => $item['currency'],
                'exchange' => $item['stockExchange'],
            ]));
        }

        /**
         * Return symbols
         */
        return $results;
    }

    public function getAvailableMFDSymbols()
    {
        /**
         * Get all asx Symbols
         */
        $symbols = $this->makeApiCall('get', 'search', ['limit' => 10000, 'exchange' => 'MUTUAL_FUND', 'country' => 'AU', 'format' => 'json']);

        /**
         * Map data to individual collections
         */
        $results = [];

        foreach ($symbols as $item) {
            array_push($results, collect([
                'symbol' => $item['symbol'],
                'company_name' => $item['name'],
                'currency' => $item['currency'],
                'exchange' => $item['stockExchange'],
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
        } catch (Exception $e) {
            $details = null;
        }

        try {
            $intro = $this->makeApiCall('get', 'search', ['query' => $symbol, 'limit' => 1, 'format' => 'json']);
        } catch (Exception $e) {
            $intro = null;
        }

        /**
         * Map data to individual collections
         */
        if ($details) {
            $details = collect([
                'price' => $details ? $details[0]['open'] : 0,
                'change_percentage' => $details ? $details[0]['changesPercentage'] * 0.01 : 0,
                'description' => ($intro && count($intro) != 0) ? $intro[0]['name'] : "",
                'exchange' => 'ASX',
                'industry' => ($intro && count($intro) != 0) ? $intro[0]['industry'] : "",
                'sector' => ($intro && count($intro) != 0) ? $intro[0]['sector'] : "",
                'website' => '',
                'latest_price' => $details ? $details[0]['previousClose'] : 0,
                'previous_close' => $details ? $details[0]['previousClose'] : 0,
                'market_cap' => $details ? $details[0]['marketCap'] : 0,
                'volume' => $details ? $details[0]['volume'] : 0,
                'avg_total_volume' => $details ? $details[0]['avgVolume'] : 0,
                'pe_ratio' => $details ? $details[0]['pe'] : 0,
            ]);
            return $details;
        } else {
            return [];
        }
    }

    public function getCDetails($coin_id)
    {
        $details = [];

        try {
            $details = $this->makeCApiCall('get', 'coins/' . $coin_id, ['localization' => 'false', 'tickers'=>'false', 'community_data'=>'false', 'developer_data'=>'false', 'sparkline'=>'false']);
        } catch (Exception $e) {
            $details = null;
        }

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

        return $results;
    }

    public function getCChart($coin_id, $range)
    {

        $start_date = '';

        switch ($range) {

            case '1d':
                $start_date = Carbon::now()->startOfDay();
                break;

            case '5d':
                $start_date = Carbon::now()->subDays(5);
                break;

            case '1m':
                $start_date = Carbon::now()->subMonths(1);
                break;

            case '6m':
                $start_date = Carbon::now()->subMonths(3);

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
        $result = $this->makeCApiCall('get', 'coins/' . $coin_id . '/market_chart/range', ['from' => $start_date->timestamp, 'to'=>Carbon::now()->timestamp, 'vs_currency'=>'usd']);
        return $result['prices'];
    }

    public function getMarketCryptos()
    {
        $feeds = $this->makeCApiCall('get', 'coins/markets', ['vs_currency'=>'usd', 'page'=>'1', 'per_page'=>'5']);
        $results = [];
        foreach ($feeds as $item) {
            array_push($results, collect([
                'symbol' => $item['symbol'],
                'name' => $item['name'],
                'image' => $item['image'],
                'current_price' => $item['current_price'],
                'market_cap' => $item['market_cap']
            ]));
        }

        return $results;    
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

    protected function makeCApiCall($method, $path, $query = [])
    {

        /**
         * Prepare Client
         */
        $client = new Client([
            'base_uri' => config('services.gecko.url'),
        ]);

        $api_host = str_replace(config('services.gecko.url'), 'https://', '');

        /**
         * Make API Call
         */
        $response = $client->request($method, $path, [
            'headers' => ['x-rapidapi-host' => $api_host, 'x-rapidapi-key' => config('services.gecko.apikey')],
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
