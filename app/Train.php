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

    public static $rules = [
        'number'         => 'required|numeric',
        'departure_date' => 'required|date',
        'departure_time' => 'required|date',
        'arrival_date'   => 'required|date',
        'arrival_time'   => 'required|date',
        'departure_city' => 'required|exists:stations,id|different:arrival_city',
        'arrival_city'   => 'required|exists:stations,id|different:departure_city'
    ];

    /**
     * Relationships of the model (used for eager loading)
     */
    public static $relationships = ['tickets','departureCity','arrivalCity'];

    /**
     * Mutators
     */

    public function setDepartureTimeAttribute($value)
    {
        $time = new \DateTime($value);
        $this->attributes['departure_time'] = $time->format("h:i:s");
    }

    public function setArrivalTimeAttribute($value)
    {
        $time = new \DateTime($value);
        $this->attributes['arrival_time'] = $time->format("h:i:s");
    }

    public function getDepartureTimeJsAttribute()
    {
        return date( 'D M d Y H:i:s O', strtotime( $this->departure_time ) );
    }

    public function getArrivalTimeJsAttribute()
    {
        return date( 'D M d Y H:i:s O', strtotime( $this->arrival_time ) );
    }

    /**
     * Relationships
     */

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
