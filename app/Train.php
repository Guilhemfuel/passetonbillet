<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{

    protected $fillable = [
        'number', 'departure_date', 'departure_time','arrival_time','departure_city','arrival_city'
    ];

}
