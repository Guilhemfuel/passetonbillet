<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    public $table = 'reviews';

    public $fillable = [
        'user_id',
        'mark',
        'text',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'mark'    => 'float',
        'text'    => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'mark'    => 'required|numeric',
        'text'    => 'required|string'
    ];

    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }

    /**
     * Boot
     */
    public static function boot() {
        parent::boot();

        static::creating(function (Review $item) {
            $item->user_id = \Auth::id(); //assigning value
        });

    }

}
