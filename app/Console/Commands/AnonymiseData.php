<?php

namespace App\Console\Commands;

use App\Ticket;
use App\User;
use Illuminate\Console\Command;

use Faker\Factory as Faker;

class AnonymiseData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:anonymise-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Anonymise each user in the database apart from admins.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (\App::environment() == 'production') {
            $this->error('Can not be run in production mode. STOPPING');
            return;
        }

        $faker = Faker::create();

        $this->line('Starting to create fake users...');

        foreach (User::all() as $user) {
            if ($user->isAdmin()) {
                continue;
            }

            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->email = strtolower( $user->first_name ) .'_'. strtolower($user->last_name).$faker->numberBetween(1,100).array_random(['@gmail.com','@gmail.fr','@mycompany.com','@msn.com','@yahoo.fr']);
            $user->phone = $faker->unique()->phoneNumber;
            $user->save();
        }

        $this->line('Done.');
    }
}
