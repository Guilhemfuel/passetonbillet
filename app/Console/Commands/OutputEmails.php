<?php

namespace App\Console\Commands;

use App\Mail\Verification\IdConfirmedMail;
use App\Mail\Verification\IdDeniedMail;
use Illuminate\Console\Command;

class OutputEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:output-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Output all emails in storage path to see them.';

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
        $path = storage_path('emails/');

        // Check if folder exist or create it
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }


    }

    /**
     * Below are all the individual email functions
     */

    private function idConfirmedEmail() {

    }

}
