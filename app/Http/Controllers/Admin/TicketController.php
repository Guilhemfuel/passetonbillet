<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TicketRequest;
use App\Http\Resources\Admin\TicketTableResource;
use App\Http\Resources\StationRessource;
use App\Jobs\DownloadTicketPdf;
use App\Station;
use App\Ticket;
use App\User;
use Faker\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class TicketController extends BaseController
{
    protected $CRUDmodelName = 'tickets';
    protected $CRUDsingularEntityName = 'Ticket';

    protected $model = Ticket::class;
    protected $creatable = true;
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

        $entities = $this->model::join( 'trains', 'tickets.train_id', '=', 'trains.id' )
                                ->join( 'stations', 'trains.departure_city', '=', 'stations.id' )
                                ->with(  $this->model::$relationships )
                                ->orderBy( 'sold_to_id', 'desc' )
                                ->orderBy( 'trains.departure_date' )
                                ->orderBy( 'stations.name_en' )
                                ->select('tickets.*', 'trains.departure_city','trains.departure_date','stations.name_en')
                                ->withScams()
                                ->get();

        $stations = Station::all()->pluck('short_name');
        $stations = array_map(function($name){
            return substr($name,2);
        },$stations->toArray());

        $data = [ 'entities' => TicketTableResource::collection($entities),'stations'=>$stations, 'searchable' => $this->searchable, 'creatable' => $this->creatable ];

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
            flash()->error('Entity not found!');
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
        $ticket = factory( Ticket::class )->make();
        $admin = User::where( 'status', 100 )->first();
        if ( ! $admin ) {
            flash( 'No admin found!' )->error();

            return redirect()->back();
        }

        $ticket->user_id = $admin->id;
        $ticket->save();

        flash()->success( $this->CRUDsingularEntityName . ' created! Admin owner is: ' . $admin->full_name );

        return redirect()->route( $this->CRUDmodelName . '.edit', $ticket->id );
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

        return redirect()->route( $this->CRUDmodelName .'.index' );
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
        $ticket->update( $request->all() );
        $ticket->save();

        flash()->success( 'Ticket updated!' );

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

        if ($ticket->passed){
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

        if ($ticket->passed){
            flash()->error( 'Can\'t upload pdf of past ticket!' );

            return redirect()->back();
        }

        $request->validate( [
            'ticket_pdf' => 'required|file|max:5000|mimes:pdf'
        ] );

        \Storage::disk('s3')->putFileAs('pdf/tickets/', $request->ticket_pdf,$ticket->pdf_file_name);

        flash()->success( 'Done! Pdf uplodaded.' );

        return redirect()->route( $this->CRUDmodelName . '.edit', $ticket->id );
    }

    // ---------- Mark as Fraud -------

    public function markAsFraud(Request $request, $id)
    {
        $ticket = Ticket::find( $id );
        if ( ! $ticket ) {
            \Session::flash( 'danger', 'Entity not found!' );
            return redirect()->back();
        }

        $ticket->scam();

        flash('Ticket marked as scam.')->success();
        return redirect()->route( $this->CRUDmodelName . '.edit', $ticket->id );
    }

}
