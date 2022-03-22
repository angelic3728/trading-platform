<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundPrice extends Model
{
    /**
     * Get the fund of the price
     */
    public function fund()
    {
        return $this->belongsTo('App\Fund');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date'];
}
