<?php

namespace App\Services;

use GuzzleHttp\Client;

use Carbon\Carbon;

class IEX
{

    public function getAvailableSymbols(){
        /**
         * Get all Symbols
         */
        $symbols = $this->makeApiCall('get', 'ref-data/symbols');

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
            ]);
        });

        /**
         * Return symbols
         */
        return $symbols;
    }

    public function getDetails(string $symbol, string $range = '1m'){

        /**
         * Get data in 1 api call
         */
        $data = $this->getBatchData([$symbol], ['price', 'company', 'quote']);

        /**
         * Return first symbol
         */
        return $data->first();

    }

    public function getChart(string $symbol, string $range = '1m'){

        /**
         * Add interval on url depending on the range
         */
        switch ($range) {

            case '2y':
            case '5y':
                return $this->makeApiCall('GET', 'stock/'.$symbol.'/chart/'.$range, [
                    'chartInterval' => 5,
                ]);
                break;

            default:
                $url = 'stock/'.$symbol.'/chart/'.$range;
                return $this->makeApiCall('GET', 'stock/'.$symbol.'/chart/'.$range);
                break;

        }

    }

    public function getRecentNews(array $symbols, int $limit){

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

            if(isset($item['news'])){

                foreach($item['news'] as $article){

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

    public function getBatchData(array $symbols, array $types = ['price', 'chart'], string $range = '1m'){

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

    /**
     * Make API Call
     *
     * @param  string $path
     * @param  string $method
     * @param  array  $query
     * @return Collection
     */
    protected function makeApiCall($method, $path, $query = []){

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
