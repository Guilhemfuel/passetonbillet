<?php

namespace App\Console\Commands;

use App\Models\AdminWarning;
use App\Models\Alert;
use App\Models\Statistic;
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
    protected $description = 'Anonymise each user in the database apart from admins and generate a database dump.';

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

        ini_set( 'memory_limit', '1G' );

        $faker = Faker::create();

        $this->line('Starting to create fake users...');

        // Cleaning users
        foreach (User::all() as $user) {
            //TODO: set password to passsword
            $user->password = bcrypt('password');

            if ($user->isAdmin()) {
                $user->save();
                continue;
            }


            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->email = strtolower( $user->first_name ). $faker->numberBetween(1,100) .'_'. strtolower($user->last_name).$faker->numberBetween(1,100) .
                           array_random(['@gmail.com','@gmail.fr','@mycompany.com','@msn.com','@yahoo.fr','@passetonbillet.fr']);
            $user->phone = $faker->unique()->phoneNumber;
            $user->save();
        }

        $this->line('Starting to anonymise alerts...');

        // Cleaning alerts
        foreach (Alert::all() as $alert) {
            if ($alert->email) {
                $alert->email = $faker->email;
                $alert->save();
            }
        }

        // Truncate logs table and warnings
        $this->line('Done. Truncating admin warning and logs.');
        AdminWarning::truncate();
        Statistic::truncate();

        $this->line('Done.');
    }
}
