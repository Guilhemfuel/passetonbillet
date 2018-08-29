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
        factory(App\User::class, 50)->create();
        factory(App\Ticket::class, 50)->create();
        factory(App\Train::class, 50)->create();
    }
}
