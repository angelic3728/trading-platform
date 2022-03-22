<?php

namespace App\Nova;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Number;
use Illuminate\Http\Request;

class Xtbs extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Xtbs';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Other';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('ASX CODE')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('BOND ISSUER')
                ->sortable()
                ->rules('required', 'max:255'),

            Date::make('MATURITY DATE')->format('YYYY-MM-DD'),

            Text::make('COUPON TYPE')
                ->sortable(),

            Date::make('NEXT.EX.DATE', 'next_ex_date')->format('YYYY-MM-DD'),

            Text::make('COUPON P.A', 'coupon_pa')
                ->sortable()
                ->rules('required'),

            Text::make('XTB PRICE($)', 'xtb_price')
                ->sortable()
                ->rules('required'),

            Text::make('YTM(%)', 'ytm')
                ->sortable(),

            Number::make('RUNNING/CURRENT YIELD(%)', 'current_yield')
                ->min(0)
                ->max(100)
                ->step(0.001)
                ->sortable(),

            Number::make('TRADING MARGIN(%)', 'trading_margin')
                ->min(0)
                ->max(100)
                ->step(0.001)
                ->sortable(),

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
}
