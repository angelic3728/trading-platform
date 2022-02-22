<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Stock;

use IEX;
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
         * Get Stocks
         */
        $stocks = Stock::query()
                      ->when($request->q, function ($query) use ($request) {
                          return $query->where(function($query) use ($request){
                              $query->where('symbol', 'LIKE', "%$request->q%")
                                    ->orWhere('company_name','LIKE', "%$request->q%");
                          });
                      })
                      ->orderBy('symbol', 'asc')
                      ->paginate(25);

        /**
         * Return view
         */
        return view('dashboard.stocks.search', [
            'stocks' => $stocks,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $symbol
     * @return \Illuminate\Http\Response
     */
    public function show($symbol)
    {

        /**
         * Get Stock
         */
        $stock = Stock::where('symbol', $symbol)->firstOrFail();

        /**
         * Prepare Data
         */
        switch ($stock->data_source) {

            case 'iex':
                $iex_data = IEX::getDetails($stock->identifier);
                $data = [
                    'source' => 'iex',
                    'symbol' => $stock->symbol,
                    'identifier' => $stock->identifier,
                    'company_name' => $stock->company_name,
                    'currency' => $stock->currency,
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

            case 'custom':
                $data = [
                    'source' => 'custom',
                    'symbol' => $stock->symbol,
                    'identifier' => $stock->identifier,
                    'company_name' => $stock->company_name,
                    'currency' => $stock->currency,
                    'price' => CustomStockData::price($stock->identifier),
                    'change_percentage' => CustomStockData::changePercentage($stock->identifier),
                    'link' => $stock->link,
                    'exchange' => $stock->exchange,
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
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
