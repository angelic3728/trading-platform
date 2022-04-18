<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Transaction extends Model
{

    /**
     * Format Created At
     */
    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->format('j F Y');
    }

    /**
     * Get the user that made the transaction.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the stock of the transaction
     */
    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }

    /**
     * Get the fund of the transaction
     */

    public function fund()
    {
        return $this->belongsTo('App\Fund');
    }

    public function bond()
    {
        return $this->belongsTo('App\Bond');
    }

    public function crypto()
    {
        return $this->belongsTo('App\CryptoCurrency');
    }

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

        $amount = number_format($price, $decimal);

        $currency = $this->wherefrom == 0 ? $this->stock->gcurrency : ($this->wherefrom == 1 ? $this->fund->gcurrency:($this->wherefrom == 2 ? $this->bond->gcurrency:$this->crypto->gcurrency));
        switch ($currency) {

            case 'USD':
                return '$'.$amount;
                break;

            case 'GBP':
                return number_format(($price * 100), $decimal) . 'p';
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
}
