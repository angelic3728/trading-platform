<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutualFund extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_name',
        'symbol',
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
     * Get the stock prices.
     */
    public function mutualFundPrices()
    {
        return $this->hasMany('App\MutualFundPrice');
    }

    /**
     * Formats price
     *
     * @return string price
     */
    public function formatPrice($price, $decimals = 2)
    {

        switch ($this->gcurrency) {

            case 'USD':
                return '$' . number_format($price, $decimals);
                break;

            case 'GBP':
                return number_format(($price * 100), $decimals) . 'p';
                break;

            case 'EUR':
                return number_format(($price * 100), $decimals) . '€';
                break;

            case 'AUD':
                return 'A$' . number_format(($price * 100), $decimals);
                break;

            case 'CAD':
                return 'C$' . number_format(($price * 100), $decimals);
                break;

            default:
                return $price;
                break;
        }
    }

    // Formats currency
    public function getGcurrencyAttribute($gcurrency) {
        return $gcurrency;
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
