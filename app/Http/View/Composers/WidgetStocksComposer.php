<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

use IEX;
use Cache;
use CustomStockData;

use App\Stock;

class WidgetStocksComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('widget_stocks', $this->stocks());
    }

    /**
     * Prepare Stock Widget Data
     */
    public function stocks()
    {

        /**
         * Get widget stocks and cache them for 15 minutes
         */
        $stocks = Cache::remember('stocks:widget', 15, function () {

            return Stock::where('widget', true)->get();

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
         * Return Stocks
         */
        return $stocks;

    }

}
