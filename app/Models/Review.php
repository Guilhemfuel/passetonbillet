<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    public $table = 'reviews';

    public $fillable = [
        'buyer_id',
        'ticket_id',
        'mark',
        'message'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'buyer_id'  => 'integer',
        'ticket_id' => 'integer',
        'mark'      => 'integer',
        'message'   => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'buyer_id'     => 'required|exists:users,id',
        'ticket_id'   => 'exists:tickets,id',
        'mark' => 'required',
    ];

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
}
