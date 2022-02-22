<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class StockPrice extends Model
{

    /**
     * Get the stock of the price
     */
    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date'];

}
