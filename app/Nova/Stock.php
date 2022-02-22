<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;

use Epartment\NovaDependencyContainer\HasDependencies;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

class Stock extends Resource
{
    use HasDependencies;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Stock';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Stocks';

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

            Select::make('Exchange', 'exchange')->options([
                    'NYSE' => 'NYSE',
                    'LSE' => 'LSE',
                ])
                ->displayUsingLabels()
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

            Boolean::make('Highlighted')
                ->rules('required'),

            Boolean::make('Widget')
                ->rules('required'),

            DateTime::make('Created At')
                ->exceptOnForms(),


            HasMany::make('StockPrices'),

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
        return [
            new Filters\Stock\HighlightedFilter,
            new Filters\Stock\WidgetFilter,
            new Filters\Stock\ExchangeFilter,
        ];
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
