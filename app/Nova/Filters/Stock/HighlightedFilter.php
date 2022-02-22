<?php

namespace App\Nova\Filters\Stock;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class HighlightedFilter extends BooleanFilter
{

    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Highlighted';

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
        return $query->when($value['highlighted'], function ($query) use ($value) {
                          return $query->where('highlighted', $value['highlighted']);
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
            'Only Show Highlighted Stocks' => 'highlighted',
        ];
    }
}
