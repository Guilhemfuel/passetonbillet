<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //Two types of tickets: the online tickets, and the printed tickets
    protected $fillable = [
        'train_id','user_id',
        'conditions', 'user_notes', 'class', //class: standard premier?...
        'price','currency',
        'bought_price','bought_currency',
        'type', //Online or paper
        'eurostar_code','eurostar_name',  //Online Type
    ];

    //TODO: belongs to one train, belongs to one user

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function train()
    {
        return $this->belongsTo('App\Train');
    }

}
