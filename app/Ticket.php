<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ticket
 *
 * @property-read \App\Train $train
 * @property-read \App\User  $user
 * @mixin \Eloquent
 */
class Ticket extends Model
{

    protected $fillable = [
        // Train info
        'train_id',

        // User info
        'user_id',
        'user_notes',
        'price',
        'currency',

        // Ticket info
        'flexibility',
        'class',
        'bought_price',
        'bought_currency',
        'inbound',

        // Buyer info
        'eurostar_code',
        'buyer_email',
        'buyer_name',
    ];

    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }

    public function train()
    {
        return $this->belongsTo( 'App\Train' );
    }

    public function getFlexibilityAttribute( $value )
    {
        return trans( 'common.ticket.flexibility.' . $value );
    }

    public function getClassAttribute( $value )
    {
        //TODO: use JSON below to make string from class
        return $value;
    }

//{"fareFlexibility":{"1":{"code":"1","value":"Non Flexible"},"2":{"code":"2","value":"Semi Flexible"},"3":{"code":"3","value":"Fully Flexible"},"7":{"code":"7","value":"Off Peak"},"8":{"code":"8","value":"Advance"},"9":{"code":"9","value":"Anytime"}},"classOfService":{"B":{"code":"B","value":"Standard"},"H":{"code":"H","value":"Standard Premier"},"A":{"code":"A","value":"Business Premier"},"2":{"code":"2","value":"Standard Class"},"1":{"code":"1","value":"First Class"}}}

}
