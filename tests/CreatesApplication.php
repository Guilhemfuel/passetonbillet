<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use PDO;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make( Kernel::class )->bootstrap();

        // Drop and recreate database
        try {
            // Drop and recreate database
            $connection = new PDO( config( 'database.connections.testing.driver' ) . ":host=" . config( 'database.connections.testing.host' ), config( 'database.connections.testing.username' ), config( 'database.connections.testing.password' ) );
            $connection->query( "DROP DATABASE IF EXISTS " . config('database.connections.testing.database') );
            $connection->query( "CREATE DATABASE " . config('database.connections.testing.database'));
            $connection = null;

            // Create extension unaccent
            $connection = new PDO( config( 'database.connections.testing.driver' ) . ":host=". config( 'database.connections.testing.host' ) .";dbname=".config('database.connections.testing.database'), config( 'database.connections.testing.username' ), config( 'database.connections.testing.password' ) );
            $connection->query( "CREATE EXTENSION unaccent;" );
            $connection = null;
        } catch ( PDOException $Exception ) {
            echo "\n \033[31m There was an error while dropping and recreating database. Please make sure you have a phpunit.xml file filled with the required information.\033[0m \n\n";
            echo $Exception->getTraceAsString();
            die();
        }

        // TODO: migrate with seeder
        if ( ! exec( 'php "' . __DIR__ . '"/../artisan migrate --database='.config( 'database.connections.testing.driver' ), $output ) ) {
            echo "\e[31m There was an error bootstraping the tests:\e[0m \n";
            echo implode( "\n", $output );
            die();
        }

        return $app;
    }
}
