<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use IEX;
use ASX;
use Cache;
use Mail;
use CustomCryptoData;

use App\CryptoCurrency;

class CryptosController extends Controller
{
    public function trade(Request $request, $symbol, $action)
    {

        /**
         * Get Cryptocurrency
         */
        $crypto = CryptoCurrency::where('symbol', $symbol)->firstOrFail();

        /**
         * Validate request
         */
        $request->validate([
            'amounts' => 'required|numeric|min:0.001',
        ]);

        /**
         * Deteremine which action to perform
         */
        switch ($action) {
            case 'buy':
            case 'sell':

                /**
                 * Prepare Data
                 */
                $data = [
                    'action' => $action,
                    'user' => auth()->user(),
                    'obj' => $crypto,
                    'symbol' => $crypto->symbol,
                    'name' => $crypto->name,
                    'price' => $request->price,
                    'institutional_price' => $request->institutional_price,
                    'shares' => $request->shares,
                    'date' => now(),
                ];

                /**
                 * Mail User and Account Manager
                 */
                Mail::to($request->user()['email'])->send(new \App\Mail\Trade\Confirmation\User($data));
                Mail::to(config('app.email'))->send(new \App\Mail\Trade\Confirmation\AccountManager($data));

                /**
                 * Return response
                 */
                return response()->json([
                    'success' => true,
                ]);
                break;

            default:
                abort(405);
                break;
        }
    }

    public static function highlights($cnt=4)
    {

        /**
         * Get highlighted cryptos and cache them for an hour
         */
        $cryptos = Cache::remember('cryptos:highlighted', 22, function () use ($cnt) {
            return CryptoCurrency::where('highlighted', true)->take($cnt)->get();
        });

        $results = [];
        $cnt = 0;
        if (count($cryptos) != 0)
            foreach ($cryptos as $crypto) {
                switch ($crypto['data_source']) {
                    case 'gecko':
                        try {
                            $chart = Cache::remember('cryptos:highlight-gecko-chart-'.$crypto->coin_id, (10+$cnt), function() use ($crypto) {
                                return ASX::getCChart($crypto->coin_id, '5d');
                            });
                        } catch(\Exception $e) {
                            $chart = [];
                        }
                        $price = 0;
                        $change_percentage = 0;
                        if(count($chart) != 0) {
                            $price = $chart[count($chart)-1][1];
                            $change_percentage = number_format(($chart[count($chart)-1][1] - $chart[count($chart)-2][1])/100, 2);
                        }

                        array_push($results, collect([
                            'wherefrom' => 'crypto',
                            'symbol' => $crypto['symbol'],
                            'name' => $crypto['name'],
                            'price' => $price,
                            'change_percentage' => $change_percentage,
                            'chart' => $chart,
                        ]));
                        break;
                    case 'custom':
                        $price = CustomStockData::price($crypto['symbol']);
                        $chart = CustomStockData::price($crypto['symbol'], '5d');
                        $change_percentage = CustomStockData::changePercentage($crypto['symbol']);

                        array_push($results, collect([
                            'wherefrom' => 'crypto',
                            'symbol' => $crypto['symbol'],
                            'name' => $crypto['name'],
                            'price' => $price,
                            'change_percentage' => $change_percentage,
                            'chart' => $chart,
                        ]));
                }
            }

        /**
         * Return Json
         */
        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }

    public function chart($symbol, $range)
    {
        /**
         * Get Crypto
         */
        $crypto = CryptoCurrency::where('symbol', $symbol)->firstOrFail();        
        /**
         * Check the data source and get the chart data
         */
        switch ($crypto->data_source) {

            case 'gecko':
                try {
                    $chart = Cache::remember('crypto:detail-gecko-chart-'.$crypto->coin_id.$range, 11, function() use ($crypto, $range) {
                        return ASX::getCChart($crypto->coin_id, $range);
                    });
                } catch(\Exception $e) {
                    $chart= [];
                }
                break;

            case 'custom':
                $chart = CustomCryptoData::chart($crypto->symbol, $range);
                break;

            default:
                abort(404);
                break;
        }

        /**
         * Return Json
         */
        return response()->json([
            'success' => true,
            'data' => $chart,
        ]);
    }

    public function all()
    {

        /**
         * Get all cryptos and cache for an hour
         */
        $cryptos = Cache::remember('cryptos:all', 60, function () {
            return CryptoCurrency::select('symbol', 'name')->get();
        });

        foreach($cryptos as $crypto) {
            $crypto['wherefrom'] = 'cryptos';
        }

        /**
         * Return Json
         */
        return response()->json([
            'success' => true,
            'data' => $cryptos,
        ]);
    }
}
