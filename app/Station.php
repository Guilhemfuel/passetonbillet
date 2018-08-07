<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * App\Station
 *
 * @mixin \Eloquent
 */
class Station extends Model
{

    CONST LONDON_ID = 7015400;
    CONST PARIS_ID = 8727100;
    CONST BXL_ID = 8814001;
    CONST AMS_ID = 8400058;

    use SearchableTrait, SoftDeletes;

    protected $dates = ['deleted_at'];

    public $timestamps = false;

    protected $fillable = [
        'id',
        'uic',
        'uic8_sncf',
        'name',
        'parent_station_id',
        'slug',
        'country',
        'timezone',
        'sncf_id',
        'same_as',
        'is_suggestable',
        'data'
    ];

    /**
     * Relationships of the model (used for eager loading)
     */
    public static $relationships = [];

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
            'stations.name_fr' => 10,
            'stations.name_en' => 10,
            'stations.short_name' => 8,
        ]
    ];


    /**
     * MUTATORS
     */

    public function getNameAttribute()
    {
        if ( \App::isLocale( 'en' )
             && isset($this->data['name_en'])
             && $this->data['name_en']!=""
        ) {
            return $this->data['name_en'];
        }
        else if ( \App::isLocale( 'fr' )
                  && isset($this->data['name_fr'])
                  && $this->data['name_fr']!="") {
            return $this->data['name_fr'];
        }
        return $this->attributes['name'];
    }

    public function getFlagAttribute()
    {
        return "<span class=\"flag-icon flag-icon-".$this->country."\"></span>";
    }

    /**
     * Methods
     */

    public static function sortedStations()
    {

        $stations = Station::all();
        $sortedCollection = collect([]);
        if (\App::isLocale( 'fr' )){
            $sortedCollection->push( $stations->firstWhere('eurostar_id',self::PARIS_ID) );
            $sortedCollection->push( $stations->firstWhere('eurostar_id',self::LONDON_ID) );
        } else {
            $sortedCollection->push( $stations->firstWhere('eurostar_id',self::LONDON_ID) );
            $sortedCollection->push( $stations->firstWhere('eurostar_id',self::PARIS_ID) );
        }

        $sortedCollection->push( $stations->firstWhere('eurostar_id',self::BXL_ID) );
        $sortedCollection->push( $stations->firstWhere('eurostar_id',self::AMS_ID) );
        return $sortedCollection->merge(
            $stations->whereNotIn('eurostar_id',[self::PARIS_ID,self::LONDON_ID,self::BXL_ID,self::AMS_ID])
        );
    }
}
