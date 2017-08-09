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

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'gender' => $faker->numberBetween(0,1),
        'phone_country' => $faker->numberBetween(0,1)?'FR':'EN',
        'phone' => $faker->phoneNumber,
        'birthdate' => $faker->dateTimeThisCentury->format(\App\EurostarAPI\Eurostar::DATE_FORMAT_DB),
        'language' => str_random(2),
        'status' => 1,
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
    $station1 = \App\Station::inRandomOrder()->first();
    $station2 = \App\Station::where('id','!=',$station1->id)->inRandomOrder()->first();

    $date = $faker->dateTimeThisMonth()->format(\App\EurostarAPI\Eurostar::DATE_FORMAT_DB);
    return [
        'number' => $faker->randomNumber(4),
        'departure_date' => $date,
        'departure_time' => $faker->time(),
        'arrival_date' => $date,
        'arrival_time' => $faker->time(),
        'departure_city' => $station1->id,
        'arrival_city' => $station2->id
    ];
});

$factory->define(App\Ticket::class, function (Faker\Generator $faker) {
    $train = factory(App\Train::class)->create();
    $user = factory(App\User::class)->create();
    return [
        'train_id' => $train->id,
        'user_id' => $user->id,
        'user_notes' => $faker->text(120),
        'price' => $faker->numberBetween(30,100),
        'currency' => $faker->numberBetween(0,1)?'EUR':'GBP',
        'bought_price' => $faker->numberBetween(30,100),
        'bought_currency' => $faker->numberBetween(0,1)?'EUR':'GBP',
        'flexibility' => $faker->numberBetween(0,3),
        'inbound' => $faker->boolean(),
        'class' => str_random(2),
        'eurostar_code' => $faker->text(6),
        'buyer_email' => $user->email,
        'buyer_name' => $user->last_name,
    ];
});

