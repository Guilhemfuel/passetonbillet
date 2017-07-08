<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ticket
 *
 * @property-read \App\Station $arrivalCity
 * @property-read \App\Station $departureCity
 * @property-read \App\Train $train
 * @property-read \App\User $user
 * @mixin \Eloquent
 */
class Ticket extends Model
{

    protected $fillable = [
        'train_id','user_id',
        'conditions', 'user_notes', 'class', //class: standard premier?...
        'price','currency',
        'bought_price','bought_currency',
        'eurostar_code','eurostar_name',  //Online Type
        'departure_city', 'arrival_city'
    ];

    //TODO: add inbound or ountbound, acheteur email nom prenom

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function train()
    {
        return $this->belongsTo('App\Train');
    }

    public function departureCity(){
        return $this->hasOne('App\Station', 'id','departure_city');
    }

    public function arrivalCity(){
        return $this->hasOne('App\Station', 'id','arrival_city');
    }

}
