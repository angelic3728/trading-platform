<?php

namespace App\Nova\Filters\User;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class ManagerFilter extends BooleanFilter
{

    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Manager';

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
        return $query->when($value['manager'], function ($query) use ($value) {

                          return $query->where('manager', $value['manager']);
                          
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
            'Only Show Managers' => 'manager',
        ];
    }
}
