<?php

namespace App\Http\Controllers;

use App\Exceptions\EurostarException;
use Illuminate\Http\Request;
use App\Facades\Eurostar;

class TicketController extends Controller
{

    public function test(){

        $name = "nahum";
        $code = "QBVPJP";

        $tickets = Eurostar::retrieveTicket($name,$code);
        \Debugbar::info($tickets);

        //TODO: Make sure all tickets aren't passed

        return view('home');
    }

}
