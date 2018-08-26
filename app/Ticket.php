<?php

namespace App;

use App\Exceptions\PasseTonBilletException;
use App\Traits\ScamFiltered;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * App\Ticket
 *
 * @property-read \App\Train $train
 * @property-read \App\User  $user
 * @mixin \Eloquent
 */
class Ticket extends Model
{

    const PROVIDERS = [ 'eurostar', 'thalys', 'sncf' ];

    use SearchableTrait, SoftDeletes, ScamFiltered;

    protected $dates = [ 'deleted_at', 'marked_as_fraud_at' ];

    protected $fillable = [
        // Train info
        'train_id',

        // User info
        'user_id',
        'user_notes',
        'price',
        'currency',

        // Id of user who bought ticket
        'sold_to_id',

        // Ticket info
        'flexibility',
        'class',
        'bought_price',
        'bought_currency',
        'inbound',
        'correspondance',
        'provider',
        'manual',

        // Buyer info
        'provider_code',
        'provider_id',
        'ticket_number',
        'passbook_link',
        'buyer_email',
        'buyer_name',

        'marked_as_fraud_at'
    ];

    /**
     * Relationships of the model (used for eager loading)
     */
    public static $relationships = [ 'user', 'train', 'discussions' ];

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
        'columns' => [
            'tickets.eurostar_code' => 10,
            'tickets.buyer_name'    => 5,
            'tickets.buyer_email'   => 5,
        ]
    ];

    public static $rules = [
        'user_id'         => 'required|exists:users,id',
        'sold_to_id'      => 'exists:users,id',
        'price'           => 'required|numeric',
        'bought_price'    => 'required|numeric',
        'currency'        => 'required',
        'bought_currency' => 'required',
        'correspondance'  => 'boolean',
        'inbound'         => 'required|boolean',
        'manual'          => 'nullable|boolean',
        'provider'        => 'required',
        'provider_code'   => 'nullable|max:6',
        'buyer_email'     => 'required|email',
        'buyer_name'      => 'required'
    ];

    /**
     * Search tickets for a specific journey (from date)
     *
     * @param      $departureStationId
     * @param      $arrivalStationId
     * @param      $date
     * @param null $time
     *
     * @return Collection
     */
    public static function applyFilters( $departureStationId, $arrivalStationId, $date, $time = null, $exactDay = false )
    {
        // Find parent station
        $departureStationParentId = Station::find($departureStationId)->parent_station_id;
        $arrivalStationParentId = Station::find($arrivalStationId)->parent_station_id;

        // Create array of possible departure stations
        if ( $departureStationParentId != null ){
            $departureStations = Station::where('parent_station_id',$departureStationParentId)->pluck('id');
            $departureStations[] = $departureStationParentId;
        } else {
            $departureStations = Station::where('parent_station_id',$departureStationId)->pluck('id');
            $departureStations[] = $departureStationParentId;
        }

        // Create array of possible arrival stations
        if ( $departureStationParentId != null ){
            $arrivalStations = Station::where('parent_station_id',$arrivalStationId)->pluck('id');
            $arrivalStations[] = $arrivalStationId;
        } else {
            $arrivalStations = Station::where('parent_station_id',$arrivalStationId)->pluck('id');
            $arrivalStations[] = $arrivalStationId;
        }

        // Find matching trains
        $request = Train::whereIn( 'departure_city', $departureStations )
                        ->whereIn( 'arrival_city', $arrivalStations )
                        ->where( 'departure_date', $exactDay ? '=' : '>=', $date )
                        ->with( 'tickets' );

        if ( $time ) {
            $request = $request->where( 'departure_time', '>=', $time );
        }

        $trains = $request->orderBy( 'departure_time' )->get();

        // Collect tickets for each of the trains
        $tickets = collect();
        foreach ( $trains as $train ) {
            if ( $train->tickets()->withoutScams() ) {
                foreach ( $train->tickets as $ticket ) {
                    if ( ( ! \Auth::check() ) || \Auth::user()->id != $ticket->user_id ) {
                        if ( $ticket->sold_to_id == null ) {
                            $tickets->push( $ticket );
                        }
                    }
                }
            }
        }

        return $tickets;
    }

    /**
     * Helper
     */
    private function getSymbolCurrency( $currency )
    {
        switch ( $currency ) {
            case "EUR":
            case "EFT":
                return '€';
                break;
            case "USD":
                return '$';
                break;
            case "GBP":
                return '£';
                break;
        }

        return '';
    }

    /**
     * MUTATORS
     */

    public function getPassedAttribute()
    {
        $now = new Carbon();

        return $this->train->carbon_departure_date->lt( $now );
    }

    public function getCurrencySymbolAttribute()
    {
        return $this->getSymbolCurrency( $this->currency );
    }

    public function getBoughtCurrencySymbolAttribute()
    {
        return $this->getSymbolCurrency( $this->bought_currency );
    }

//    public function getFlexibilityAttribute( $value )
//    {
//        return trans( 'common.ticket.flexibility.' . $value );
//    }

    public function getClassAttribute( $value )
    {
        //TODO: use JSON below to make string from class + add that to admin form attributes
        return $value;
    }

//{"fareFlexibility":{"1":{"code":"1","value":"Non Flexible"},"2":{"code":"2","value":"Semi Flexible"},"3":{"code":"3","value":"Fully Flexible"},"7":{"code":"7","value":"Off Peak"},"8":{"code":"8","value":"Advance"},"9":{"code":"9","value":"Anytime"}},"classOfService":{"B":{"code":"B","value":"Standard"},"H":{"code":"H","value":"Standard Premier"},"A":{"code":"A","value":"Business Premier"},"2":{"code":"2","value":"Standard Class"},"1":{"code":"1","value":"First Class"}}}

    public function getPdfFileNameAttribute()
    {
        return \Vinkla\Hashids\Facades\Hashids::connection( 'file' )->encode( $this->id ) . md5( $this->buyer_name . $this->eurostar_code ) . '.pdf';
    }

    public function getPdfDownloadedAttribute()
    {
        $filePath = 'pdf/tickets/' . $this->pdf_file_name;

        return \Storage::disk( 's3' )->exists( $filePath );
    }

    public function getStatusAttribute()
    {
        if ( $this->scam ) {
            return 'scam';
        } else if ( $this->sold_to_id ) {
            return 'sold';
        } else {
            if ( $this->passed ) {
                return 'passed';
            } else {
                return 'selling';
            }
        }
    }

    public function getScamAttribute()
    {
        return $this->marked_as_fraud_at != null;
    }

    public function setProviderAttribute( $value )
    {
        if (!in_array($value,self::PROVIDERS)){
            throw new PasseTonBilletException("Provider ${value} unknown.");
        }
        $this->attributes['provider'] = $value;
    }

    /**
     * RELATIONSHIPS
     */

    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }

    public function train()
    {
        return $this->belongsTo( 'App\Train' );
    }

    public function discussions()
    {
        return $this->hasMany( 'App\Models\Discussion' );
    }

    public function buyer()
    {
        return $this->belongsTo( 'App\User', 'sold_to_id' );
    }

    /**
     *
     * Boot
     *
     */

    protected static function boot()
    {
        parent::boot();

        static::deleting( function ( $ticket ) {
            $ticket->discussions()->delete();
        } );
    }

}
