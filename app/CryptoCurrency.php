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
    public function formatPrice($price, $decimals = 2)
    {
        return '$'.number_format($price, $decimals);;
    }

    /**
     * Calculate institutional price
     *
     * price - discount (discounts are in percentages)
     */
    public function institutionalPrice($last_price)
    {
        return $last_price - ($last_price * ($this->discount_percentage / 100));
    }

    public function getIdentifierAttribute()
    {
        return $this->symbol;
    }
}
