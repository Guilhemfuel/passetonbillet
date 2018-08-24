<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Laravel\Scout\Searchable;
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

    use Searchable, SoftDeletes;

    protected $dates = [ 'deleted_at' ];

    public $timestamps = false;

    protected $fillable = [
        'id',
        'uic',
        'uic8_sncf',
        'name',
        'name_fr',
        'name_en',
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

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope( 'suggestable', function ( \Illuminate\Database\Eloquent\Builder $builder ) {
            $builder->where( 'is_suggestable', true );
            $builder->whereNotNull( 'uic' );

        } );
    }


    /**
     * List of searchable entities
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        // We only index parent station
        if ( $this->attributes == [] ) {
            return false;
        }

        return true;
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        if ( $this->attributes == [] ) {
            return [];
        }

        return [
            'id'      => $this->id,
            'name'    => $this->attributes['name'],
            'name_fr' => $this->attributes['name_fr'],
            'name_en' => $this->attributes['name_en']
        ];
    }


    /**
     * MUTATORS
     */

    public function getNameCountrySpecificAttribute()
    {
        if ( \App::isLocale( 'en' )
             && ! is_null( $this->name_en )
        ) {
            return $this->name_en;
        } else if ( \App::isLocale( 'fr' )
                    && ! is_null( $this->name_fr ) ) {
            return $this->name_fr;
        }

        return null;
    }

    public function getFlagAttribute()
    {
        return "<span class=\"flag-icon flag-icon-" . $this->country . "\"></span>";
    }

    /**
     * Methods
     */

    public static function sortedStations()
    {

        $stations = Station::all();
        $sortedCollection = collect( [] );
        if ( \App::isLocale( 'fr' ) ) {
            $sortedCollection->push( $stations->firstWhere( 'eurostar_id', self::PARIS_ID ) );
            $sortedCollection->push( $stations->firstWhere( 'eurostar_id', self::LONDON_ID ) );
        } else {
            $sortedCollection->push( $stations->firstWhere( 'eurostar_id', self::LONDON_ID ) );
            $sortedCollection->push( $stations->firstWhere( 'eurostar_id', self::PARIS_ID ) );
        }

        $sortedCollection->push( $stations->firstWhere( 'eurostar_id', self::BXL_ID ) );
        $sortedCollection->push( $stations->firstWhere( 'eurostar_id', self::AMS_ID ) );

        return $sortedCollection->merge(
            $stations->whereNotIn( 'eurostar_id', [ self::PARIS_ID, self::LONDON_ID, self::BXL_ID, self::AMS_ID ] )
        );
    }
}
