<?php

namespace App\Models;

use Carbon\Carbon;
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

    public static $relationships = [ 'user' ];

    public $fillable = [
        'user_id',
        'email',
        'travel_date',
        'departure_city',
        'arrival_city',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'        => 'integer',
        'email'          => 'string',
        'travel_date'    => 'date',
        'departure_city' => 'integer',
        'arrival_city'   => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id'        => 'nullable|exists:users,id|required_without:travel_date',
        'email'          => 'nullable|string|required_without:user_id',
        'travel_date'    => 'required|date_format:d/m/Y',
        'departure_city' => 'required|exists:stations,id|different:arrival_city',
        'arrival_city'   => 'required|exists:stations,id|different:departure_city',
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
        return $this->hasOne( 'App\Station', 'id', 'departure_city' );
    }

    public function arrivalStation()
    {
        return $this->hasOne( 'App\Station', 'id', 'arrival_city' );
    }

    /**
     * Mutators
     */

    public function getLinkAttribute()
    {
        return route( 'public.ticket.buy.page' ) . '?departure_station=' . $this->departure_city .
               '&arrival_station=' . $this->arrival_city .
               '&departure_date=' . urlencode( $this->travel_date->format( 'd/m/Y' ) );
    }

    public static function current(  )
    {
        return self::where('travel_date','>=',Carbon::now());
    }
}
