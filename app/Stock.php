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
        'link',
        'exchange',
        'data_source',
        'discount_percentage',
        'gcurrency',
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
    public function stockPrices()
    {
        return $this->hasMany('App\StockPrice');
    }

    /**
     * Formats price
     *
     * @return string price
     */
    public function formatPrice($price, $decimals = 2)
    {
        $amount = number_format($price, $decimals);

        switch ($this->gcurrency) {

            case 'USD':
                return '$'.$amount;
                break;

            case 'GBP':
                return number_format(($price * 100), $decimals) . 'p';
                break;

            case 'EUR':
                return '€'.$amount;
                break;

            case 'AUD':
                return 'A$'.$amount;
                break;

            case 'CAD':
                return 'C$'.$amount;
                break;

            case 'SEK':
                return $amount." kr";
                break;

            case 'CHF':
                return "fr.".$amount;
                break;

            case 'CZK':
                return $amount." Kč";
                break;

            case "DKK":
                return "kr.".$amount;

            case "HKD":
                return "HK$". $amount;

            case "HUF":
                return $amount." Ft";

            case "ILS":
                return "₪". $amount;

            case "JPY":
                return "¥". $amount;

            case "NOK":
                return "kr". $amount;

            case "PLN":
                return $amount." zł";

            case "RON":
                return $amount." lei";

            default:
                return $price;
                break;
        }
    }

    // Formats currency
    public function getGcurrencyAttribute($gcurrency)
    {
        return $gcurrency;
    }

    /**
     * Calculate institutional price
     *
     * price - discount (discounts are in percentages)
     */
    public function institutionalPrice($last_price)
    {

        return round($last_price - ($last_price * ($this->discount_percentage / 100)), 2);
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
