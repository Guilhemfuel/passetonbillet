<?php

namespace App\Models;

use App\Facades\AppHelper;
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
    const CAMPAIGN_NAME = 'alert-email';
    const CAMPAIGN_SOURCE = 'website-ptb';
    const CAMPAIGN_MEDIUM = 'mail';

    public $table = 'alerts';

    public static $relationships = [ 'user' ];

    public $fillable = [
        'user_id',
        'email',
        'travel_date_start',
        'travel_date_end',
        'departure_city',
        'arrival_city',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'           => 'integer',
        'email'             => 'string',
        'travel_date_start' => 'date',
        'travel_date_end'   => 'date',
        'departure_city'    => 'integer',
        'arrival_city'      => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id'           => 'nullable|exists:users,id|required_without:email',
        'email'             => 'nullable|string|required_without:user_id',
        'travel_date_start' => 'required|date_format:d/m/Y',
        'travel_date_end'   => 'required|date_format:d/m/Y',
        'departure_city'    => 'required|exists:stations,id|different:arrival_city',
        'arrival_city'      => 'required|exists:stations,id|different:departure_city',
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
     * Return link to the correct day
     */
    public function getHashAttribute(){
        return \Hashids::encode($this->id);
    }

    public function getLink( Carbon $date )
    {
        $url = route( 'public.ticket.buy.page' ) . '?departure_station=' . $this->departure_city .
               '&arrival_station=' . $this->arrival_city .
               '&departure_date=' . urlencode( $date->format( 'd/m/Y' ) );

        return AppHelper::googleCampaign( $url,
            self::CAMPAIGN_SOURCE,
            self::CAMPAIGN_MEDIUM,
            self::CAMPAIGN_NAME );
    }

    public static function current()
    {
        return self::where( 'travel_date_start', '>=', Carbon::now() );
    }
}
