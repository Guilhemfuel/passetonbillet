<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class Empower extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lastar:empower {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user an admin';

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
        $user = User::where('email',$this->argument('email'))->first();
        if (! $user){
            $this->alert('User not found!');
            return;
        }

        $choice = $this->ask('Do you really want to make this user an admin (y/n)?');
        if ( !($choice=='y' || $choice=='Y') ){
            $this->line('Exit without empowering user.');
            return;
        }

        $user->status = 100;
        $user->save();
        $this->line('User empowered.');

    }
}
