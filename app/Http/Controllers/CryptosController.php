<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CryptoCurrency;

use IEX;
use ASX;
use CustomCryptoData;
use Cache;

class CryptosController extends Controller
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
        $cryptos = CryptoCurrency::query()
        ->when($request->q, function ($query) use ($request) {
            return $query->where(function ($query) use ($request) {
                $query->where('symbol', 'LIKE', "%$request->q%")
                    ->orWhere('name', 'LIKE', "%$request->q%");
            });
        })
        ->orderBy('symbol', 'asc')
        ->paginate(25);


        /**
         * Return view
         */
        return view('dashboard.cryptos.search', [
            'cryptos' => $cryptos,
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
        $crypto = CryptoCurrency::where('symbol', $symbol)->firstOrFail();


        try {
            /**
             * Prepare Data
             */

            switch ($crypto->data_source) {

                case 'gecko':
                    $crypto_data = Cache::remember('crypto:detail-info'.$crypto->coin_id, 7, function() use ($crypto) {
                        return ASX::getCDetails($crypto->coin_id);
                    });
                    
                    $data = [
                        'source' => 'gecko',
                        'symbol' => array_get($crypto_data, 'symbol'),
                        'name' => array_get($crypto_data, 'name'),
                        'currency' => 'USD',
                        'price' => array_get($crypto_data, 'market_data.current_price.usd'),
                        'change_percentage' => array_get($crypto_data, 'market_data.price_change_percentage_24h'),
                        'link' => $crypto->link,
                        'info' => [
                            'description' => array_get($crypto_data, 'description.en'),
                            'genesis_date' => array_get($crypto_data, 'genesis_date'),
                            'block_time' => array_get($crypto_data, 'block_time_in_minutes'),
                            'hashing_algorithm' => array_get($crypto_data, 'hashing_algorithm'),
                            'website' => array_get($crypto_data, 'links.homepage.0'),
                        ],
                        'numbers' => [
                            'ath' => array_get($crypto_data, 'market_data.ath.usd'),
                            'latest_price' => array_get($crypto_data, 'market_data.current_price.usd') ? $crypto->formatPrice(array_get($crypto_data, 'market_data.current_price.usd')) : null,
                            'institutional_price' => array_get($crypto_data, 'market_data.current_price.usd') ? $crypto->formatPrice($crypto->institutionalPrice(array_get($crypto_data, 'market_data.current_price.usd'))) : null,
                            'market_cap' => array_get($crypto_data, 'market_data.market_cap.usd'),
                            'total_volume' => array_get($crypto_data, 'market_data.total_volume.usd'),
                            'total_supply' => array_get($crypto_data, 'market_data.total_supply'),
                            'circulating_supply' => array_get($crypto_data, 'market_data.circulating_supply'),
                        ],
                    ];
                    break;

                case 'custom':
                    $data = [
                        'source' => 'custom',
                        'symbol' => $crypto->symbol,
                        'name' => $crypto->company_name,
                        'currency' => $crypto->gcurrency,
                        'price' => CustomCryptoData::price($crypto->symbol),
                        'change_percentage' => CustomCryptoData::changePercentage($crypto->symbol),
                        'link' => $crypto->link,
                        'company' => [
                            'description' => $crypto->information,
                        ],
                        'numbers' => [
                            'latest_price' => $crypto->formatPrice(CustomcryptoData::price($crypto->symbol)),
                            'institutional_price' => CustomCryptoData::price($crypto->symbol) ? $crypto->formatPrice($crypto->institutionalPrice(CustomCryptoData::price($crypto->symbol))) : null,
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
            return view('dashboard.cryptos.details', [
                'data' => $data,
                'account_manager' => $account_manager
            ]);
        } catch (\Exception $e) {
            return redirect()->route('cryptos.search')->withError("unknown");
        }
    }
}
