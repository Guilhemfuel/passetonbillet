<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Train
 *
 * @property                                                        $number
 * @property                                                        $departure_date
 * @property                                                        $departure_time
 * @property                                                        $departure_city
 * @property                                                        $arrival_date
 * @property                                                        $arrival_time
 * @property                                                        $arrival_city
 * @property \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @mixin \Eloquent
 */
class Train extends Model
{

    protected $fillable = [
        'number',
        'departure_date',
        'departure_time',
        'arrival_date',
        'arrival_time',
        'departure_city',
        'arrival_city'
    ];

    public function tickets()
    {
        return $this->hasMany( 'App\Ticket' );
    }

    public function departureCity()
    {
        return $this->hasOne( 'App\Station', 'id', 'departure_city' );
    }

    public function arrivalCity()
    {
        return $this->hasOne( 'App\Station', 'id', 'arrival_city' );
    }

}
