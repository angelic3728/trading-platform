<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MutualFund;

use IEX;
use CustomFundData;

class MutualFundsController extends Controller
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
         * Get Funds
         */
        $mfds = ($request->ex == "" || $request->ex == "all") ?
            MutualFund::query()
            ->when($request->q, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('symbol', 'LIKE', "%$request->q%")
                        ->orWhere('company_name', 'LIKE', "%$request->q%");
                });
            })
            ->orderBy('symbol', 'asc')
            ->paginate(25)
            :
            MutualFund::where('exchange', $request->ex)
            ->when($request->q, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('symbol', 'LIKE', "%$request->q%")
                        ->orWhere('company_name', 'LIKE', "%$request->q%");
                });
            })
            ->orderBy('symbol', 'asc')
            ->paginate(25);

        $exchanges = MutualFund::select("exchange")
            ->groupBy("exchange")
            ->get();


        /**
         * Return view
         */
        return view('dashboard.mfds.search', [
            'mfds' => $mfds,
            'exchanges' => $exchanges,
            'account_manager' => $account_manager,
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

        $account_manager = auth()->user()->account_manager;

        /**
         * Get Stock
         */
        $fund = MutualFund::where('symbol', $symbol)->firstOrFail();

        /**
         * Prepare Data
         */

        switch ($fund->data_source) {

            case 'iex':
                $iex_data = IEX::getDetails($fund->symbol);
                $data = [
                    'source' => 'iex',
                    'symbol' => $fund->symbol,
                    'company_name' => $fund->company_name,
                    'currency' => $fund->gcurrency,
                    'price' => array_get($iex_data, 'price'),
                    'change_percentage' => array_get($iex_data, 'quote.changePercent'),
                    'link' => $fund->link,
                    'company' => [
                        'description' => array_get($iex_data, 'company.description'),
                        'exchange' => array_get($iex_data, 'company.exchange'),
                        'industry' => array_get($iex_data, 'company.industry'),
                        'sector' => array_get($iex_data, 'company.sector'),
                        'website' => array_get($iex_data, 'company.website'),
                    ],
                    'numbers' => [
                        'latest_price' => array_has($iex_data, 'quote.latestPrice') ? $fund->formatPrice(array_get($iex_data, 'quote.latestPrice')) : null,
                        'previous_close' => array_has($iex_data, 'quote.previousClose') ? $fund->formatPrice(array_get($iex_data, 'quote.previousClose')) : null,
                        'institutional_price' => array_has($iex_data, 'price') ? $fund->formatPrice($fund->institutionalPrice(array_get($iex_data, 'price'))) : null,
                        'market_cap' => array_has($iex_data, 'quote.marketCap') ? $fund->formatPrice(array_get($iex_data, 'quote.marketCap'), 0) : null,
                        'volume' => array_has($iex_data, 'quote.latestVolume') ? number_format(array_get($iex_data, 'quote.latestVolume')) : null,
                        'avg_total_volume' => array_has($iex_data, 'quote.avgTotalVolume') ? number_format(array_get($iex_data, 'quote.avgTotalVolume')) : null,
                        'pe_ratio' => array_has($iex_data, 'quote.peRatio') ? number_format(array_get($iex_data, 'quote.peRatio'), 2) : null,
                    ],
                ];
                break;

            case 'custom':
                $data = [
                    'source' => 'custom',
                    'symbol' => $fund->symbol,
                    'company_name' => $fund->company_name,
                    'currency' => $fund->gcurrency,
                    'price' => CustomFundData::price($fund->identifier),
                    'change_percentage' => CustomFundData::changePercentage($fund->identifier),
                    'link' => $fund->link,
                    'exchange' => $fund->exchange,
                ];
                break;

            default:
                abort(500);
                break;
        }
        /**
         * Return view
         */
        return view('dashboard.mfds.details', [
            'data' => $data,
            'account_manager' => $account_manager
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
