<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Stock;

use IEX;
use ASX;
use CustomStockData;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * Get Account Manager
         */
        $account_manager = auth()->user()->account_manager;
        /**
         * Get Stocks
         */
        $stocks = ($request->ex == "" || $request->ex == "all") ?
            Stock::query()
            ->when($request->q, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('symbol', 'LIKE', "%$request->q%")
                        ->orWhere('company_name', 'LIKE', "%$request->q%");
                });
            })
            ->orderBy('symbol', 'asc')
            ->paginate(25)
            :
            Stock::where('exchange', $request->ex)
            ->when($request->q, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('symbol', 'LIKE', "%$request->q%")
                        ->orWhere('company_name', 'LIKE', "%$request->q%");
                });
            })
            ->orderBy('symbol', 'asc')
            ->paginate(25);

        $exchanges = Stock::select("exchange")
            ->groupBy("exchange")
            ->get();

        /**
         * Return view
         */
        return view('dashboard.stocks.search', [
            'stocks' => $stocks,
            'exchanges' => $exchanges,
            'account_manager' => $account_manager,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $symbol
     * @return \Illuminate\Http\Response
     */
    public function show($symbol)
    {

        $account_manager = auth()->user()->account_manager;

        /**
         * Get Stock
         */
        $stock = Stock::where('symbol', $symbol)->firstOrFail();


        try {
            /**
             * Prepare Data
             */

            switch ($stock->data_source) {

                case 'iex':
                    $iex_data = IEX::getDetails($stock->symbol);
                    $data = [
                        'source' => 'iex',
                        'symbol' => $stock->symbol,
                        'company_name' => $stock->company_name,
                        'currency' => $stock->gcurrency,
                        'price' => array_get($iex_data, 'price'),
                        'change_percentage' => array_get($iex_data, 'quote.changePercent'),
                        'link' => $stock->link,
                        'exchange' => $stock->exchange,
                        'company' => [
                            'description' => array_get($iex_data, 'company.description'),
                            'exchange' => array_get($iex_data, 'company.exchange'),
                            'industry' => array_get($iex_data, 'company.industry'),
                            'sector' => array_get($iex_data, 'company.sector'),
                            'website' => array_get($iex_data, 'company.website'),
                        ],
                        'numbers' => [
                            'latest_price' => array_has($iex_data, 'quote.latestPrice') ? $stock->formatPrice(array_get($iex_data, 'quote.latestPrice')) : null,
                            'previous_close' => array_has($iex_data, 'quote.previousClose') ? $stock->formatPrice(array_get($iex_data, 'quote.previousClose')) : null,
                            'institutional_price' => array_has($iex_data, 'price') ? $stock->formatPrice($stock->institutionalPrice(array_get($iex_data, 'price'))) : null,
                            'market_cap' => array_has($iex_data, 'quote.marketCap') ? $stock->formatPrice(array_get($iex_data, 'quote.marketCap'), 0) : null,
                            'volume' => array_has($iex_data, 'quote.latestVolume') ? number_format(array_get($iex_data, 'quote.latestVolume')) : null,
                            'avg_total_volume' => array_has($iex_data, 'quote.avgTotalVolume') ? number_format(array_get($iex_data, 'quote.avgTotalVolume')) : null,
                            'pe_ratio' => array_has($iex_data, 'quote.peRatio') ? number_format(array_get($iex_data, 'quote.peRatio'), 2) : null,
                        ],
                    ];
                    break;

                case 'asx':
                    $asx_data = ASX::getDetails($stock->symbol);
                    $data = [
                        'source' => 'asx',
                        'symbol' => $stock->symbol,
                        'company_name' => $stock->company_name,
                        'currency' => $stock->gcurrency,
                        'price' => array_get($asx_data, 'price'),
                        'change_percentage' => array_get($asx_data, 'change_percentage'),
                        'link' => $stock->link,
                        'exchange' => $stock->exchange,
                        'company' => [
                            'description' => array_get($asx_data, 'description'),
                            'exchange' => array_get($asx_data, 'exchange'),
                            'industry' => array_get($asx_data, 'industry'),
                            'sector' => array_get($asx_data, 'sector'),
                            'website' => array_get($asx_data, 'website'),
                        ],
                        'numbers' => [
                            'latest_price' => array_has($asx_data, 'latest_price') ? $stock->formatPrice(array_get($asx_data, 'latest_price')) : null,
                            'previous_close' => array_has($asx_data, 'previous_close') ? $stock->formatPrice(array_get($asx_data, 'previous_close')) : null,
                            'institutional_price' => array_has($asx_data, 'price') ? $stock->formatPrice($stock->institutionalPrice(array_get($asx_data, 'price'))) : null,
                            'market_cap' => array_has($asx_data, 'market_cap') ? $stock->formatPrice(array_get($asx_data, 'market_cap'), 0) : null,
                            'volume' => array_has($asx_data, 'volume') ? number_format(array_get($asx_data, 'volume')) : null,
                            'avg_total_volume' => array_has($asx_data, 'avg_total_volume') ? number_format(array_get($asx_data, 'avg_total_volume')) : null,
                            'pe_ratio' => array_has($asx_data, 'pe_ratio') ? number_format(array_get($asx_data, 'pe_ratio'), 2) : null,
                        ],
                    ];
                    break;

                case 'custom':
                    $data = [
                        'source' => 'custom',
                        'symbol' => $stock->symbol,
                        'company_name' => $stock->company_name,
                        'currency' => $stock->gcurrency,
                        'price' => CustomStockData::price($stock->symbol),
                        'change_percentage' => CustomStockData::changePercentage($stock->symbol),
                        'link' => $stock->link,
                        'exchange' => $stock->exchange,
                        'company' => [
                            'description' => $stock->information,
                        ],
                        'numbers' => [
                            'latest_price' => $stock->formatPrice(CustomStockData::price($stock->symbol)),
                            'institutional_price' => CustomStockData::price($stock->symbol) ? $stock->formatPrice($stock->institutionalPrice(CustomStockData::price($stock->symbol))) : null,
                        ],
                    ];
                    break;

                default:
                    abort(500);
                    break;
            }
            /**
             * Return view
             */
            return view('dashboard.stocks.details', [
                'data' => $data,
                'account_manager' => $account_manager
            ]);
        } catch (\Exception $e) {
            return redirect()->route('stocks.search')->withError("unknown");
        }
    }
}
