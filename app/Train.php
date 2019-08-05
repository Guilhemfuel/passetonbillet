<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
class Train extends BaseModel
{
    use SoftDeletes;



    protected $dates = ['deleted_at', 'departure_date','arrival_date'];

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
        'departure_date' => 'required|date_format:d/m/Y',
        'departure_time' => 'required',
        'arrival_date'   => 'required|date_format:d/m/Y',
        'arrival_time'   => 'required',
        'departure_city' => 'required|exists:stations,id|different:arrival_city',
        'arrival_city'   => 'required|exists:stations,id|different:departure_city'
    ];

    /**
     * Relationships of the model (used for eager loading)
     */
    public static $relationships = ['tickets'];

    /**
     * Automatically loaded relationships
     */
    public $with = ['departureCity','arrivalCity'];

    /**
     * Mutators
     */

    public function setDepartureTimeAttribute($value)
    {
        $time = new \DateTime($value);
        $this->attributes['departure_time'] = $time->format("H:i:s");
    }

    public function setArrivalTimeAttribute($value)
    {
        $time = new \DateTime($value);
        $this->attributes['arrival_time'] = $time->format("H:i:s");
    }

    public function getDepartureTimeJsAttribute()
    {
        return date( 'D M d Y H:i:s O', strtotime( $this->departure_time ) );
    }

    public function getArrivalTimeJsAttribute()
    {
        return date( 'D M d Y H:i:s O', strtotime( $this->arrival_time ) );
    }

    public function getCarbonDepartureDateAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->departure_date->format('Y-m-d').' '.$this->departure_time,$this->departureCity->timezone);
    }

    public function getCarbonArrivalDateAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->arrival_date->format('Y-m-d').' '.$this->arrival_time,$this->arrivalCity->timezone);
    }

    public function getDurationAttribute(  )
    {

        return $this->carbon_arrival_date->diffInMinutes($this->carbon_departure_date);
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
