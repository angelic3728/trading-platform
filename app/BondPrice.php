<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BondPrice extends Model
{
    /**
     * Get the fund of the price
     */
    public function bond()
    {
        return $this->belongsTo('App\Bond');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date'];
}
