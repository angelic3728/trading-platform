<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MutualFundPrice extends Model
{
    /**
     * Get the mutualFund of the price
     */
    public function mutualFund()
    {
        return $this->belongsTo('App\MutualFund');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date'];
}
