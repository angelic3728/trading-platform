<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Illuminate\Http\Request;

class CryptoCurrencyPrice extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\CryptoCurrencyPrice';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Cryptocurrencies';

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

    public static function label()
    {

        return 'Cryptocurrency Prices';
    }

    public static function singularLabel()
    {
        return 'Cryptocurrency Price';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('CryptoCurrency')
                ->searchable()
                ->onlyOnIndex(),

            Select::make('Cryptocurrency', 'crypto_currency_id')->options($this->customCryptocurrencies())
                ->onlyOnForms()
                ->rules('required'),

            Date::make('Date')
                ->sortable()
                ->rules('required'),

            Number::make('Price($)', 'price')
                ->sortable()
                ->step(0.00001)
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

    private function customCryptocurrencies()
    {

        return \App\CryptoCurrency::query()
            ->where('data_source', 'custom')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->name];
            });

    }
}
