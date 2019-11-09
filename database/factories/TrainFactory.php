<?php

use Faker\Generator as Faker;

$factory->define( App\Train::class, function ( Faker $faker ) {
    $station1 = \App\Station::inRandomOrder()->first();
    $station2 = \App\Station::inRandomOrder()->first();

    $date = new \Carbon\Carbon();
    $date->addDays( random_int( 0, 30 ) );
    $date->addMonths( random_int( 0, 12 ) );
    $date->addYears( random_int( 0, 10 ) );

    return [
        'number'         => $faker->numberBetween( 9001, 9050 ),
        'departure_date' => $date->format( \App\Trains\Eurostar::DATE_FORMAT_DB ),
        'departure_time' => $faker->time(),
        'arrival_date'   => $date->format( \App\Trains\Eurostar::DATE_FORMAT_DB ),
        'arrival_time'   => $faker->time(),
        'departure_city' => $station1->id,
        'arrival_city'   => $station2->id
    ];
} );