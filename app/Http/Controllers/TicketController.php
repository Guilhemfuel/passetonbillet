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

        $tickets = collect(Eurostar::retrieveTicket($request->last_name,$request->booking_code));
        session(['tickets'=>$tickets]);
        return TicketRessource::collection($tickets);

    }
}
