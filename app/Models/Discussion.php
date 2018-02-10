<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    CONST DENIED = - 1;
    CONST AWAITING = 0;
    CONST ACCEPTED = 1;

    public $table = 'discussions';

    public $fillable = [
        'ticket_id',
        'buyer_id',
        'status',
        'price',
        'currency'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'ticket_id' => 'integer',
        'buyer_id'  => 'integer',
        'status'    => 'integer',
        'price'     => 'integer',
        'currency'  => 'string',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'buyer_id'  => 'required|exists:users,id',
        'ticket_id' => 'required|exists:tickets,id',
        'price'     => 'required|integer',
        'currency'  => 'required',
    ];

    /**
     * Mutators
     */

    public function getStatusTextAttibute( $value )
    {
        switch ( $value ) {
            case $value == static::DENIED :
                return 'denied';
            case $value == static::AWAITING:
                return 'awaiting';
            case $value == static::ACCEPTED:
                return 'accepted';
        }
    }

    public function getSellerAttribute()
    {
        return $this->ticket->user;
    }

    public function getLastMessageAttribute()
    {
        return $this->messages()->orderBy('created_at','desc')->first();
    }

    /**
     * Relationships
     */

    public function buyer()
    {
        return $this->belongsTo( 'App\User' );
    }

    public function ticket()
    {
        return $this->belongsTo( 'App\Ticket' );
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message', 'discussion_id');
    }

}
