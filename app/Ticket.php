<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * App\Ticket
 *
 * @property-read \App\Train $train
 * @property-read \App\User  $user
 * @mixin \Eloquent
 */
class Ticket extends Model
{

    use SearchableTrait;

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

    /**
     * Relationships of the model (used for eager loading)
     */
    public static $relationships = ['user','train'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'tickets.eurostar_code' => 10,
            'tickets.buyer_name'    => 5,
            'tickets.buyer_email'   => 5,
        ]
    ];

    public static $rules = [
        'user_id'         => 'required|exists:users,id',
        'price'           => 'required|numeric',
        'bought_price'    => 'required|numeric',
        'currency'        => 'required',
        'bought_currency' => 'required',
        'inbound'         => 'required|boolean',
        'eurostar_code'   => 'required',
        'buyer_email'     => 'required|email',
        'buyer_name'      => 'required|max:6'
    ];

    /**
     * MUTATORS
     */

//    public function getFlexibilityAttribute( $value )
//    {
//        return trans( 'common.ticket.flexibility.' . $value );
//    }

    public function getClassAttribute( $value )
    {
        //TODO: use JSON below to make string from class + add that to admin form attributes
        return $value;
    }

//{"fareFlexibility":{"1":{"code":"1","value":"Non Flexible"},"2":{"code":"2","value":"Semi Flexible"},"3":{"code":"3","value":"Fully Flexible"},"7":{"code":"7","value":"Off Peak"},"8":{"code":"8","value":"Advance"},"9":{"code":"9","value":"Anytime"}},"classOfService":{"B":{"code":"B","value":"Standard"},"H":{"code":"H","value":"Standard Premier"},"A":{"code":"A","value":"Business Premier"},"2":{"code":"2","value":"Standard Class"},"1":{"code":"1","value":"First Class"}}}

    /**
     * RELATIONSHIPS
     */

    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }

    public function train()
    {
        return $this->belongsTo( 'App\Train' );
    }


}
