<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bond extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'symbol',
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

    public function bondPrices()
    {
        return $this->hasMany('App\BondPrice');
    }

    /**
     * Formats price
     *
     * @return string price
     */
    public function formatPrice($price, $decimals = 2)
    {
        return 'A$'.number_format($price, $decimals);
    }

    /**
     * Calculate institutional price
     *
     * price - discount (discounts are in percentages)
     */
    public function institutionalPrice($last_price)
    {
        $decimal = 2;
        if ($last_price > 10) {
            $decimal = 2;
        } else if ($last_price > 1) {
            $decimal = 3;
        } else if ($last_price > 0.1) {
            $decimal = 4;
        } else if ($last_price > 0.01) {
            $decimal = 5;
        } else if ($last_price > 0.001) {
            $decimal = 6;
        } else {
            $decimal = 10;
        }
        
        return round($last_price - ($last_price * ($this->discount_percentage / 100)), $decimal);
    }


    public function getIdentifierAttribute()
    {
        return $this->symbol;
    }
}
