<?php
define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Test Autoloader
|--------------------------------------------------------------------------
|
| Just like basic autoloader, excepts it drops and recreates testing database
|
*/

require __DIR__.'/../vendor/autoload.php';

echo "Start bootstrapping tests.\n";

// Require app to access laravel helpers methods, to be able to require config/database.php
$app = require_once 'app.php';
$kernel = $app->make( Illuminate\Contracts\Http\Kernel::class );

// Load config var
$config = require( __DIR__ . "/../config/database.php" );
extract( $config['connections'][ $config['default'] ] );

// Override config default with actual db credentials (phpunit.xml value)
$username = env( 'DB_USERNAME_TEST', '' );
$password = env( 'DB_PASSWORD_TEST', '' );
$database = env( 'DB_DATABASE_TEST','ptb_test' );
$port = env('DB_PORT_TEST', env('DB_PORT', '5432'));

// Drop and recreate database
try {
    echo "Dropping and recreating database {$database}...\n";
    // Drop and recreate database
    $connectionString = "{$driver}:host={$host};port={$port};dbname={$database}";
    $connection = new PDO( $connectionString, $username, $password );
    $connection->query( "DROP DATABASE IF EXISTS " . $database );
    $connection->query( "CREATE DATABASE " . $database );
    $connection = null;

} catch ( PDOException $Exception ) {
    echo "\n \033[31m There was an error while dropping and recreating database. Please make sure you have a phpunit.xml file filled with the required information.\033[0m \n\n";
    echo $Exception->getMessage();
    echo $Exception->getTraceAsString();
    die();
}
echo "Done.\n";

echo "Migrating...\n";
if ( ! exec( 'php artisan migrate', $output ) ) {
    echo "\e[31m There was an error migrating the database:\e[0m \n";
    echo implode( "\n", $output );
    die();
}

//
//echo "Seeding...\n";
//if ( ! exec( 'php artisan db:seed --class=PtbSeeder ', $output ) ) {
//    echo "\e[31m There was an error while seeding testing database:\e[0m \n";
//    echo implode( "\n", $output );
//    die();
//}

echo "Tests bootstrapped.\n\n";
