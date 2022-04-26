<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use ASX;
use Cache;
use Mail;
use CustomBondData;

use App\Bond;

class BondsController extends Controller
{
    public function trade(Request $request, $symbol, $action)
    {

        /**
         * Get Bond
         */
        $bond = Bond::where('symbol', $symbol)->firstOrFail();

        /**
         * Validate request
         */
        $request->validate([
            'shares' => 'required|numeric|min:1',
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
                    'obj' => $bond,
                    'symbol' => $bond->symbol,
                    'name' => $bond->company_name,
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

    public static function highlights($cnt = 4)
    {

        /**
         * Get highlighted bonds and cache them for 15 min
         */
        $bonds = Cache::remember('bonds:highlighted', 15, function () use ($cnt) {
            return Bond::where('highlighted', true)->take($cnt)->get();
        });

        /**
         * For each bond, add the price
         */
        $bonds = $bonds->map(function ($bond) {

            /**
             * Make collection of bond
             */
            $bond = collect($bond);
            $bond->put('wherefrom', 'bond');
            /**
             * Add extra fields before returning it
             */
            switch ($bond['data_source']) {
                case 'asx':
                    $price = ASX::getBPrice($bond->get('symbol'));
                    $changePercentage = ASX::changePercentage($bond->get('symbol'));
                    $chart = ASX::getBChart($bond->get('id'), '1m');
                    $bond->put('price', $price);
                    $bond->put('chart', $chart);
                    $bond->put('change_percentage', $changePercentage);
                    break;

                case 'custom':
                    $bond->put('price', CustomBondData::price($bond->get('symbol')));
                    $bond->put('chart', CustomBondData::chart($bond->get('id')));
                    $bond->put('change_percentage', CustomBondData::changePercentage($bond->get('symbol')));
                    break;

                default:
                    $bond->put('price', null);
                    $bond->put('chart', null);
                    $bond->put('change_percentage', null);
                    break;
            }

            /**
             * Return bond
             */
            return $bond->only('wherefrom', 'symbol', 'name', 'price', 'chart', 'change_percentage', 'exchange', 'gcurrency', 'data_source');
        });

        /**
         * Return Json
         */
        return response()->json([
            'success' => true,
            'data' => $bonds,
        ]);
    }

    public function chart($symbol, $range)
    {
        /**
         * Get Bond
         */
        $bond = Bond::where('symbol', $symbol)->firstOrFail();

        /**
         * Check the data source and get the chart data
         */
        switch ($bond->data_source) {
            case 'asx':
                $chart = ASX::getBChart($bond->id, $range);
                break;

            case 'custom':
                $chart = CustomBondData::chart($bond->id, $range);
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
            'exchange' => $bond->exchange
        ]);
    }

    public function all()
    {

        /**
         * Get all bonds and cache for an hour
         */
        $bonds = Bond::select('symbol', 'name')->get();

        foreach ($bonds as $bond) {
            $bond['wherefrom'] = 'bonds';
        }

        /**
         * Return Json
         */
        return response()->json([
            'success' => true,
            'data' => $bonds,
        ]);
    }
}
