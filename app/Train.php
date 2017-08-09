<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

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

    use SearchableTrait;

    protected $fillable = [
        'number',
        'departure_date',
        'departure_time',
        'arrival_date',
        'arrival_time',
        'departure_city',
        'arrival_city'
    ];

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
        // TODO: fix train search
        
        'columns' => [
            'trains.number' => 5,
            'trains.departure_date' => 5,
            'trains.departure_time' => 5,
        ],
    ];

    public static $rules = [
        'number' => 'required|numeric',
        'departure_date' => 'required|date',
        'departure_time' => 'required|date',
        'arrival_date'  => 'required|date',
        'arrival_time' => 'required|date',
        'departure_city' => 'required|exists:stations,id|different:arrival_city',
        'arrival_city'  => 'required|exists:stations,id|different:departure_city'
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
