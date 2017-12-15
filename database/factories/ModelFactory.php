<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define( App\User::class, function ( Faker\Generator $faker ) {
    static $password;

    return [
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'gender'         => $faker->numberBetween( 0, 1 ),
        'phone_country'  => array_random( [ 'FR', 'EN' ] ),
        'phone'          => $faker->randomNumber( 9 ),
        'birthdate'      => $faker->dateTimeThisCentury->format( \App\EurostarAPI\Eurostar::DATE_FORMAT_DB ),
        'language'       => array_random( [ 'FR', 'EN' ] ),
        'location'       => str_random( 10 ),
        'status'         => 1,
        'email'          => $faker->unique()->safeEmail,
        'email_verified' => true,
        'password'       => $password ?: $password = bcrypt( 'password' ),
        'remember_token' => str_random( 10 ),
    ];
} );

// Admin user
$factory->state( App\User::class, 'admin', function ( \Faker\Generator $faker ) {
    return [
        'status' => 100,
    ];
} );

// User registered but not confirmed
$factory->state( App\User::class, 'not_confirmed', function ( \Faker\Generator $faker ) {
    return [
        'email_token'    => str_random( 40 ),
        'email_verified' => false,
        'status'         => 0,
    ];
} );

// User not registered
$factory->state( App\User::class, 'not_registered', function ( \Faker\Generator $faker ) {
    return [
        'status'                => null,
        'remember_token'        => null,
        'email_verified'        => false,
        'password'              => 'password',
        'password_confirmation' => 'password'
    ];
} );

// User without phone
$factory->state( App\User::class, 'phone_less', function ( \Faker\Generator $faker ) {
    return [
        'phone_country'                => null,
        'phone'        => null,
    ];
} );

$factory->define( App\Station::class, function ( Faker\Generator $faker ) {
    return [
        'eurostar_id'  => $faker->randomNumber( 8 ),
        'name_fr'      => $faker->word,
        'name_en'      => $faker->word,
        'short_name'   => str_random( 2 ),
        'country'      => $faker->randomElement( [ 'fr', 'gb', 'be' ] ),
        'timezone_txt' => $faker->timezone,
        'timezone'     => "+01:00"
    ];
} );

$factory->define( App\Train::class, function ( Faker\Generator $faker ) {
    $station1 = \App\Station::inRandomOrder()->first();
    $station2 = \App\Station::where( 'id', '!=', $station1->id )->inRandomOrder()->first();

    $date = $faker->dateTimeThisMonth()->format( \App\EurostarAPI\Eurostar::DATE_FORMAT_DB );

    return [
        'number'         => $faker->randomNumber( 4 ),
        'departure_date' => $date,
        'departure_time' => $faker->time(),
        'arrival_date'   => $date,
        'arrival_time'   => $faker->time(),
        'departure_city' => $station1->id,
        'arrival_city'   => $station2->id
    ];
} );

$factory->define( App\Ticket::class, function ( Faker\Generator $faker ) {
    $train = factory( App\Train::class )->create();
    $user = factory( App\User::class )->create();

    return [
        'train_id'        => $train->id,
        'user_id'         => $user->id,
        'user_notes'      => $faker->text( 120 ),
        'price'           => $faker->numberBetween( 30, 100 ),
        'currency'        => $faker->numberBetween( 0, 1 ) ? 'EUR' : 'GBP',
        'bought_price'    => $faker->numberBetween( 30, 100 ),
        'bought_currency' => $faker->numberBetween( 0, 1 ) ? 'EUR' : 'GBP',
        'flexibility'     => $faker->numberBetween( 0, 3 ),
        'inbound'         => $faker->boolean(),
        'class'           => str_random( 2 ),
        'eurostar_code'   => $faker->text( 6 ),
        'buyer_email'     => $user->email,
        'buyer_name'      => $user->last_name,
    ];
} );

// Admin user
$factory->state( App\Ticket::class, 'new', function ( \Faker\Generator $faker ) {
    return [
        'user_id' => null,
        'price' => null,
        'currency' => null,
    ];
} );
