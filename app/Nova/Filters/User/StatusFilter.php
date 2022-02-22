<?php

namespace App\Nova\Filters\User;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class StatusFilter extends Filter
{

    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Status';

    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->when($value == 'active', function ($query) {

                          return $query->where('active', true);

                      })->when($value == 'inactive', function ($query) {

                          return $query->where('active', false);

                      });
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Active' => 'active',
            'Inactive' => 'inactive',
        ];
    }
}
