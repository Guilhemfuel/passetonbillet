<?php

use Illuminate\Database\Seeder;

class PtbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 20)->create();
        echo "Created users. \n";

        factory(\App\Station::class, 20)->create();
        echo "Created Stations. \n";

        factory(\App\Train::class, 20)->create();
        echo "Created Trains. \n";
//
        factory(\App\Ticket::class, 20)->create();
    }
}
