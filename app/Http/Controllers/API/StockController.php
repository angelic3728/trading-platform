<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use IEX;
use Intrinio;
use Cache;
use DB;
use Mail;
use CustomStockData;

use App\Stock;
use App\Transaction;

class StockController extends Controller
{
    public function trade(Request $request, $symbol, $action)
    {

        /**
         * Get Stock
         */
        $stock = Stock::where('symbol', $symbol)->firstOrFail();

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
                    'stock' => $stock,
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
        $stock = Stock::where('symbol', $symbol)->firstOrFail();

        /**
         * Prepare Data
         */
        switch ($stock->data_source) {

            case 'iex':

                /**
                 * Get IEX Data
                 */
                $iex_data = IEX::getDetails($stock->identifier);

                /**
                 * Put Price
                 */
                $stock->price = array_has($iex_data, 'price') ? array_get($iex_data, 'price') : null;
                $stock->institutional_price = array_has($iex_data, 'price') ? $stock->institutionalPrice($stock->price) : null;
                break;

            case 'custom':
                $stock->price = CustomStockData::price($stock->identifier);
                $stock->institutional_price = $stock->institutionalPrice($stock->price);
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
            'data' => $stock->only('symbol', 'company_name', 'exchange', 'price', 'institutional_price', 'currency'),
        ]);

    }

    public function investments(){

        /**
         * Get my investments
         */
        $investments = Transaction::where('user_id', auth()->id())
                            ->select(DB::raw('sum(shares) as total_shares'), 'stock_id')
                            ->with('stock')
                            ->groupBy('stock_id')
                            ->get();


        /**
         * If there are no investments, return nothing
         */
        if($investments->isEmpty()){

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

            return $item->stock->data_source == 'iex';

        });

        /**
         * Map IEx Symbols
         */
        $iex_symbols = $investments->map(function ($item, $key) {

            return $item->stock->identifier;

        });

        /**
         * IEX prices for iex stocks
         */
        $iex_data = $iex_symbols->isNotEmpty() ? IEX::getBatchData($iex_symbols->toArray(), ['price', 'quote']) : null;

        /**
         * Get symbols that are from iex
         */
        $investments = $investments->map(function ($item, $key) use ($iex_data) {

            /**
             * Get latest price based on data source
             */
            switch ($item->stock->data_source) {

                case 'iex':
                    $last_price = array_get($iex_data, $item->stock->identifier.'.price', 0);
                    $change_percentage = array_get($iex_data, $item->stock->identifier.'.quote.changePercent', 0);
                    break;

                case 'custom':
                    $last_price =  CustomStockData::price($item->stock->identifier);
                    $change_percentage = CustomStockData::changePercentage($item->stock->identifier);
                    break;

                default:
                    $last_price = 0;
                    $change_percentage = 0;
                    break;

            }

            /**
             * Institutional Price
             */
            $institutional_price = $item->stock->institutionalPrice($last_price);

            /**
             * Value of investment
             */
            $value = $last_price * $item->total_shares;

            /**
             * Return data
             */
            return collect([
                'symbol' => $item->stock->symbol,
                'currency' => $item->stock->currency,
                'company_name' => $item->stock->company_name,
                'exchange' => $item->stock->exchange,
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
         * Get highlighted stocks and cache them for an hour
         */
        $stocks = Cache::remember('stocks:highlighted', 15, function () {

            return Stock::where('highlighted', true)->get();

        });

        /**
         * Get Prices and Chart from IEX
         */
        $data = IEX::getBatchData($stocks->where('data_source', 'iex')->pluck('identifier')->toArray(), ['price', 'chart', 'quote'], '1m');

        /**
         * For each stock, add the price
         */
        $stocks = $stocks->map(function ($stock) use ($data) {

            /**
             * Make collection of stock
             */
            $stock = collect($stock);

            /**
             * Add extra fields before returning it
             */
            switch ($stock['data_source']) {

                case 'iex':
                    $stock->put('price', array_get($data, $stock->get('identifier').'.price'));
                    $stock->put('chart', array_get($data, $stock->get('identifier').'.chart'));
                    $stock->put('change_percentage', array_get($data, $stock->get('identifier').'.quote.changePercent'));
                    break;

                case 'custom':
                    $stock->put('price', CustomStockData::price($stock->get('identifier')));
                    $stock->put('chart', CustomStockData::chart($stock->get('identifier'), '1m'));
                    $stock->put('change_percentage', CustomStockData::changePercentage($stock->get('identifier')));
                    break;

                default:
                    $stock->put('price', null);
                    $stock->put('chart', null);
                    $stock->put('change_percentage', null);
                    break;

            }

            /**
             * Return stock
             */
            return $stock->only('symbol', 'company_name', 'price', 'chart', 'change_percentage', 'exchange', 'currency');

        });

        /**
         * Return Json
         */
        return response()->json([
            'success' => true,
            'data' => $stocks,
        ]);

    }

    public function chart($symbol, $range)
    {
        /**
         * Get Stock
         */
        $stock = Stock::where('symbol', $symbol)->firstOrFail();

        /**
         * Check the data source and get the chart data
         */
        switch ($stock->data_source) {

            case 'iex':
                $chart = IEX::getChart($stock->identifier, $range);
                break;

            case 'custom':
                $chart = CustomStockData::chart($stock->identifier, $range);
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
         * Get all stocks and cache for an hour
         */
        $stocks = Cache::remember('stocks:all', 60, function () {

            return Stock::select('symbol', 'company_name')->get();

        });

        /**
         * Return Json
         */
        return response()->json([
            'success' => true,
            'data' => $stocks,
        ]);

    }

}
