<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Document extends Model
{
    use SoftDeletes;

    /**
     * Automatically set by who the document is provided
     */
    public function __construct()
    {
        $this->attributes['provided_by'] = auth()->user()->id;
    }

    /**
     * Format Created At
     */
    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->format('j F Y');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the user that owns the document.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the user that provided the document.
     */
    public function provider()
    {
        return $this->belongsTo('App\User', 'provided_by');
    }

}
