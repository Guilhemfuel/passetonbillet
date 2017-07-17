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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    //TODO: update user factory

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Station::class, function (Faker\Generator $faker) {
    return [
        'eurostar_id' => $faker->randomNumber(8),
        'name_fr' => $faker->word,
        'name_en' => $faker->word,
        'short_name' => str_random(2),
        'country' => $faker->country,
        'timezone_txt' => $faker->timezone,
        'timezone' => "+01:00"
    ];
});

$factory->define(App\Train::class, function (Faker\Generator $faker) {
    return [
        'number' => $faker->randomNumber(4),
        'departure_date' => $faker->date(\App\EurostarAPI\Eurostar::DATE_FORMAT_DB),
        'departure_time' => $faker->time(),
        'arrival_date' => $faker->date(\App\EurostarAPI\Eurostar::DATE_FORMAT_DB),
        'arrival_time' => $faker->time(),
        'departure_city' => function() {
            return factory(App\Station::class)->create()->id;
        },
        'arrival_city' => function() {
            return factory(App\Station::class)->create()->id;
        }
    ];
});

$factory->define(App\Ticket::class, function (Faker\Generator $faker) {
    return [
        //TODO: ticket factory
    ];
});

