<?php

use Faker\Generator as Faker;

$factory->define( App\Ticket::class, function ( Faker $faker ) {
    $train = factory( \App\Train::class )->create();
    $user = factory( \App\User::class )->create();


    return [
        'train_id'        => $train->id,
        'user_id'         => $user->id,
        'user_notes'      => $faker->text( 120 ),
        'price'           => $faker->numberBetween( 30, 100 ),
        'currency'        => $faker->numberBetween( 0, 1 ) ? 'EUR' : 'GBP',
        'bought_price'    => $faker->numberBetween( 30, 100 ),
        'bought_currency' => $faker->numberBetween( 0, 1 ) ? 'EUR' : 'GBP',
        'flexibility'     => $faker->numberBetween( 0, 3 ),
        'class'           => str_random( 2 ),
        'inbound'         => $faker->boolean,
        'correspondence'  => $faker->boolean,
        'manual'          => $faker->boolean,
        'provider'        => array_random( \App\Ticket::PROVIDERS ),
        'provider_code'   => $faker->text( 6 ),
        'provider_id'     => $faker->text( 6 ),
        'ticket_number'   => $faker->text( 6 ),
        'buyer_email'     => $user->email,
        'buyer_name'      => $user->last_name,
    ];
} );

// Unsaved ticket
$factory->state( App\Ticket::class, 'new', function ( Faker $faker ) {
    return [
        'user_id'  => null,
        'price'    => null,
        'currency' => null,
    ];
} );