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

}
