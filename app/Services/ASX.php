<?php

namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;
use Exception;

use App\Bond;
use App\BondPrice;

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

    public function getAvailableBondCodes()
    {
        $html1 = $this->get_web_page("https://xtbs.com.au/all-available-xtbs/");
        $dom1 = new \DOMDocument();
        @$dom1->loadHTML($html1);
        $x1 = new \DOMXPath($dom1);

        $xtb_data = array();
        foreach ($x1->query("//ul[@id='counter']/li") as $li) {
            $span = $x1->query('./div/span', $li);

            array_push($xtb_data, collect([
                'code' => $span->item(0)->nodeValue,
                'name' => trim($span->item(1)->nodeValue),
                'exchange' => 'XTB',
                'is_indexed' => 0
            ]));
        }

        $html2 = file_get_contents("https://asx.api.markitdigital.com/asx-research/1.0/bonds/government/exchange-traded?height=288&width=1110");
        $html2 = json_decode($html2, true);
        $items_2 = $html2['data']['items'];
        $etb_data1 = array();

        foreach ($items_2 as $item) {
            array_push($etb_data1, collect([
                'code' => $item['symbol'],
                'name' => $item['securityDescription'],
                'exchange' => 'ETB',
                'is_indexed' => 1
            ]));
        }

        $html3 = file_get_contents("https://asx.api.markitdigital.com/asx-research/1.0/bonds/government/exchange-traded-indexed?height=288&width=1110");
        $html3 = json_decode($html3, true);
        $items_3 = $html3['data']['items'];
        $etb_data2 = array();

        foreach ($items_3 as $item) {
            array_push($etb_data2, collect([
                'code' => $item['symbol'],
                'name' => $item['securityDescription'],
                'exchange' => 'ETB',
                'is_indexed' => 2
            ]));
        }

        $result = array_merge($xtb_data, $etb_data1);
        $result = array_merge($result, $etb_data2);
        return $result;
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
            $details = $this->makeCApiCall('get', 'coins/' . $coin_id, ['localization' => 'false', 'tickers' => 'false', 'community_data' => 'false', 'developer_data' => 'false', 'sparkline' => 'false']);
        } catch (Exception $e) {
            $details = null;
        }

        return $details;
    }

    public function getEDetails($code, $indexed)
    {
        if ($indexed == 1) {
            $seed = file_get_contents("https://asx.api.markitdigital.com/asx-research/1.0/bonds/government/exchange-traded?height=288&width=1110");
            $seed = json_decode($seed, true);
            $items = $seed['data']['items'];

            $result = array();

            for ($i = 0; $i < count($items); $i++) {
                if ($items[$i]['symbol'] == $code)
                    $result = $items[$i];
            }

            return $result;
        } else {
            $seed = file_get_contents("https://asx.api.markitdigital.com/asx-research/1.0/bonds/government/exchange-traded-indexed?height=288&width=1110");
            $seed = json_decode($seed, true);
            $items = $seed['data']['items'];

            $result = array();

            for ($i = 0; $i < count($items); $i++) {
                if ($items[$i]['symbol'] == $code)
                    $result = $items[$i];
            }

            return $result;
        }
    }

    public function getXDetails($code)
    {
        $html1 = $this->get_web_page("https://xtbs.com.au/all-available-xtbs/");
        $dom1 = new \DOMDocument();
        @$dom1->loadHTML($html1);
        $x1 = new \DOMXPath($dom1);

        $result = array();

        foreach ($x1->query("//ul[@id='counter']/li") as $li) {
            $span = $x1->query('./div/span', $li);
            $type = $x1->query('./div/span/i', $li);
            $mcode = $span->item(0)->nodeValue;
            if ($mcode == $code) {
                $result['code'] = $span->item(0)->nodeValue;
                $result['issuer'] = trim($span->item(1)->nodeValue);
                $result['maturity_date'] = $span->item(2)->nodeValue;
                $result['coupon_type'] = ($type->item(0)->getAttribute('class') == "icon-fixed") ? "Fixed Rate" : "Floating Rate";
                $result['next_ex_date'] = $span->item(4)->nodeValue;
                $result['coupon_pa'] = $span->item(5)->nodeValue;
                $result['xtb_price'] = $span->item(6)->nodeValue;
                $result['ytm'] = $span->item(7)->nodeValue;
                $result['current_yield'] = $span->item(8)->nodeValue;
                $result['trading_margin'] = $span->item(9)->nodeValue;
            }
        }

        return $result;
    }

    public function getChart(string $symbol, string $range = '1m')
    {

        $chartInfo = $this->makeApiCall('GET', 'daily-price/' . $symbol, []);

        /**
         * Add interval on url depending on the range
         */

        $start_date = '';


        switch ($range) {
            case '7d':
                $start_date = Carbon::now()->subDays(7);
                break;

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

            case '7d':
                $start_date = Carbon::now()->subDays(7);
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
        $result = $this->makeCApiCall('get', 'coins/' . $coin_id . '/market_chart/range', ['from' => $start_date->timestamp, 'to' => Carbon::now()->timestamp, 'vs_currency' => 'usd']);
        return $result['prices'];
    }

    function getBPrice($symbol)
    {

        /**
         * Find Bond
         */
        $bond = Bond::query()
            ->where('symbol', $symbol)
            ->first();

        /**
         * Return Fund Price
         */

        $item = BondPrice::query()
            ->where('bond_id', $bond->id)
            ->latest()
            ->first();

        return ($item) ? $item->price : 0;
    }

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
        if (isset($bond_price_today) && isset($bond_price_yesterday)) {

            return (1 - floatval($bond_price_yesterday->price) / floatval($bond_price_today->price));
        } else {

            return 0;
        }
    }

    function getBChart($bond_id, $range)
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
                break;

            case '3m':
                $start_date = Carbon::now()->subMonths(3);
                break;

            case '6m':
                $start_date = Carbon::now()->subMonths(3);
                break;
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

        $end_date = Carbon::now();

        /**
         * Get all fund prices between those dates
         */
        $prices = BondPrice::query()
            ->where('bond_id', $bond_id)
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item) {
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

    public function getMarketCryptos()
    {
        $feeds = $this->makeCApiCall('get', 'coins/markets', ['vs_currency' => 'usd', 'page' => '1', 'per_page' => '5']);
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

    function get_web_page($url = '', $option = array(), $getinfo = false)
    {
        $curl = curl_init($url);

        $option[CURLOPT_RETURNTRANSFER] = 1;
        $option[CURLOPT_SSL_VERIFYPEER] = 0;
        $option[CURLOPT_HEADER] = 0;
        $option[CURLOPT_TIMEOUT] = 30;
        $option[CURLOPT_CONNECTTIMEOUT] = 30;
        $option[CURLOPT_DNS_USE_GLOBAL_CACHE] = false;
        $option[CURLOPT_FOLLOWLOCATION] = true;
        $option[CURLOPT_MAXREDIRS] = 5;
        $option[CURLOPT_USERAGENT] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.63 Safari/537.36';

        curl_setopt_array($curl, $option);

        $content = curl_exec($curl);

        $data = curl_getinfo($curl); // get the CURL info.
        $data['error'] = curl_error($curl); // get error messsage occured
        $data['errno'] = curl_errno($curl); // get error number
        $data['content'] = $content;
        curl_close($curl);
        if ($getinfo)
            // info + content
            return $data;
        else
            // just content
            return $data['content'];
    }
}
