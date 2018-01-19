<?php

namespace App\Http\Controllers;

use App\EurostarAPI\Eurostar as EurostarSrc;
use App\Facades\Eurostar;
use App\Http\Resources\StationRessource;
use App\Http\Resources\TicketRessource;
use App\Http\Resources\UserRessource;
use App\Notifications\Verification\IdConfirmed;
use App\Station;
use App\Ticket;
use Illuminate\Http\Request;


class PageController extends Controller
{

    public function home()
    {
        if ( \Auth::check() ) {
            return view( 'home' );
        } else {
            //TODO: change tickets to only show the latest or the previously searched etc..
            $tickets = Ticket::latest()->take( 3 )->get();

            return view( 'welcome' )->with( 'tickets', TicketRessource::collection( $tickets ) )
                                    ->with( 'stations', StationRessource::collection( Station::all() ) );
        }
    }

    /**
     *
     * Display page to sell a ticket
     *
     */
    public function sellPage()
    {
        return view( 'tickets.sell' )->with( 'user', new UserRessource( \Auth::user() ) );
    }

    /**
     *
     * Display page to sell a ticket
     *
     */
    public function buyPage()
    {
        return view( 'tickets.buy' )->with( 'user', new UserRessource( \Auth::user(), true ) )
                                    ->with( 'stations', StationRessource::collection( Station::all() ) );
    }

    /**
     *
     * Display page with all tickets owned by user
     *
     */
    public function myTicketsPage()
    {
        return view( 'tickets.owned' )->with( 'user', new UserRessource( \Auth::user() ) )
                                      ->with( 'tickets', TicketRessource::collection( \Auth::user()->tickets ) );
    }

    /**
     * Display the message page
     */
    public function messagePage()
    {
        return view( 'messages.home' )->with( 'user', new UserRessource( \Auth::user() ) );
    }

    /**
     *
     * Display the profile page
     *
     */
    public function profile()
    {
        return view( 'profile.profile' )->with( 'user', new UserRessource( \Auth::user() ) );
    }

}
