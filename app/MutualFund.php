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
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['gcurrency', 'identifier'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Formats price
     *
     * @return string price
     */
    public function formatPrice($price, $decimals = 2)
    {

        switch ($this->currency) {

            case 'USD':
                return '$' . number_format($price, $decimals);
                break;

            case 'GBP':
                return number_format(($price * 100), $decimals) . 'p';
                break;

            default:
                return '$' . number_format($price, $decimals);
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

    public function getIdentifierAttribute()
    {
        return $this->symbol;
    }
}
