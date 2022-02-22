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
use Laravel\Nova\Fields\Currency;


class Transaction extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Transaction';

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

            ID::make()->sortable(),

            BelongsTo::make('User')
                  ->withMeta([
                      'belongsToId' => $this->user_id ?? $request->user_id,
                      'value' => $this->user_id ? $this->user->first_name.' '.$this->user->last_name : $request->user_id,
                  ]),

            BelongsTo::make('Stock')
                  ->searchable()
                  ->withMeta([
                      'belongsToId' => $this->stock_id ?? $request->stock_id,
                      'value' => $this->stock_id ? $this->stock->symbol : $request->stock_id,
                  ]),

            Select::make('Type')->options([
                    'sell' => 'SELL',
                    'buy' => 'BUY',
                ])
                ->displayUsingLabels()
                ->rules('required')
                ->withMeta([
                    'value' => $this->type ?? $request->type,
                ]),

            Currency::make('Price')
                    ->rules('required')
                    ->withMeta([
                        'value' => $this->price ?? $request->price,
                    ]),

            Number::make('Shares')
                    ->step(1)
                    ->sortable()
                    ->rules('required')
                    ->withMeta([
                        'value' => $this->shares ?? $request->shares,
                    ]),

            Text::make('Created At')
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
        return [
            new Filters\Transaction\UserFilter,
            new Filters\Transaction\TypeFilter,
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
