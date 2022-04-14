<?php

namespace App\Services;

use GuzzleHttp\Client;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use Carbon\Carbon;

class IEX
{
    public function getAvailableSymbols()
    {
        /**
         * Get all Stock Symbols
         */
        $symbols = $this->makeApiCall('get', 'ref-data/symbols');

        /**
         * Only get us stocks
         */
        $symbols = $symbols->where('region', 'US');
        $symbols = $symbols->where('currency', '!=', 'ISK');
        $symbols = $symbols->where('currency', '!=', 'MYR');
        $symbols = $symbols->where('currency', '!=', 'BGN');
        $symbols = $symbols->where('currency', '!=', 'MYR');

        /**
         * Map data to individual collections
         */

        $symbols = $symbols->filter(function ($symbol) {
            return ($symbol['type'] == 'ad' || $symbol['type'] == 'cs' || $symbol['type'] == 'ps');
        });

        $symbols = $symbols->map(function ($symbol) {
            return collect([
                'symbol' => $symbol['symbol'],
                'company_name' => $symbol['name'],
                'currency' => $symbol['currency'],
                'exchange' => $symbol['exchange'],
            ]);
        });

        /**
         * Return symbols
         */
        return $symbols;
    }

    public function getAvailableETFSymbols()
    {
        /**
         * Get all Stock Symbols
         */
        $symbols = $this->makeApiCall('get', 'ref-data/symbols');

        /**
         * Only get us stocks
         */
        $symbols = $symbols->where('region', 'US');
        $symbols = $symbols->where('type', 'et');
        $symbols = $symbols->where('currency', '!=', 'ISK');
        $symbols = $symbols->where('currency', '!=', 'MYR');
        $symbols = $symbols->where('currency', '!=', 'BGN');

        /**
         * Map data to individual collections
         */
        $symbols = $symbols->map(function ($symbol) {
            return collect([
                'symbol' => $symbol['symbol'],
                'company_name' => $symbol['name'],
                'currency' => $symbol['currency'],
                'exchange' => $symbol['exchange'],
            ]);
        });

        /**
         * Return symbols
         */
        return $symbols;
    }

    public function getAvailableMFDSymbols()
    {
        /**
         * Get all Symbols
         */
        $symbols = $this->makeApiCall('get', 'ref-data/mutual-funds/symbols');

        /**
         * Only get us sysmbols
         */
        $symbols = $symbols->where('region', 'US');

        /**
         * Map data to individual collections
         */
        $symbols = $symbols->map(function ($symbol) {
            return collect([
                'symbol' => $symbol['symbol'],
                'company_name' => $symbol['name'],
                'exchange' => $symbol['exchange'],
                'currency' => $symbol['currency'],
            ]);
        });

        /**
         * Return symbols
         */
        return $symbols;
    }

    public function getAvailableLSESymbols()
    {
        /**
         * Get all Symbols
         */
        $symbols = $this->makeApiCall('get', '/stable/ref-data/exchange/XLON/symbols');
        /**
         * Only get us sysmbols
         */
        $symbols = $symbols->where('type', 'cs');

        /**
         * Map data to individual collections
         */


        $symbols = $symbols->map(function ($symbol) {
            return collect([
                'symbol' => $symbol['symbol'],
                'company_name' => $symbol['name'],
                'currency' => $symbol['currency'],
                'exchange' => $symbol['exchange']
            ]);
        });

        /**
         * Return symbols
         */
        return $symbols;
    }

    public function getAvailableCryptoSymbols()
    {
        $client = new CoinGeckoClient();
        $symbols = $client->coins()->getList();
        /**
         * Map data to individual collections
         */

        $results = [];

        foreach ($symbols as $item) {
            if ($item['symbol'] != "")
                array_push($results, collect([
                    'symbol' => $item['symbol'],
                    'name' => $item['name'],
                    'coin_id' => $item['id'],
                    'currency' => 'USD',
                    'msymbol' => $item['symbol'] . '-usd',
                ]));
        }
        /**
         * Return symbols
         */
        return $results;
    }

    public function getMarketCryptos()
    {
        $client = new CoinGeckoClient();
        $feeds = $client->coins()->getMarkets('usd', ['page' => '1', 'per_page' => '5']);
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

    public function getDetails(string $symbol)
    {
        /**
         * Get data in 1 api call
         */
        $data = $this->getBatchData([$symbol], ['price', 'company', 'quote']);

        /**
         * Return first symbol
         */
        return $data->first();
    }

    public function getCDetails(string $coin_id)
    {
        $client = new CoinGeckoClient();
        $result = $client->coins()->getCoin($coin_id, ['tickers' => 'false', 'market_data' => 'true', 'community_data' => 'false', 'developer_data' => 'false', 'sparkline' => 'false']);
        return $result;
    }

    public function getChart(string $symbol, string $range = '1m')
    {

        /**
         * Add interval on url depending on the range
         */
        switch ($range) {

            case '2y':
            case '5y':
                return $this->makeApiCall('GET', 'stock/' . $symbol . '/chart/' . $range, [
                    'chartInterval' => 5,
                ]);
                break;

            default:
                $url = 'stock/' . $symbol . '/chart/' . $range;
                return $this->makeApiCall('GET', $url);
                break;
        }
    }

    public function getCChart(string $coin_id, string $range = '5d')
    {
        $client = new CoinGeckoClient();

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

        $result = $client->coins()->getMarketChartRange($coin_id, 'usd', $start_date->timestamp, Carbon::now()->timestamp);
        return $result['prices'];
    }

    public function getRecentNews(array $symbols, int $limit)
    {

        /**
         * News Articles
         */
        $news = collect();

        /**
         * Get data in 1 api call
         */
        $data = $this->getBatchData($symbols, ['news']);

        /**
         * Add articles to the news collection
         */
        $data->each(function ($item, $key) use ($news) {

            if (isset($item['news'])) {

                foreach ($item['news'] as $article) {

                    $news->push($article);
                }
            }
        });

        /**
         * Order news articles
         */
        $news = $news->sortByDesc('datetime');

        /**
         * Make sure all elements are unique
         */
        $news = $news->unique('url');

        /**
         * Limit the results
         */
        $news = $news->take($limit);

        /**
         * Return news
         */
        return $news->values();
    }

    public function getBatchData(array $symbols, array $types = ['price', 'chart'], string $range = '1m')
    {
        /**
         * Make Batch Request
         */
        $symbols = $this->makeApiCall('GET', 'stock/market/batch', [
            'symbols' => implode(',', $symbols),
            'types' => implode(',', $types),
            'range' => $range,
        ]);

        /**
         * Return symbols
         */
        return $symbols;
    }

    public function getRates($currency_str)
    {
        $rates = $this->makeApiCall('get', '/stable/fx/latest', ['symbols' => $currency_str]);
        /**
         * Map data to individual collections
         */

        $result = array();

        $rates = $rates->map(function ($symbol) {
            return [$symbol['symbol'] => $symbol['rate']];
        });

        foreach ($rates as $rate) {
            array_push($result, $rate);
        }

        $result = call_user_func_array('array_merge', $result);

        /**
         * Return symbols
         */
        return $result;
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
            'base_uri' => config('services.iex.url'),
        ]);

        /**
         * Make API Call
         */
        $response = $client->request($method, $path, [
            'query' => array_merge($query, [
                'token' => config('services.iex.token'),
            ])
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
