<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Store user alerts
 *
 * Class Alert
 * @package App\Models
 */
class Alert extends Model
{
    public $table = 'alerts';

    public static $relationships = ['user'];

    public $fillable = [
        'user_id',
        'max_price',
        'travel_date',
        'departure_station',
        'arrival_station',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'           => 'integer',
        'max_price'         => 'integer',
        'travel_date'       => 'date',
        'departure_station' => 'integer',
        'arrival_station'   => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id'           => 'required|exists:users,id',
        'max_price'         => 'required|integer',
        'travel_date'       => 'required|date',
        'departure_station' => 'required|exists:stations,id|different:arrival_station',
        'arrival_station'   => 'required|exists:stations,id|different:departure_station',
    ];


    /**
     * RelationShips
     */

    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }

    public function departureStation()
    {
        return $this->hasOne( 'App\Station', 'id', 'departure_station' );
    }

    public function arrivalStation()
    {
        return $this->hasOne( 'App\Station', 'id', 'arrival_station' );
    }
}
