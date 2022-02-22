<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivationToken extends Model
{

    /**
     * The attributes that are fillable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
    ];

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
