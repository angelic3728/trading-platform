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
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Epartment\NovaDependencyContainer\HasDependencies;

class Transaction extends Resource
{

    use HasDependencies;
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
        // print_r($this->mutual_fund_id); die();

        return [

            ID::make()->sortable(),

            BelongsTo::make('User')
                ->withMeta([
                    'belongsToId' => $this->user_id ?? $request->user_id,
                    'value' => $this->user_id ? $this->user->first_name . ' ' . $this->user->last_name : $request->user_id,
                ]),

            Boolean::make('Is Mutual Fund', 'is_fund')
                ->sortable(),

            NovaDependencyContainer::make([
                BelongsTo::make('Stock')
                    ->searchable()
                    ->withMeta([
                        'belongsToId' => $this->stock_id ?? $request->stock_id,
                        'value' => $this->stock_id ? $this->stock->symbol : $request->stock_id,
                    ])
            ])->dependsOn('is_fund', false),

            NovaDependencyContainer::make([
                BelongsTo::make('Mutual Fund', 'mutualFund')
                    ->searchable()
                    ->withMeta([
                        'belongsToId' => $this->fund_id ?? $request->fund_id,
                        'value' => $this->fund_id ? $this->fund->symbol : $request->fund_id,
                    ]),
            ])->dependsOn('is_fund', true),


            Select::make('Type')->options([
                'sell' => 'SELL',
                'buy' => 'BUY',
            ])
                ->displayUsingLabels()
                ->rules('required')
                ->withMeta([
                    'value' => $this->type ?? $request->type,
                ]),

            Number::make('Price')
                ->rules('required')
                ->withMeta([
                    'value' => $this->price ?? $request->price,
                ]),

            ($this->is_fund == 1) ? BelongsTo::make('Currency', 'mutualFund', 'App\Nova\MutualFund')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->withMeta([
                    'belongsToId' => $this->mutual_fund_id ?? $request->mutual_fund_id,
                    'value' => $this->mutual_fund_id ? $this->mutualFund->gcurrency : $request->mutual_fund_id,
                ]) : BelongsTo::make('Currency', 'stock', 'App\Nova\Stock')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->withMeta([
                    'belongsToId' => $this->stock_id ?? $request->stock_id,
                    'value' => $this->stock_id ? $this->stock->gcurrency : $request->stock_id,
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
