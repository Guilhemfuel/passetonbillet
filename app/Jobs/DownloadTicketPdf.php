<?php

namespace App\Jobs;

use App\Facades\Sncf;
use App\Facades\Thalys;
use App\Mail\ContactEmail;
use App\Mail\ErrorEmail;
use App\Models\AdminWarning;
use App\User;
use Exception;
use App\Facades\Eurostar;
use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DownloadTicketPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ticket;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( Ticket $ticket )
    {
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ( $this->ticket->provider ) {
            case 'eurostar':
                Eurostar::downloadAndReuploadPDF( $this->ticket );
                break;
            case 'sncf':
                Sncf::downloadAndReuploadPDF( $this->ticket );
                break;
            case 'thalys':
                Thalys::downloadAndReuploadPDF( $this->ticket );
                break;
            default:
                return;
        }
    }

    /**
     * The job failed to process.
     *
     * @param  Exception $exception
     *
     * @return void
     */
    public function failed( Exception $exception )
    {
        AdminWarning::create( [
            'action' => AdminWarning::ACTION_PDF_DOWNLOAD_FAILED,
            'link'   => route( 'tickets.edit', $this->ticket->id ),
            'data'   => [
                'Exception' => trim( $exception->getMessage() ),
                'File'      => trim( $exception->getFile() ),
                'Line'      => trim( $exception->getLine() )
            ]
        ] );
    }
}
