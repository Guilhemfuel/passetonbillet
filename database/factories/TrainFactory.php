<?php

use Faker\Generator as Faker;

$factory->define( App\Train::class, function ( Faker $faker ) {
    $station1 = \App\Station::inRandomOrder()->first();
    $station2 = \App\Station::inRandomOrder()->first();

    $date = new \Carbon\Carbon();
    $date->addDays( random_int( 1, 7 ) );

    $arrival = $date->copy()
                    ->addHours( random_int( 1, 5 ) )
                    ->addMinutes( random_int( 0, 59 ) );

    return [
        'number'         => $faker->numberBetween( 9001, 9050 ),
        'departure_date' => $date->format( \App\Trains\Eurostar::DATE_FORMAT_DB ),
        'departure_time' => $date->format('h:i:s'),
        'arrival_date'   => $arrival->format( \App\Trains\Eurostar::DATE_FORMAT_DB ),
        'arrival_time'   => $arrival->format('h:i:s'),
        'departure_city' => $station1->id,
        'arrival_city'   => $station2->id
    ];
} );