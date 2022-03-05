<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use IEX;
use Intrinio;
use Cache;
use DB;
use Mail;

use App\MutualFund;
use App\Transaction;

class MutualFundsController extends Controller
{
    public function trade(Request $request, $symbol, $action)
    {

        /**
         * Get Stock
         */
        $mfd = MutualFund::where('symbol', $symbol)->firstOrFail();

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
                    'mfd' => $mfd,
                    'price' => $request->price,
                    'institutional_price' => $request->institutional_price,
                    'shares' => $request->shares,
                    'date' => now(),
                ];

                /**
                 * Mail User and Account Manager
                 */
                Mail::to($request->user())->send(new \App\Mail\Trade\Confirmation\User($data));
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
         * Get Stock
         */
        $mfd = MutualFund::where('symbol', $symbol)->firstOrFail();

        /**
         * Prepare Data
         */
        switch ($mfd->data_source) {

            case 'iex':

                /**
                 * Get IEX Data
                 */
                $iex_data = IEX::getDetails($mfd->symbol);

                /**
                 * Put Price
                 */
                $mfd->price = array_has($iex_data, 'price') ? array_get($iex_data, 'price') : null;
                $mfd->institutional_price = array_has($iex_data, 'price') ? $mfd->institutionalPrice($mfd->price) : null;
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
            'data' => $mfd->only('symbol', 'company_name', 'price', 'institutional_price', 'currency'),
        ]);
    }

    public function investments()
    {

        /**
         * Get my investments
         */
        $investments = Transaction::where('user_id', auth()->id())
            ->select(DB::raw('sum(shares) as total_shares'), 'mfd_id')
            ->with('mfd')
            ->groupBy('mfd_id')
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

            return $item->mfd->data_source == 'iex';
        });

        /**
         * Map IEx Symbols
         */
        $iex_symbols = $investments->map(function ($item, $key) {

            return $item->mfd->identifier;
        });

        /**
         * IEX prices for iex mfds
         */
        $iex_data = $iex_symbols->isNotEmpty() ? IEX::getBatchData($iex_symbols->toArray(), ['price', 'quote']) : null;

        /**
         * Get symbols that are from iex
         */
        $investments = $investments->map(function ($item, $key) use ($iex_data) {

            /**
             * Get latest price based on data source
             */
            switch ($item->mfd->data_source) {

                case 'iex':
                    $last_price = array_get($iex_data, $item->mfd->identifier . '.price', 0);
                    $change_percentage = array_get($iex_data, $item->mfd->identifier . '.quote.changePercent', 0);
                    break;

                case 'custom':
                    $last_price =  CustomStockData::price($item->mfd->identifier);
                    $change_percentage = CustomStockData::changePercentage($item->mfd->identifier);
                    break;

                default:
                    $last_price = 0;
                    $change_percentage = 0;
                    break;
            }

            /**
             * Institutional Price
             */
            $institutional_price = $item->mfd->institutionalPrice($last_price);

            /**
             * Value of investment
             */
            $value = $last_price * $item->total_shares;

            /**
             * Return data
             */
            return collect([
                'symbol' => $item->mfd->symbol,
                'currency' => $item->mfd->currency,
                'company_name' => $item->mfd->company_name,
                'exchange' => $item->mfd->exchange,
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

    public function highlights()
    {

        /**
         * Get highlighted mfds and cache them for an hour
         */
        $mfds = Cache::remember('funds:highlighted', 1, function () {
            return MutualFund::where('highlighted', true)->get();
        });

        /**
         * Get Prices and Chart from IEX
         */
        $data = IEX::getBatchData($mfds->where('data_source', 'iex')->pluck('identifier')->toArray(), ['price', 'chart', 'quote'], '1m');

        /**
         * For each mfd, add the price
         */
        $mfds = $mfds->map(function ($mfd) use ($data) {

            /**
             * Make collection of mfd
             */
            $mfd = collect($mfd);

            /**
             * Add extra fields before returning it
             */
            switch ($mfd['data_source']) {

                case 'iex':
                    $mfd->put('price', array_get($data, $mfd->get('symbol') . '.price'));
                    $mfd->put('chart', array_get($data, $mfd->get('symbol') . '.chart'));
                    $mfd->put('change_percentage', array_get($data, $mfd->get('symbol') . '.quote.changePercent'));
                    break;

                case 'custom':
                    $mfd->put('price', CustomStockData::price($mfd->get('symbol')));
                    $mfd->put('chart', CustomStockData::chart($mfd->get('symbol')));
                    $mfd->put('change_percentage', CustomStockData::changePercentage($mfd->get('symbol')));
                    break;

                default:
                    $mfd->put('price', null);
                    $mfd->put('chart', null);
                    $mfd->put('change_percentage', null);
                    break;
            }

            /**
             * Return mfd
             */
            return $mfd->only('symbol', 'company_name', 'price', 'chart', 'change_percentage', 'exchange', 'currency');
        });

        /**
         * Return Json
         */
        return response()->json([
            'success' => true,
            'data' => $mfds,
        ]);
    }

    public function chart($symbol, $range)
    {
        /**
         * Get Stock
         */
        $mfd = MutualFund::where('symbol', $symbol)->firstOrFail();

        /**
         * Check the data source and get the chart data
         */
        switch ($mfd->data_source) {

            case 'iex':
                $chart = IEX::getChart($mfd->symbol, $range);
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
         * Get all mfds and cache for an hour
         */
        $mfds = Cache::remember('mfds:all', 60, function () {

            return MutualFund::select('symbol', 'company_name')->get();
        });

        /**
         * Return Json
         */
        return response()->json([
            'success' => true,
            'data' => $mfds,
        ]);
    }
}
