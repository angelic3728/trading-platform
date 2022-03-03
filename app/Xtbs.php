<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Xtbs extends Model
{

    protected $casts = [
        'maturity_date' => 'date',
        'next_ex_date' => 'date',
    ];

    protected $fillable = [
        'asx_code',
        'bond_issuer',
        'maturity_date',
        'coupon_type',
        'next_ex_date',
        'coupon_pa',
        'xtb_price',
        'ytm',
        'current_yield',
        'trading_margin',
    ];
}
