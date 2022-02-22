<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are fillable
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'symbol',
        'isin',
        'link',
        'exchange',
        'data_source',
        'discount_percentage',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['currency', 'identifier'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the stock prices.
     */
    public function stockPrices()
    {
        return $this->hasMany('App\StockPrice');
    }

    /**
     * Get currency based on data source
     *
     * @return string currency
     */
    public function getCurrencyAttribute()
    {
        switch ($this->exchange) {

            case 'LSE':
                return 'GBP';
                break;

            default:
                return 'USD';
                break;

        }
    }

    /**
     * Formats price
     *
     * @return string price
     */
    public function formatPrice($price, $decimals = 2)
    {

        switch ($this->currency) {

            case 'USD':
                return '$'.number_format($price, $decimals);
                break;

            case 'GBP':
                return number_format(($price * 100), $decimals).'p';
                break;

            default:
                return $price;
                break;

        }

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

    /**
     * Get Unique Identifier Attribute
     *
     * @return string
     */
    public function getIdentifierAttribute()
    {

        switch ($this->exchange) {

            case 'LSE':
                return str_replace('.L', '-LN', $this->symbol);
                break;

            default:
                return $this->symbol;
                break;

        }

    }
}
