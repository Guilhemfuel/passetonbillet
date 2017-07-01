<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Train
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @mixin \Eloquent
 */
class Train extends Model
{

    protected $fillable = [
        'number', 'departure_date', 'departure_time','arrival_time','departure_city','arrival_city'
    ];

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

}
