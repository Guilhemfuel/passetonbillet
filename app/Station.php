<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * App\Station
 *
 * @property-read mixed $name
 * @property-read mixed $eurostar_id
 * @property-read mixed $short_name
 * @property-read mixed $country
 * @property-read mixed $timezone_txt
 * @property-read mixed $timezone
 * @mixin \Eloquent
 */
class Station extends Model
{
    use SearchableTrait, SoftDeletes;

    protected $dates = ['deleted_at'];

    public $timestamps = false;

    protected $fillable = [
        'eurostar_id',
        'name_fr',
        'name_en',
        'short_name',
        'country',
        'timezone_txt',
        'timezone'
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

    public static $rules = [
        'eurostar_id' => 'required|numeric',
        'name_fr' => 'required',
        'name_en' => 'required',
        'short_name' => 'required',
        'country' => 'required|max:2'
    ];

    /**
     * MUTATORS
     */

    public function getNameAttribute()
    {
        if ( \App::isLocale( 'en' ) ) {
            return $this->name_en;
        }
        else if ( \App::isLocale( 'fr' ) ) {
            return $this->name_fr;
        }
    }

    public function getFlagAttribute()
    {
        return "<span class=\"flag-icon flag-icon-".$this->country."\"></span>";
    }

}
