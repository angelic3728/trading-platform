<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Bond;
use IEX;
use ASX;
use CustomBondData;

class BondsController extends Controller
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
         * Get Bonds
         */
        $bonds = ($request->ex == "" || $request->ex == "all") ?
            Bond::query()
            ->when($request->q, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('symbol', 'LIKE', "%$request->q%")
                        ->orWhere('name', 'LIKE', "%$request->q%");
                });
            })
            ->orderBy('symbol', 'asc')
            ->paginate(25)
            :
            Bond::where('exchange', $request->ex)
            ->when($request->q, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('symbol', 'LIKE', "%$request->q%")
                        ->orWhere('name', 'LIKE', "%$request->q%");
                });
            })
            ->orderBy('symbol', 'asc')
            ->paginate(25);

        $exchanges = Bond::select("exchange")
            ->groupBy("exchange")
            ->get();


        /**
         * Return view
         */
        return view('dashboard.bonds.search', [
            'bonds' => $bonds,
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
         * Get bond
         */
        $bond = Bond::where('symbol', $symbol)->firstOrFail();

        /**
         * Prepare Data
         */

        try {
            switch ($bond->data_source) {
                case 'asx':
                    $asx_data = [];
                    try {
                        if ($bond->is_indexed != 0)
                            $asx_data = ASX::getEDetails($bond->symbol, $bond->is_indexed);
                        else
                            $asx_data = ASX::getXDetails($bond->symbol);
                    } catch (\Exception $e) {
                    }

                    $price = ASX::getBPrice($bond->symbol);
                    $changePercentage = ASX::changePercentage($bond->symbol);
                    $data = array();
                    $priceAsk = null;
                    $priceBid = null;
                    $statusCode = null;
                    
                    try {
                        $priceAsk = $asx_data['priceAsk'];
                    } catch (\Exception $e) {
                    }

                    try {
                        $priceBid = $asx_data['priceBid'];
                    } catch (\Exception $e) {
                    }

                    try {
                        $statusCode = $asx_data['statusCode'];
                    } catch (\Exception $e) {
                    }
                    if ($bond->is_indexed != 0) {
                        $data = [
                            'source' => 'asx',
                            'symbol' => $bond->symbol,
                            'name' => $bond->name,
                            'link' => $bond->link,
                            'exchange' => $bond->exchange,
                            'price' => $price,
                            'institutionalPrice' =>  $price ? $bond->institutionalPrice($price) : null,
                            'changePercentage' => $changePercentage,
                            'bondName' => $asx_data['name'],
                            'couponPercent' => $asx_data['couponPercent'],
                            'dateMaturity' => $asx_data['dateMaturity'],
                            'dateNextEx' => $asx_data['dateNextEx'],
                            'payFrequency' => ($asx_data['payFrequency']) ? $asx_data['payFrequency'] : "-",
                            'paymentType' => ($asx_data['paymentType']) ? $asx_data['paymentType'] : "-",
                            'priceAsk' => $priceAsk,
                            'priceBid' => $priceBid,
                            'statusCode' => $statusCode,
                            'volume' => ($asx_data['volume']) ? $asx_data['volume'] : "-",
                            'faceValue' => ($asx_data['faceValue']) ? $asx_data['faceValue'] : "-",
                            'yieldPercent' => ($asx_data['yieldPercent']) ? $asx_data['yieldPercent'] : "-",

                        ];
                    } else {
                        $data = [
                            'source' => 'asx',
                            'symbol' => $bond->symbol,
                            'name' => $bond->name,
                            'link' => $bond->link,
                            'exchange' => $bond->exchange,
                            'price' => $price,
                            'institutionalPrice' =>  $price ? $bond->institutionalPrice($price) : null,
                            'changePercentage' => $changePercentage,
                            'dateMaturity' => $asx_data['maturity_date'],
                            'dateNextEx' => $asx_data['next_ex_date'],
                            'couponType' => $asx_data['coupon_type'],
                            'couponPa' => $asx_data['coupon_pa'],
                            'ytm' => $asx_data['ytm'],
                            'currentYield' => $asx_data['current_yield'],
                            'tradingMargin' => $asx_data['trading_margin'],
                        ];
                    }

                    break;
                    case 'custom':
                        $data = [
                            'source' => 'custom',
                            'symbol' => $bond->symbol,
                            'name' => $bond->name,
                            'currency' => $bond->gcurrency,
                            'price' => CustomBondData::price($bond->symbol),
                            'changePercentage' => CustomBondData::changePercentage($bond->symbol),
                            'link' => $bond->link,
                            'exchange' => $bond->exchange,
                            'institutionalPrice' => CustomBondData::price($bond->symbol) ? $bond->formatPrice($bond->institutionalPrice(CustomBondData::price($bond->symbol))) : null,
                        ];
                        break;

                default:
                    abort(500);
                    break;
            }

            $currency_rate = 1;
            $user_currency = '';
            if (auth()->user()->balance) {
                $user_currency = json_decode(auth()->user()->balance, 'true')['currency'];
                if ($user_currency != 'USD') {
                    $user_currency_rate = IEX::getRates('USD' . $user_currency);
                    $currency_rate = $user_currency_rate['USD' . $user_currency];
                }
            }
            
            $item_rate = IEX::getRates('USDAUD')['USDAUD'];

            return view('dashboard.bonds.details', [
                'data' => $data,
                'account_manager' => $account_manager,
                'user_currency' => $user_currency,
                'currency_rate' => $currency_rate,
                'item_rate' => $item_rate
            ]);
        } catch (\Exception $e) {
            return redirect()->route('bonds.search')->withError("unknown");
        }
    }
}
