<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CryptoCurrency extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'symbol',
        'coin_id',
        'link',
        'data_source',
        'discount_percentage',
        'gcurrency'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the crypto prices.
     */
    public function cryptoCurrencyPrices()
    {
        return $this->hasMany('App\CryptoCurrencyPrice');
    }

    /**
     * Formats price
     *
     * @return string price
     */
    public function formatPrice($price)
    {
        $decimal = 2;
        if ($price > 10) {
            $decimal = 2;
        } else if ($price > 1) {
            $decimal = 3;
        } else if ($price > 0.1) {
            $decimal = 4;
        } else if ($price > 0.01) {
            $decimal = 5;
        } else if ($price > 0.001) {
            $decimal = 6;
        } else {
            $decimal = 10;
        }
        
        return '$'.number_format($price, $decimal);
    }

    /**
     * Calculate institutional price
     *
     * price - discount (discounts are in percentages)
     */
    public function institutionalPrice($last_price)
    {
        $decimal = 2;
        if ($last_price > 1) {
            $decimal = 2;
        } else if ($last_price > 0.1) {
            $decimal = 3;
        } else if ($last_price > 0.01) {
            $decimal = 4;
        } else if ($last_price > 0.001) {
            $decimal = 5;
        } else if ($last_price > 0.0001) {
            $decimal = 6;
        } else {
            $decimal = 10;
        }

        $insti_price = number_format($last_price - ($last_price * ($this->discount_percentage / 100)), $decimal);
        return $insti_price;
    }


    public function getIdentifierAttribute()
    {
        return $this->symbol;
    }
}
