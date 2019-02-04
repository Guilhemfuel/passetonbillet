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
        $old_trains = Train::whereDate('departure_date', '<', $past_date)->get();
        $n = count ( $old_trains );

        $this->info("Deleting from " . $n . " tickets");

        $bar = $this->output->createProgressBar( $n );
        $bar->start();
        foreach ($old_trains as $train) {

            /* Get the ticket associate with this train */
            $ticket = Ticket::find( $train->id);

            if ($ticket != null) {

                /* The name of the pdf file */
                $filePath = 'pdf/tickets/' . $ticket->pdf_file_name;
                \Storage::disk( 's3' )->delete( $filePath );

            }
            $bar->advance();

        }
        $bar->finish();
    }
}
