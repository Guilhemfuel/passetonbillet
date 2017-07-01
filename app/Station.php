<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function getNameAttribute()
    {
        if ( App::isLocale( 'en' ) ) {
            return $this->name_en;
        }
        else if ( App::isLocale( 'fr' ) ) {
            return $this->name_fr;
        }
    }

}
