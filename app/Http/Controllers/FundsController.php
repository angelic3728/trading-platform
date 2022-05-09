<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Fund;

use IEX;
use ASX;
use CustomFundData;

class FundsController extends Controller
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
        $funds = ($request->ex == "" || $request->ex == "all") ?
            Fund::query()
            ->when($request->q, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('symbol', 'LIKE', "%$request->q%")
                        ->orWhere('company_name', 'LIKE', "%$request->q%");
                });
            })
            ->orderBy('symbol', 'asc')
            ->paginate(25)
            :
            Fund::where('exchange', $request->ex)
            ->when($request->q, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('symbol', 'LIKE', "%$request->q%")
                        ->orWhere('company_name', 'LIKE', "%$request->q%");
                });
            })
            ->orderBy('symbol', 'asc')
            ->paginate(25);

        $exchanges = Fund::select("exchange")
            ->groupBy("exchange")
            ->get();


        /**
         * Return view
         */
        return view('dashboard.funds.search', [
            'funds' => $funds,
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
         * Get fund
         */
        $fund = Fund::where('symbol', $symbol)->firstOrFail();

        /**
         * Prepare Data
         */

        try {
            switch ($fund->data_source) {
                case 'iex':
                    $iex_data = [];
                    $asx_data = [];
                    try {
                        if ($fund->exchange != "NAS")
                            $iex_data = IEX::getDetails($fund->symbol);
                        else
                            $asx_data = ASX::getDetails($fund->symbol);
                    } catch (\Exception $e) {
                    }
                    if ($fund->exchange != "NAS")
                        $data = [
                            'source' => 'iex',
                            'symbol' => $fund->symbol,
                            'company_name' => $fund->company_name,
                            'data_source' => $fund->data_source,
                            'currency' => $fund->gcurrency,
                            'price' => array_get($iex_data, 'price'),
                            'change_percentage' => array_get($iex_data, 'quote.changePercent'),
                            'link' => $fund->link,
                            'company' => [
                                'description' => array_get($iex_data, 'company.description'),
                                'exchange' => $fund->exchange,
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
                    else
                        $data = [
                            'source' => 'asx',
                            'symbol' => $fund->symbol,
                            'company_name' => $fund->company_name,
                            'data_source' => $fund->data_source,
                            'currency' => $fund->gcurrency,
                            'price' => array_get($asx_data, 'price'),
                            'change_percentage' => array_get($asx_data, 'change_percentage'),
                            'link' => $fund->link,
                            'exchange' => $fund->exchange,
                            'company' => [
                                'description' => array_get($asx_data, 'description'),
                                'exchange' => $fund->exchange,
                                'industry' => array_get($asx_data, 'industry'),
                                'sector' => array_get($asx_data, 'sector'),
                                'website' => array_get($asx_data, 'website'),
                            ],
                            'numbers' => [
                                'latest_price' => array_has($asx_data, 'latest_price') ? $fund->formatPrice(array_get($asx_data, 'latest_price')) : null,
                                'previous_close' => array_has($asx_data, 'previous_close') ? $fund->formatPrice(array_get($asx_data, 'previous_close')) : null,
                                'institutional_price' => array_has($asx_data, 'price') ? $fund->formatPrice($fund->institutionalPrice(array_get($asx_data, 'price'))) : null,
                                'market_cap' => array_has($asx_data, 'market_cap') ? $fund->formatPrice(array_get($asx_data, 'market_cap'), 0) : null,
                                'volume' => array_has($asx_data, 'volume') ? number_format(array_get($asx_data, 'volume')) : null,
                                'avg_total_volume' => array_has($asx_data, 'avg_total_volume') ? number_format(array_get($asx_data, 'avg_total_volume')) : null,
                                'pe_ratio' => array_has($asx_data, 'pe_ratio') ? number_format(array_get($asx_data, 'pe_ratio'), 2) : null,
                            ],
                        ];
                    break;

                case 'asx':
                    $asx_data = [];
                    try {
                        $asx_data = ASX::getDetails($fund->symbol);
                    } catch (\Exception $e) {
                    }
                    $data = [
                        'source' => 'asx',
                        'symbol' => $fund->symbol,
                        'company_name' => $fund->company_name,
                        'data_source' => $fund->data_source,
                        'currency' => $fund->gcurrency,
                        'price' => array_get($asx_data, 'price'),
                        'change_percentage' => array_get($asx_data, 'change_percentage'),
                        'link' => $fund->link,
                        'exchange' => $fund->exchange,
                        'company' => [
                            'description' => array_get($asx_data, 'description'),
                            'exchange' => $fund->exchange,
                            'industry' => array_get($asx_data, 'industry'),
                            'sector' => array_get($asx_data, 'sector'),
                            'website' => array_get($asx_data, 'website'),
                        ],
                        'numbers' => [
                            'latest_price' => array_has($asx_data, 'latest_price') ? $fund->formatPrice(array_get($asx_data, 'latest_price')) : null,
                            'previous_close' => array_has($asx_data, 'previous_close') ? $fund->formatPrice(array_get($asx_data, 'previous_close')) : null,
                            'institutional_price' => array_has($asx_data, 'price') ? $fund->formatPrice($fund->institutionalPrice(array_get($asx_data, 'price'))) : null,
                            'market_cap' => array_has($asx_data, 'market_cap') ? $fund->formatPrice(array_get($asx_data, 'market_cap'), 0) : null,
                            'volume' => array_has($asx_data, 'volume') ? number_format(array_get($asx_data, 'volume')) : null,
                            'avg_total_volume' => array_has($asx_data, 'avg_total_volume') ? number_format(array_get($asx_data, 'avg_total_volume')) : null,
                            'pe_ratio' => array_has($asx_data, 'pe_ratio') ? number_format(array_get($asx_data, 'pe_ratio'), 2) : null,
                        ],
                    ];
                    break;
                case 'custom':
                    $data = [
                        'source' => 'custom',
                        'symbol' => $fund->symbol,
                        'company_name' => $fund->company_name,
                        'data_source' => $fund->data_source,
                        'currency' => $fund->gcurrency,
                        'price' => CustomFundData::price($fund->symbol),
                        'change_percentage' => CustomFundData::changePercentage($fund->symbol),
                        'link' => $fund->link,
                        'exchange' => $fund->exchange,
                        'company' => [
                            'description' => $fund->information,
                        ],
                        'numbers' => [
                            'latest_price' => $fund->formatPrice(CustomFundData::price($fund->symbol)),
                            'institutional_price' => CustomFundData::price($fund->symbol) ? $fund->formatPrice($fund->institutionalPrice(CustomFundData::price($fund->symbol))) : null,
                        ],
                    ];
                    break;

                default:
                    abort(500);
                    break;
            }

            $currency_rate = 1;
            if (auth()->user()->balance) {
                $user_currency = json_decode(auth()->user()->balance, 'true')['currency'];
                if ($user_currency != 'USD') {
                    $user_currency_rate = IEX::getRates('USD' . $user_currency);
                    $currency_rate = $user_currency_rate['USD' . $user_currency];
                }
            }

            $item_rate = 1;
            if($fund->gcurrency !="USD")
                $item_rate = IEX::getRates('USD' . $fund->gcurrency)['USD'.$fund->gcurrency];

            /**
             * Return view
             */
            return view('dashboard.funds.details', [
                'data' => $data,
                'account_manager' => $account_manager,
                'user_currency' => $user_currency,
                'currency_rate' => $currency_rate,
                'item_rate' => $item_rate
            ]);
        } catch (\Exception $e) {
            return redirect()->route('funds.search')->withError("unknown");
        }
    }
}
