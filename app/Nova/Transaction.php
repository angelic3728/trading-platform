<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
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

        return [

            ID::make()->sortable(),

            BelongsTo::make('User')
                ->withMeta([
                    'belongsToId' => $this->user_id ?? $request->user_id,
                    'value' => $this->user_id ? $this->user->first_name . ' ' . $this->user->last_name : $request->user_id,
                ]),

            Select::make('Resource', 'wherefrom')->options([
                '0' => 'Stock',
                '1' => 'Fund',
                '2' => 'Bond',
                '3' => 'Crypto',
            ])
                ->displayUsingLabels()
                ->rules('required')
                ->withMeta([
                    'value' => $this->type ?? $request->type,
                ]),

            NovaDependencyContainer::make([
                BelongsTo::make('Stock')
                    ->searchable()
                    ->withMeta([
                        'belongsToId' => $this->stock_id ?? $request->stock_id,
                        'value' => $this->stock_id ? $this->stock->symbol : $request->stock_id,
                    ])
            ])->dependsOn('wherefrom', '0'),

            NovaDependencyContainer::make([
                BelongsTo::make('Fund', 'fund')
                    ->searchable()
                    ->withMeta([
                        'belongsToId' => $this->fund_id ?? $request->fund_id,
                        'value' => $this->fund_id ? $this->fund->symbol : $request->fund_id,
                    ]),
            ])->dependsOn('wherefrom', '1'),

            NovaDependencyContainer::make([
                BelongsTo::make('Bond', 'bond', 'App\Nova\Bond')
                    ->searchable()
                    ->withMeta([
                        'belongsToId' => $this->bond_id ?? $request->bond_id,
                        'value' => $this->bond_id ? $this->bond->symbol : $request->bond_id,
                    ]),
            ])->dependsOn('wherefrom', '2'),

            NovaDependencyContainer::make([
                BelongsTo::make('Crypto', 'crypto', 'App\Nova\CryptoCurrency')
                    ->searchable()
                    ->withMeta([
                        'belongsToId' => $this->crypto_id ?? $request->crypto_id,
                        'value' => $this->crypto_id ? $this->crypto->symbol : $request->crypto_id,
                    ]),
            ])->dependsOn('wherefrom', '3'),

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

            ($this->wherefrom == 0) ? BelongsTo::make('Currency', 'stock', 'App\Nova\Stock')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->withMeta([
                    'belongsToId' => $this->stock_id ?? $request->stock_id,
                    'value' => $this->stock_id ? $this->stock->gcurrency : $request->stock_id,
                ]) : (($this->wherefrom == 1) ? BelongsTo::make('Currency', 'fund', 'App\Nova\Fund')
                    ->hideWhenUpdating()
                    ->hideWhenCreating()
                    ->withMeta([
                        'belongsToId' => $this->fund_id ?? $request->fund_id,
                        'value' => $this->fund_id ? $this->fund->gcurrency : $request->fund_id,
                    ]) : (($this->wherefrom == 2) ? BelongsTo::make('Currency', 'bond', 'App\Nova\Bond')
                        ->hideWhenUpdating()
                        ->hideWhenCreating()
                        ->withMeta([
                            'belongsToId' => $this->bond_id ?? $request->bond_id,
                            'value' => $this->bond_id ? $this->bond->gcurrency : $request->bond_id,
                        ]) : BelongsTo::make('Currency', 'crypto', 'App\Nova\CryptoCurrency')
                        ->hideWhenUpdating()
                        ->hideWhenCreating()
                        ->withMeta([
                            'belongsToId' => $this->crypto_id ?? $request->crypto_id,
                            'value' => $this->crypto_id ? $this->crypto->gcurrency : $request->crypto_id,
                        ]))),

            Number::make('Shares')
                ->step(0.001)
                ->help('>=0.001')
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
