<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    public $table = 'discussions';

    public $fillable = [
        'ticket_id',
        'buyer_id',
        'status',
        'price'
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
        'price'     => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'buyer_id'  => 'required|exists:users,id',
        'ticket_id' => 'required|exists:tickets,id',
        'price'     => 'required|integer'
    ];

    /**
     * Mutators
     */

    public function getStatusAttibute( $value )
    {
        switch ($value){
            case -1:
                return 'denied';
            case 0:
                return 'awaiting';
            case 1:
                return 'accepted';
        }
    }

    public function getSellerAttribute(){
        return $this->ticket->user;
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

}
