<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use IEX;
use ASX;
use Cache;
use DB;
use Mail;
use CustomFundData;

use App\Fund;
use App\Transaction;

class FundsController extends Controller
{
    public function trade(Request $request, $symbol, $action)
    {

        /**
         * Get Fund
         */
        $fund = Fund::where('symbol', $symbol)->firstOrFail();

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
                    'obj' => $fund,
                    'symbol' => $fund->symbol,
                    'name' => $fund->company_name,
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

    public function details($symbol)
    {
        /**
         * Get Fund
         */
        $fund = Fund::where('symbol', $symbol)->firstOrFail();

        /**
         * Prepare Data
         */
        switch ($fund->data_source) {

            case 'iex':

                /**
                 * Get IEX Data
                 */
                $iex_data = IEX::getDetails($fund->symbol);

                /**
                 * Put Price
                 */
                $fund->price = array_has($iex_data, 'price') ? array_get($iex_data, 'price') : null;
                $fund->institutional_price = array_has($iex_data, 'price') ? $fund->institutionalPrice($fund->price) : null;
                break;

            default:
                abort(404);
                break;
        }

        /**
         * Return json
         */
        return response()->json([
            'success' => true,
            'data' => $fund->only('symbol', 'company_name', 'price', 'institutional_price', 'gcurrency'),
        ]);
    }

    public function investments()
    {

        /**
         * Get my investments
         */
        $investments = Transaction::where('user_id', auth()->id())
            ->select(DB::raw('sum(shares) as total_shares'), 'fund_id')
            ->with('fund')
            ->groupBy('fund_id')
            ->get();


        /**
         * If there are no investments, return nothing
         */
        if ($investments->isEmpty()) {

            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }


        /**
         * Convert total shares to integer
         */
        $investments = $investments->map(function ($item, $key) {

            /**
             * Convert total shares to integer
             */
            $item->total_shares = (int) $item->total_shares;

            /**
             * Return data
             */
            return $item;
        });

        /**
         * Only show investmens with 1 or more shares
         */
        $investments = $investments->filter(function ($value, $key) {

            return $value->total_shares >= 1;
        });

        /**
         * Filter IEX symbols
         */
        $iex_symbols = $investments->filter(function ($item, $key) {

            return $item->fund->data_source == 'iex';
        });

        /**
         * Map IEx Symbols
         */
        $iex_symbols = $investments->map(function ($item, $key) {

            return $item->fund->symbol;
        });

        /**
         * IEX prices for iex funds
         */
        $iex_data = $iex_symbols->isNotEmpty() ? IEX::getBatchData($iex_symbols->toArray(), ['price', 'quote']) : null;

        /**
         * Get symbols that are from iex
         */
        $investments = $investments->map(function ($item, $key) use ($iex_data) {

            /**
             * Get latest price based on data source
             */
            switch ($item->fund->data_source) {

                case 'iex':
                    $last_price = array_get($iex_data, $item->fund->symbol . '.price', 0);
                    $change_percentage = array_get($iex_data, $item->fund->symbol . '.quote.changePercent', 0);
                    break;

                case 'custom':
                    $last_price =  CustomFundData::price($item->fund->symbol);
                    $change_percentage = CustomFundData::changePercentage($item->fund->symbol);
                    break;

                default:
                    $last_price = 0;
                    $change_percentage = 0;
                    break;
            }

            /**
             * Institutional Price
             */
            $institutional_price = $item->fund->institutionalPrice($last_price);

            /**
             * Value of investment
             */
            $value = $last_price * $item->total_shares;

            /**
             * Return data
             */
            return collect([
                'symbol' => $item->fund->symbol,
                'currency' => $item->fund->gcurrency,
                'company_name' => $item->fund->company_name,
                'exchange' => $item->fund->exchange,
                'last_price' => $last_price,
                'change_percentage' => $change_percentage,
                'shares' => $item->total_shares,
                'institutional_price' => $institutional_price,
                'value' => $value,
            ]);
        });

        /**
         * Return json
         */
        return response()->json([
            'success' => true,
            'data' => $investments->values(),
        ]);
    }

    public static function highlights($cnt = 4)
    {

        /**
         * Get highlighted funds and cache them for an hour
         */
        $funds = Cache::remember('funds:highlighted', 15, function () use ($cnt) {
            return Fund::where('highlighted', true)->take($cnt)->get();
        });

        /**
         * Get Prices and Chart from IEX
         */
        $data = IEX::getBatchData($funds->where('data_source', 'iex')->pluck('symbol')->toArray(), ['price', 'chart', 'quote'], '1m');

        /**
         * For each fund, add the price
         */
        $funds = $funds->map(function ($fund) use ($data) {

            /**
             * Make collection of fund
             */
            $fund = collect($fund);
            $fund->put('wherefrom', 'fund');
            /**
             * Add extra fields before returning it
             */
            switch ($fund['data_source']) {
                case 'iex':
                    if ($fund->get('exchange') != "NAS") {
                        $fund->put('price', array_get($data, $fund->get('symbol') . '.price'));
                        $fund->put('chart', array_get($data, $fund->get('symbol') . '.chart'));
                        $fund->put('change_percentage', array_get($data, $fund->get('symbol') . '.quote.changePercent'));
                    } else {
                        $asx_data = ASX::getDetails($fund->get('symbol'));
                        $asx_chart = ASX::getChart($fund->get('symbol'), '1m');
                        $fund->put('price', array_get($asx_data, 'price'));
                        $fund->put('chart', $asx_chart);
                        $fund->put('change_percentage', array_get($asx_data, 'change_percentage'));
                    }
                    break;
                case 'asx':
                    $asx_data = ASX::getDetails($fund->get('symbol'));
                    $asx_chart = ASX::getChart($fund->get('symbol'), '1m');
                    $fund->put('price', array_get($asx_data, 'price'));
                    $fund->put('chart', $asx_chart);
                    $fund->put('change_percentage', array_get($asx_data, 'change_percentage'));
                    break;

                case 'custom':
                    $fund->put('price', CustomFundData::price($fund->get('symbol')));
                    $fund->put('chart', CustomFundData::chart($fund->get('symbol')));
                    $fund->put('change_percentage', CustomFundData::changePercentage($fund->get('symbol')));
                    break;

                default:
                    $fund->put('price', null);
                    $fund->put('chart', null);
                    $fund->put('change_percentage', null);
                    break;
            }

            /**
             * Return fund
             */
            return $fund->only('wherefrom', 'symbol', 'company_name', 'price', 'chart', 'change_percentage', 'exchange', 'gcurrency', 'data_source');
        });

        /**
         * Return Json
         */
        return response()->json([
            'success' => true,
            'data' => $funds,
        ]);
    }

    public function chart($symbol, $range)
    {
        /**
         * Get Fund
         */
        $fund = Fund::where('symbol', $symbol)->firstOrFail();

        /**
         * Check the data source and get the chart data
         */
        switch ($fund->data_source) {

            case 'iex':
                if ($fund->exchange != "NAS")
                    $chart = IEX::getChart($fund->symbol, $range);
                else
                    $chart = ASX::getChart($fund->symbol, $range);
                break;

            case 'asx':
                $chart = ASX::getChart($fund->symbol, $range);
                break;

            case 'custom':
                $chart = CustomFundData::chart($fund->symbol, $range);
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
            'exchange' => $fund->exchange
        ]);
    }

    public function all()
    {

        /**
         * Get all funds and cache for an hour
         */
        $funds = Fund::select('symbol', 'company_name')->get();

        foreach ($funds as $fund) {
            $fund['wherefrom'] = 'funds';
        }

        /**
         * Return Json
         */
        return response()->json([
            'success' => true,
            'data' => $funds,
        ]);
    }
}
