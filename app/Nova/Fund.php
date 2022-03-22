<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;

class Fund extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Fund';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Funds';

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->company_name . ' (' . $this->symbol . ')';
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

    public static function label()
    {

        return 'Funds';
    }

    public static function singularLabel()
    {
        return 'Fund';
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

            Text::make('Symbol')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Company Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Select::make('Data Source', 'data_source')->options([
                'custom' => 'Custom',
            ])
                ->hideFromIndex()
                ->rules('required'),

            Select::make('Exchange')->options([
                'ASE' => 'ASE',
                'NAS' => 'NAS',
                'NYS' => 'NYS',
                'OTC' => 'OTC',
                'PSE' => 'PSE',
            ])
                ->displayUsingLabels()
                ->rules('required'),

            Number::make('Discount Percentage')
                ->step(0.001)
                ->sortable(),

            Select::make('Currency', 'gcurrency')->options([
                'USD' => 'USD',
                'GBP' => 'GBP',
                'EUR' => 'EUR',
            ]),

            Text::make('Link')
                ->rules('required', 'max:255')
                ->help('Enter an link where users can find more details about this stock')
                ->hideFromIndex(),

            Boolean::make('Highlighted')
                ->rules('required')
                ->sortable(),

            Boolean::make('Widget')
                ->rules('required'),

            DateTime::make('Created At')
                ->exceptOnForms(),

            HasMany::make('FundPrices'),
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
