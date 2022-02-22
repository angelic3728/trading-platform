<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Select;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class StockPrice extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\StockPrice';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'date';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'date', 'price',
    ];

    public static function label() {

        return 'Stock Prices';

    }

    public static function singularLabel() {

        return 'Stock Price';

    }

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Stocks';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            ID::make()
                  ->sortable(),

            BelongsTo::make('Stock')
                  ->searchable()
                  ->onlyOnIndex(),

            Select::make('Stock', 'stock_id')->options($this->customStocks())
                  ->onlyOnForms()
                  ->rules('required'),

            Date::make('Date')
                  ->sortable()
                  ->rules('required'),

            Currency::make('Price')
                  ->sortable()
                  ->rules('required'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Get all custom added stocks
     *
     * @return array
     */
    private function customStocks()
    {

        return \App\Stock::query()
            ->where('data_source', 'custom')
            ->get()
            ->mapWithKeys(function ($item) {

                return [$item->id => $item->company_name];

            });

    }
}
