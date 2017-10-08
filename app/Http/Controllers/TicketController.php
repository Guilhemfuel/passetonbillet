<?php

namespace App\Http\Controllers;

use App\Exceptions\EurostarException;
use App\Http\Requests\SearchTicketsRequest;
use App\Http\Resources\StationRessource;
use App\Http\Resources\TicketRessource;
use App\Http\Resources\TrainRessource;
use App\Train;
use Illuminate\Http\Request;
use App\Facades\Eurostar;

class TicketController extends Controller
{

    public function test(){

        $name = "nahum";
        $code = "REMHAF";

        $tickets = Eurostar::retrieveTicket($name,$code,true);
        \Debugbar::info($tickets);

        return view('home');
    }

    /**
     *
     * Display page to sell a ticket
     *
     */
    public function sellPage() {
        return view('tickets.sell');
    }


    /////////////////////////
    /// API
    /////////////////////////

    /**
     * Sends the tickets corresponding to a name\bookingcode
     *
     * @param SearchTicketsRequest $request
     *
     * @return mixed
     */
    public function searchTickets(SearchTicketsRequest $request) {

        // Todo: disable past tickets
        $tickets = collect(Eurostar::retrieveTicket($request->last_name,$request->booking_code));
        return TicketRessource::collection($tickets);

    }
}
