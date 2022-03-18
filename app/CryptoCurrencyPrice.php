<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoCurrencyPrice extends Model
{
    /**
     * Get the cryptocurrency of the price
     */
    public function cryptoCurrency()
    {
        return $this->belongsTo('App\CryptoCurrency');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date'];
}
