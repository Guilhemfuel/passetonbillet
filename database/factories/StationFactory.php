<?php

use Faker\Generator as Faker;

$factory->define( App\Station::class, function ( Faker $faker ) {

    $nameFr = $faker->word;
    $nameEn = $faker->word;
    $name = $faker->word;

    return [
//        'id'                => $id + 1,
        'uic'               => $faker->unique()->randomNumber( 8 ),
        'uic8_sncf'         => $faker->randomNumber( 8 ),
        'name'              => $name,
        'name_fr'           => $nameFr,
        'name_en'           => $nameEn,
        'parent_station_id' => null,
        'slug'              => $faker->word,
        'country'           => $faker->randomElement( [ 'fr', 'gb', 'be' ] ),
        'timezone'          => $faker->timezone,
        'sncf_id'           => $faker->text,
        'is_suggestable'    => true,
        'data'              => "{}",
        'n_grams'           => (new \TeamTNT\TNTSearch\Indexer\TNTIndexer())->buildTrigrams( $name ),
        'n_grams_fr'        =>  (new \TeamTNT\TNTSearch\Indexer\TNTIndexer())->buildTrigrams( $nameFr ),
        'n_grams_en'        =>  (new \TeamTNT\TNTSearch\Indexer\TNTIndexer())->buildTrigrams( $nameEn ),
    ];
} );
