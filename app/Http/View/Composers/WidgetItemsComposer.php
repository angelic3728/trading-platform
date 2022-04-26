<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

use IEX;
use ASX;
use Cache;

use App\Stock;
use App\Fund;
use App\Bond;
use App\CryptoCurrency;
use App\Transaction;
use App\Advertise;

use CustomStockData;
use CustomFundData;
use CustomBondData;
use CustomCryptoData;

class WidgetItemsComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['widget_items' => $this->getWidgets(), 'news_symbols' => $this->getNewsSymbols(), 'ads' => $this->getAds()]);
    }

    /**
     * Prepare Stock Widget Data
     */
    public function getWidgets()
    {

        /**
         * Get widget stocks, funds and cryptos
         */
        // $stocks = Stock::where('widget', true)->take(4)->get();
        // $funds = Fund::where('widget', true)->take(4)->get();
        // $cryptos = CryptoCurrency::where('widget', true)->take(4)->get();
        $stocks = Cache::remember('stocks:widget', 15, function () {
            return Stock::where('widget', true)->take(4)->get();
        });

        $funds = Cache::remember('funds:widget', 15, function () {
            return Fund::where('widget', true)->take(4)->get();
        });

        $bonds = Bond::where('widget', true)->take(4)->get();

        $cryptos = Cache::remember('cryptos:widget', 15, function () {
            return CryptoCurrency::where('widget', true)->take(4)->get();
        });
        // print_r($stocks); die();

        /**
         * Get Prices and Chart from IEX
         */

        $iex_stock_data = Cache::remember('stocks:batch_data', 15, function () use ($stocks) {
            return IEX::getBatchData($stocks->where('data_source', 'iex')->pluck('symbol')->toArray(), ['price', 'chart', 'quote'], '1m');
        });

        $iex_fund_data = Cache::remember('funds:batch_data', 15, function () use ($funds) {
            return IEX::getBatchData($funds->where('data_source', 'iex')->pluck('symbol')->toArray(), ['price', 'chart', 'quote'], '1m');
        });

        /**
         * For each stock, add the price
         */
        $stock_results = (count($stocks) == 0) ? [] : $stocks->map(function ($stock) use ($iex_stock_data) {
            /**
             * Make collection of stock
             */
            $c_stock = collect($stock);
            $c_stock->put('wherefrom', 'stock');

            /**
             * Add extra fields before returning it
             */
            switch ($c_stock['data_source']) {
                case 'iex':
                    $c_stock->put('price', array_get($iex_stock_data, $c_stock->get('symbol') . '.price'));
                    $c_stock->put('chart', array_get($iex_stock_data, $c_stock->get('symbol') . '.chart'));
                    $c_stock->put('change_percentage', array_get($iex_stock_data, $c_stock->get('symbol') . '.quote.changePercent'));
                    break;

                case 'asx':
                    $asx_data = Cache::remember('stocks:widget-asx-detail-' . $c_stock->get('symbol'), 15, function () use ($c_stock) {
                        return ASX::getDetails($c_stock->get('symbol'));
                    });
                    $asx_chart = Cache::remember('stocks:widget-asx-chart-' . $c_stock->get('symbol'), 15, function () use ($c_stock) {
                        return ASX::getChart($c_stock->get('symbol'), '1m');
                    });
                    $c_stock->put('price', array_get($asx_data, 'price'));
                    $c_stock->put('chart', $asx_chart);
                    $c_stock->put('change_percentage', array_get($asx_data, 'change_percentage'));
                    break;

                case 'custom':
                    $c_stock->put('price', $c_stock->formatPrice(CustomStockData::price($c_stock->get('symbol'))));
                    $c_stock->put('chart', CustomStockData::chart($c_stock->get('symbol'), '1m'));
                    $c_stock->put('change_percentage', CustomStockData::changePercentage($c_stock->get('symbol')));
                    break;

                default:
                    $c_stock->put('price', null);
                    $c_stock->put('chart', null);
                    $c_stock->put('change_percentage', null);
                    break;
            }

            /**
             * Return stock
             */
            return $c_stock->only('wherefrom', 'symbol', 'company_name', 'price', 'chart', 'change_percentage', 'exchange', 'gcurrency', 'data_source');
        });

        $fund_results = (count($funds) == 0) ? [] : $funds->map(function ($fund) use ($iex_fund_data) {

            /**
             * Make collection of fund
             */
            $c_fund = collect($fund);
            $c_fund->put('wherefrom', 'fund');

            /**
             * Add extra fields before returning it
             */
            switch ($c_fund['data_source']) {

                case 'iex':
                    if ($c_fund->get('exchange') != "NAS") {
                        $c_fund->put('price', array_get($iex_fund_data, $c_fund->get('symbol') . '.price'));
                        $c_fund->put('chart', array_get($iex_fund_data, $c_fund->get('symbol') . '.chart'));
                        $c_fund->put('change_percentage', array_get($iex_fund_data, $c_fund->get('symbol') . '.quote.changePercent'));
                    } else {
                        $asx_data = Cache::remember('funds:widget-nas-detail-' . $c_fund->get('symbol'), 18, function () use ($c_fund) {
                            return ASX::getDetails($c_fund->get('symbol'));
                        });
                        $asx_chart = Cache::remember('funds:widget-nas-chart-' . $c_fund->get('symbol'), 22, function () use ($c_fund) {
                            return ASX::getChart($c_fund->get('symbol'), '1m');
                        });
                        $c_fund->put('price', array_get($asx_data, 'price'));
                        $c_fund->put('chart', $asx_chart);
                        $c_fund->put('change_percentage', array_get($asx_data, 'change_percentage'));
                    }
                    break;

                case 'asx':
                    $asx_data = Cache::remember('funds:widget-asx-detail-' . $c_fund->get('symbol'), 18, function () use ($c_fund) {
                        return ASX::getDetails($c_fund->get('symbol'));
                    });
                    $asx_chart = Cache::remember('funds:widget-asx-chart-' . $c_fund->get('symbol'), 22, function () use ($c_fund) {
                        return ASX::getChart($c_fund->get('symbol'), '1m');
                    });
                    $c_fund->put('price', array_get($asx_data, 'price'));
                    $c_fund->put('chart', $asx_chart);
                    $c_fund->put('change_percentage', array_get($asx_data, 'change_percentage'));
                    break;

                case 'custom':
                    $c_fund->put('price', CustomFundData::price($c_fund->get('symbol')));
                    $c_fund->put('chart', CustomFundData::chart($c_fund->get('symbol')));
                    $c_fund->put('change_percentage', CustomFundData::changePercentage($c_fund->get('symbol')));
                    break;

                default:
                    $c_fund->put('price', null);
                    $c_fund->put('chart', null);
                    $c_fund->put('change_percentage', null);
                    break;
            }

            /**
             * Return fund
             */
            return $c_fund->only('wherefrom', 'symbol', 'company_name', 'price', 'chart', 'change_percentage', 'exchange', 'gcurrency', 'data_source');
        });

        $bond_results = (count($bonds) == 0) ? [] : $bonds->map(function ($bond) {
            /**
             * Make collection of bond
             */
            $c_bond = collect($bond);
            $c_bond->put('wherefrom', 'bond');

            /**
             * Add extra fields before returning it
             */
            switch ($c_bond['data_source']) {
                case 'asx':
                    $price = ASX::getBPrice($c_bond->get('symbol'));
                    $changePercentage = ASX::changePercentage($c_bond->get('symbol'));
                    $chart = ASX::getBChart($c_bond->get('id'), '1m');

                    $c_bond->put('price', $price);
                    $c_bond->put('chart', $chart);
                    $c_bond->put('change_percentage', $changePercentage);
                    break;

                case 'custom':
                    $c_bond->put('price', $c_bond->formatPrice(CustomBondData::price($c_bond->get('symbol'))));
                    $c_bond->put('chart', CustomBondData::chart($c_bond->get('id'), '1m'));
                    $c_bond->put('change_percentage', CustomBondData::changePercentage($c_bond->get('symbol')));
                    break;

                default:
                    $c_bond->put('price', null);
                    $c_bond->put('chart', null);
                    $c_bond->put('change_percentage', null);
                    break;
            }

            /**
             * Return bond
             */
            return $c_bond->only('wherefrom', 'symbol', 'name', 'price', 'chart', 'change_percentage', 'exchange', 'gcurrency', 'data_source');
        });

        $crypto_results = [];
        $cnt = 0;
        if (count($cryptos) != 0)
            foreach ($cryptos as $crypto) {
                switch ($crypto['data_source']) {
                    case 'gecko':
                        try {
                            $cnt++;
                            $chart = Cache::remember('cryptos:widget-gecko-chart-' . $crypto->coin_id, (10 + $cnt), function () use ($crypto) {
                                return ASX::getCChart($crypto->coin_id, '5d');
                            });

                            $crypto_data = Cache::remember('crypto:widget-detail-info'.$crypto->coin_id, 8, function() use ($crypto) {
                                return ASX::getCDetails($crypto->coin_id);
                            });
                        } catch (\Exception $e) {
                            $chart = null;
                            $crypto_data = null;
                        }

                        array_push($crypto_results, collect([
                            'wherefrom' => 'crypto',
                            'symbol' => $crypto['symbol'],
                            'name' => $crypto['name'],
                            'price' => $crypto_data?array_get($crypto_data, 'market_data.current_price.usd'):0,
                            'change_percentage' => $crypto_data?array_get($crypto_data, 'market_data.price_change_percentage_24h'):0,
                            'chart' => $chart,
                        ]));
                        break;
                    case 'custom':
                        $price = CustomCryptoData::price($crypto->symbol);
                        $change_percentage = CustomCryptoData::changePercentage($crypto->symbol);
                        $chart = CustomCryptoData::chart($crypto->symbol, '5d');
                        array_push($crypto_results, collect([
                            'wherefrom' => 'crypto',
                            'symbol' => $crypto->symbol,
                            'name' => $crypto->name,
                            'price' => $price,
                            'change_percentage' => $change_percentage,
                            'chart' => $chart,
                        ]));
                }
            }

        $crypto_results = collect($crypto_results);

        $results = $stock_results->merge($fund_results);
        $results = $results->merge($bond_results);
        $results = $results->merge($crypto_results);

        /**
         * Return results
         */
        return $results;
    }

    public function getNewsSymbols()
    {
        /**
         * Get my investments symbols
         */
        $investments = Transaction::where('user_id', auth()->id())
            ->where('wherefrom', 0)
            ->select('stock_id')
            ->with('stock')
            ->groupBy('stock_id')
            ->get()
            ->where('stock.exchange', 'XNYS')
            ->pluck('stock.symbol')
            ->toArray();

        /**
         * Get highlighted symbols
         */
        $highlighted = Stock::where('highlighted', true)
            ->where('exchange', 'XNYS')
            ->get()
            ->pluck('symbol')
            ->toArray();

        /**
         * Prepare news symbols
         */
        $news_symbols = array_merge($investments, $highlighted);
        return $news_symbols;
    }

    public function getAds()
    {
        /**
         * Get Ad images
         */
        $h_ad = Advertise::where('is_vertical', false)
            ->inRandomOrder()->first();

        $v_ad = Advertise::where('is_vertical', true)
            ->inRandomOrder()->first();

        return [$h_ad, $v_ad];
    }
}
