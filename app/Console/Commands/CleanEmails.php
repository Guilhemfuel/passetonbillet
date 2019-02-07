<?php

namespace App\Console\Commands;

use App\Models\EmailSent;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:clean-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all sent emails from the database older than two weeks.';

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
        $current_date = Carbon::now();
        $past_date = $current_date->subWeeks(2);
        $old_mail = EmailSent::whereDate('updated_at', '<', $past_date)->get();
        $n = count( $old_mail );
        $this->info( "Deleting " . $n . " emails that were sent before " . $past_date );
        $bar = $this->output->createProgressBar( $n );
        $bar->start();
        foreach ($old_mail as $mail) {
            $bar->advance();
            $mail->delete();
        }
        $bar->finish();
    }
}
