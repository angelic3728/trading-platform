<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fund extends Model
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
    public function fundPrices()
    {
        return $this->hasMany('App\FundPrice');
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
        return number_format($last_price - ($last_price * ($this->discount_percentage / 100)), 2);
    }

    public function getIdentifierAttribute()
    {
        return $this->symbol;
    }
}
