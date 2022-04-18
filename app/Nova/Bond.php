<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;

class Bond extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Bond';

    public static $group = 'Bonds';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {
        return $this->name . ' (' . $this->symbol . ')';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'symbol',
        'name',
    ];

    public static function label()
    {
        return 'Bonds';
    }

    public static function singularLabel()
    {
        return 'Bond';
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

            Text::make('Code', 'symbol')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Issuer/Description', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Select::make('Data Source', 'data_source')->options([
                'asx' => 'ASX',
                'custom' => 'Custom',
            ])
                ->hideFromIndex()
                ->rules('required'),

            Select::make('Exchange')->options([
                'ETB' => 'ETB',
                'XTB' => 'XTB',
            ])
                ->displayUsingLabels()
                ->rules('required'),

            Number::make('Discount Percentage')
                ->step(0.001)
                ->sortable(),

            Select::make('Currency', 'gcurrency')->options([
                'USD' => 'USD',
            ]),

            Text::make('Link')
                ->help('Enter an link where users can find more details about this stock')
                ->hideFromIndex(),

            Boolean::make('Highlighted')
                ->rules('required')
                ->sortable(),

            Boolean::make('Widget')
                ->rules('required'),

            DateTime::make('Created At')
                ->exceptOnForms(),

            HasMany::make('BondPrices'),
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
