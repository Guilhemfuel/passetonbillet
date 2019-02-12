<?php

namespace App\Console\Commands;

use App\Jobs\DownloadTicketPdf;
use App\Ticket;
use Illuminate\Console\Command;

class DownloadAllMissingTicketPdfs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:download-ticket-pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download all pdfs for current tickets.';

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
            $choice = $this->ask('Do you really want to run this command (y/n)?');
            if ( !($choice=='y' || $choice=='Y') ){
                $this->line('Exit without downloading tickets\' pdf.');
                return;
            }
        }

        $tickets = Ticket::currentTickets();
        $this->line($tickets->count().' current tickets were found.');

        $count_total = $tickets->count();
        $count_success = 0;
        $count_fail = 0;
        if ($count_total == 0) {
            $this->info('No current tickets were found. Exiting command');
        }
        else {
            $this->info('Downloading from ' . $count_total . ' current tickets');
            $bar = $this->output->createProgressBar($count_total);
            $bar->start();
            foreach ($tickets as $ticket) {
                // Only if ticket has not been downloaded yet, and $ticket was added via api (has booking code)
                if ( ! $ticket->pdf_downloaded && $ticket->provider_code ) {
                    try {
                        DownloadTicketPdf::dispatch( $ticket );
                        $count_success++;
                    } catch ( \Exception $e ) {
                        $this->error( "\n\r" .$e->getMessage());
                        $count_fail++;
                    }
                }
                $bar->advance();
            }
            $bar->finish();
            $this->line('Done.');
            $this->line($count_success. ' tickets successfully queued.');
            $this->line($count_fail . ' tickets failed to download.');
        }
    }
}
