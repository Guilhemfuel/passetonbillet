<?php

namespace App\Console\Commands;


use App\Ticket;
use App\Train;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:clean-tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all tickets older than 2 weeks from the database, as well as deleting 
                              the pdf, if it has been downloaded';

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

        /* Get all trains more than 2 weeks old */
        $oldTrains = Train::whereDate('departure_date', '<', $past_date)->get();
        $n = count ( $oldTrains );

        $this->info("Deleting tickets from " . $n . " trains");

        $bar = $this->output->createProgressBar( $n );
        $bar->start();
        $oldTickets = collect();
        $count = 0;
        foreach ( $oldTrains as $train ) {
            $tickets = $train->tickets();
            /* The name of the pdf file */
            foreach ( $tickets as $ticket ) {
                $filePath = 'pdf/tickets/' . $ticket->pdf_file_name;
                if ($ticket->pdf_downloaded == true && \Storage::disk( 's3' )->delete( $filePath )){
                    $count += 1;
                }
            }
            $bar->advance();
        }
        $bar->finish();
        $this->line('');
        $this->info($count . " tickets deleted");
    }
}
