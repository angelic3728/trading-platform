<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'extra' => 'array',
    ];

    /**
     * Returns avatar if available
     */
    public function getAvatarUrlAttribute()
    {

        if(empty($this->avatar)){

            return Storage::disk('public')->url('avatar/default.png');

        }

        return Storage::disk('public')->url($this->avatar);

    }

    /**
     * Generates get started url
     *
     * @return string
     */
    public function getGetStartedUrlAttribute()
    {
        return isset($this->activation_token) ? route('registration.get-started', $this->activation_token->token) : null;
    }

    /**
     * Get the activation token.
     */
    public function activation_token()
    {
        return $this->hasOne('App\ActivationToken');
    }

    /**
     * Get the documents.
     */
    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    /**
     * Get the transactions.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    /**
     * Get the manager.
     */
    public function account_manager()
    {
        return $this->belongsTo('App\User', 'managed_by');
    }

    /**
     * Return balance as an string
     *
     * @param string $value
     * @return string
     */
    public function getBalance()
    {

        /**
         * If the value is empty, return default
         */
        if(empty($this->balance)){

            return '$0.00';

        }

        /**
         * Decode JSON
         */
        $balance = json_decode($this->balance);

        /**
         * Determine how to return the balance
         */
        switch ($balance->currency) {

            case 'USD':
                return '$'.number_format($balance->amount, 2);
                break;

            case 'GBP':
                return '£'.number_format($balance->amount, 2);
                break;

        }

    }

}
