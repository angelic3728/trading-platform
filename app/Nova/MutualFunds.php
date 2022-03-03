<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Illuminate\Http\Request;

class MutualFunds extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\MutualFunds';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Mutual Funds';

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->company_name.' ('.$this->symbol.')';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'symbol',
        'company_name',
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
            ID::make()->sortable(),

            Text::make('Symbol')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Company Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Select::make('Data Source', 'data_source')->options([
                    'iex' => 'IEX',
                    'custom' => 'Custom',
                ])
                ->hideFromIndex()
                ->rules('required'),

            Number::make('Discount Percentage')
                    ->min(0)
                    ->max(100)
                    ->step(1)
                    ->sortable()
                    ->rules('required'),

            Text::make('Link')
                ->rules('required', 'max:255')
                ->help('Enter an link where users can find more details about this stock')
                ->hideFromIndex(),

            DateTime::make('Created At')
                ->exceptOnForms(),
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
