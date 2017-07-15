<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Train
 *
 * @property-read $number
 * @property-read $departure_date
 * @property-read $departure_time
 * @property-read $departure_city
 * @property-read $arrival_date
 * @property-read $arrival_time
 * @property-read $arrival_city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @mixin \Eloquent
 */
class Train extends Model
{

    protected $fillable = [
        'number', 'departure_date', 'departure_time', 'arrival_date','arrival_time','departure_city','arrival_city'
    ];

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function departureCity(){
        return $this->hasOne('App\Station', 'id','departure_city');
    }

    public function arrivalCity(){
        return $this->hasOne('App\Station', 'id','arrival_city');
    }

}
