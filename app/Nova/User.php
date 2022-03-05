<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;

use Epartment\NovaDependencyContainer\HasDependencies;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

use R64\NovaFields\JSON;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\User';

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'first_name', 'last_name', 'email',
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
            Avatar::make('Avatar')
                ->disk('public')
                ->path('/users'),

            Text::make('First Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Last Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Phone')
                ->sortable()
                ->rules('required', 'max:255'),

            Boolean::make('Active')
                ->sortable()
                ->hideWhenCreating(),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Boolean::make('Manager')
                ->sortable(),

            Json::make('Cash On Account', [

                Select::make('Currency', 'currency')->options([
                    'USD' => 'USD',
                    'GBP' => 'GBP',
                ])
                    ->displayUsingLabels(),

                Number::make('Amount', 'amount')
                    ->step(0.01),

            ], 'balance'),

            /**
             * When it is an manager
             */
            NovaDependencyContainer::make([

                Json::make('Manager Information', [
                    Text::make('Availability')
                        ->withMeta([
                            'extraAttributes' => [
                                'placeholder' => 'Example: "Monday - Friday (09:00 - 16:00 GMT)"'
                            ]
                        ]),
                ], 'extra'),

            ])->dependsOn('manager', true),

            /**
             * Hide it is an manager
             */
            NovaDependencyContainer::make([

                Select::make('Managed By', 'managed_by')
                    ->rules('required')
                    ->options($this->availableManagers())
                    ->displayUsingLabels()

            ])->dependsOn('manager', false),

            /**
             * When the user is not yet activated
             */
            Text::make('Get Started Url', function () {
                return isset($this->get_started_url) ? '<a href="' . $this->get_started_url . '" target="_blank">' . $this->get_started_url . '</a>' : null;
            })
                ->asHtml()
                ->onlyOnDetail(),

            Text::make('Login As User', function () {
                return '<a href="' . url('/') . '/viewAsUser/' . $this->id . '">Login</a>';
            })
                ->asHtml()
                ->onlyOnDetail(),

            HasMany::make('Documents'),

            HasMany::make('Transactions'),

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
            new Filters\User\ManagerFilter,
            new Filters\User\StatusFilter,
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

    /**
     * Get all avaialable managers
     *
     * @return array managers names keyed by user id
     */
    protected function availableManagers()
    {

        return User::query()
            ->where('manager', true)
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->id => $item->first_name . ' ' . $item->last_name
                ];
            })
            ->toArray();
    }
}
