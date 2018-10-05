<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define( App\User::class, function ( Faker $faker ) {
    static $password;

    return [
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'gender'         => $faker->numberBetween( 0, 1 ),
        'phone_country'  => array_random( [ 'FR', 'EN' ] ),
        'phone'          => '0' . $faker->randomNumber( 9 ),
        'birthdate'      => $faker->dateTimeThisCentury->format( \App\Trains\Eurostar::DATE_FORMAT_DB ),
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
$factory->state( App\User::class, 'admin', function ( Faker $faker ) {
    return [
        'status' => 100,
    ];
} );

// User registered but not confirmed
$factory->state( App\User::class, 'not_confirmed', function ( Faker $faker ) {
    return [
        'email_token'    => str_random( 40 ),
        'email_verified' => false,
        'status'         => 0,
    ];
} );

// User not registered
$factory->state( App\User::class, 'not_registered', function ( Faker $faker ) {
    return [
        'status'                => null,
        'remember_token'        => null,
        'email_verified'        => false,
        'password'              => 'password',
        'password_confirmation' => 'password'
    ];
} );

// User without phone
$factory->state( App\User::class, 'phone_less', function ( Faker $faker ) {
    return [
        'phone_country' => null,
        'phone'         => null,
    ];
} );
