<?php

namespace App\Http\Controllers\Admin;

use App\Events\TicketAddedEvent;
use App\Http\Requests\Admin\TicketRequest;
use App\Http\Resources\Admin\TicketTableResource;
use App\Http\Resources\StationRessource;
use App\Jobs\DownloadTicketPdf;
use App\Models\Discussion;
use App\Notifications\OfferNotification;
use App\Station;
use App\Ticket;
use App\User;
use Faker\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class TicketController extends BaseController
{
    protected $CRUDmodelName = 'tickets';
    protected $CRUDsingularEntityName = 'Ticket';

    protected $model = Ticket::class;
    protected $creatable = false;
    protected $searchable = false;
    protected $paginable = false;

    /**
     * Show a list of all entities
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index( Request $request )
    {

        $data = [
            'searchable' => $this->searchable,
            'creatable'  => $this->creatable
        ];

        return $this->ptbView( 'admin.CRUD.index', $data );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        $entity = $this->model::withScams()->find( $id );
        if ( ! $entity ) {
            flash()->error( 'Entity not found!' );

            return redirect()->back();
        }

        return $this->ptbView( 'admin.CRUD.edit', [ 'entity' => $entity ] );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        flash()->error( "You can't create an admin." );

        return redirect()->route( $this->CRUDmodelName . '.index' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        flash()->success( $this->CRUDsingularEntityName . ' can\'t be created like that!' );

        return redirect()->route( $this->CRUDmodelName . '.index' );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id )
    {
        $ticket = Ticket::find( $id );
        if ( ! $ticket ) {
            flash()->error( 'Ticket not found!' );

            return redirect()->back();
        }

        // Staging/dev functionality to change train departure date
        if ( \App::environment() != 'production' && $request->has( 'departure_date' )
             && $request->get( 'departure_date' ) != '' && $request->get( 'departure_date' ) != null
        ) {
            $this->changeTicketDateForTest( $request, $ticket );
        }

        $ticket->update( $request->all() );
        $ticket->save();

        flash()->success( 'Ticket updated!' );

        return redirect()->route( $this->CRUDmodelName . '.edit', $ticket->id );
    }

    /**
     * Update train date for testing purposes
     *
     * @param Request $request
     *
     * @return bool
     */
    private function changeTicketDateForTest( Request $request, Ticket $ticket )
    {
        $this->validate( $request, [
            'departure_date' => 'date_format:d/m/Y'
        ] );

        $train = $ticket->train;
        $train->departure_date = $request->departure_date;
        $train->arrival_date = $request->departure_date;
        $train->save();

        return true;
    }

    /**
     * Reevert the status of a ticket back to unsold.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function revertStatus( Request $request, $ticket_id )
    {

        $ticket = Ticket::find( $ticket_id );
        $discussion = $ticket->discussion_sold;

        if ( $ticket === null ) {
            flash()->error( 'Ticket not found!' );
        } else if ( $discussion === null ) {
            flash()->error( 'Discussion not found!' );
        } else if ( $ticket->passed === true ) {
            flash()->error( 'The ticket has expired' )->important();
        } else {

            $ticket->sold_to_id = null;
            $discussion->status = Discussion::AWAITING;
            $discussion->save();
            $ticket->save();


            flash()->success( 'Ticket status successfully reverted' );
        }

        return redirect()->route( $this->CRUDmodelName . '.edit', $ticket->id );
    }

    /**
     * Re-deownload a pdf for a ticket
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function redownload( Request $request, $ticket_id )
    {
        $ticket = Ticket::find( $ticket_id );
        if ( ! $ticket ) {
            flash()->error( 'Ticket not found!' );

            return redirect()->back();
        }

        if ( $ticket->passed ) {
            flash()->error( 'Can\'t redownload pdf of past ticket!' );

            return redirect()->back();
        }

        DownloadTicketPdf::dispatch( $ticket );

        flash()->success( 'Done! Pdf should be updated in less than 5 minutes.' );

        return redirect()->route( $this->CRUDmodelName . '.edit', $ticket->id );
    }

    /**
     * Manually upload a pdf for a ticket
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function pdfManualUpload( Request $request, $ticket_id )
    {
        $ticket = Ticket::find( $ticket_id );
        if ( ! $ticket ) {
            flash()->error( 'Ticket not found!' );

            return redirect()->back();
        }

        if ( $ticket->passed ) {
            flash()->error( 'Can\'t upload pdf of past ticket!' );

            return redirect()->back();
        }

        $request->validate( [
            'ticket_pdf' => 'required|file|max:5000|mimes:pdf'
        ] );

        \Storage::disk( 's3' )->putFileAs( 'pdf/tickets/', $request->ticket_pdf, $ticket->pdf_file_name );

        flash()->success( 'Done! Pdf uplodaded.' );

        return redirect()->route( $this->CRUDmodelName . '.edit', $ticket->id );
    }


    /**
     * Mark ticket as scam, and ban user
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsFraud( Request $request, $id )
    {
        $ticket = Ticket::find( $id );
        if ( ! $ticket ) {
            \Session::flash( 'danger', 'Entity not found!' );

            return redirect()->back();
        }

        $ticket->scam();

        $user = $ticket->user;
        if ( ! $user ) {
            \Session::flash( 'danger', 'Ticket marked as scam, but user was not found!' );

            return redirect()->back();
        }

        if ( ! in_array( $user->status, [
            User::STATUS_USER,
            User::STATUS_UNCONFIRMED_USER,
            User::STATUS_UNINVITED_USER
        ] ) ) {
            \Session::flash( 'danger', 'Only active user (non admin) can be banned!' );

            return redirect()->back();
        }

        $user->status = User::STATUS_BANNED_USER;
        $user->save();

        flash( 'Ticket marked as scam, and user banned.' )->success();

        return redirect()->route( $this->CRUDmodelName . '.edit', $ticket->id );
    }

    /**
     * Restore a deleted ticket
     */
    public function restore( Request $request, $id )
    {
        $ticket = Ticket::onlyTrashed()->find( $id );
        if ( ! $ticket ) {
            \Session::flash( 'danger', 'Entity not found!' );

            return redirect()->back();
        }

        $user = $ticket->user;
        if ( ! $user ) {
            \Session::flash( 'danger', 'Ticket found, but user was deleted!' );

            return redirect()->back();
        }
        $ticket->restore();
        $ticket->discussions()->withTrashed()->restore();
        event( new TicketAddedEvent( $ticket ) );

        flash( 'Ticket restored.' )->success();

        return redirect()->route( $this->CRUDmodelName . '.edit', $ticket->id );
    }

    public function showPdf( $id )
    {

        $ticket = Ticket::where( 'id', $id )->first();

        if ( $ticket ) {
            return Storage::download( env( 'STORAGE_PDF' ) . '/' . $ticket->pdf );
        } else {
            \Session::flash( 'danger', 'Ticket not found' );

            return redirect()->back();
        }
    }

}
