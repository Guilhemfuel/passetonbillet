<?php

namespace App\Http\Controllers;

use App\EurostarAPI\Eurostar as EurostarSrc;
use App\Facades\Eurostar;
use App\Http\Resources\UserRessource;
use App\Station;
use Illuminate\Http\Request;


class PageController extends Controller
{

    public function home()
    {
        if ( \Auth::check() ) {
            return view( 'home' );
        } else {
            return view( 'welcome' );
        }
    }

    /**
     *
     * Display page to sell a ticket
     *
     */
    public function sellPage() {
        return view('tickets.sell')->with('user',new UserRessource(\Auth::user()));
    }

    public function test()
    {
        $departure_station = Station::find( 1 );
        $arrival_station = Station::find( 6 );
        $my_date =  new \DateTime();
        \Debugbar::info( Eurostar::singles( $departure_station, $arrival_station, $my_date ) );
        return view('home');
    }

}
