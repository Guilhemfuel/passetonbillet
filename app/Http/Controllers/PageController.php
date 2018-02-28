<?php

namespace App\Http\Controllers;

use App\EurostarAPI\Eurostar as EurostarSrc;
use App\Facades\Eurostar;
use App\Http\Resources\DiscussionCollectionResource;
use App\Http\Resources\DiscussionLastMessageResource;
use App\Http\Resources\StationRessource;
use App\Http\Resources\TicketRessource;
use App\Http\Resources\UserRessource;
use App\Models\Discussion;
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
        // Offers done by user
        $buyingDiscussions = \Auth::user()->offers()->where('status','>=',Discussion::ACCEPTED)->get();

        // For each ticket the user have, we find corresponding discussions
        $tickets = \Auth::user()->tickets;
        $sellingDiscussions = collect();
        $offersAwaiting = collect();
        foreach ($tickets as $ticket) {
            $discussions = $ticket->discussions;
            $sellingDiscussions = $sellingDiscussions->merge($discussions->where('status','>=',Discussion::ACCEPTED));
            $offersAwaiting = $offersAwaiting->merge($discussions->where('status',Discussion::AWAITING));
        }

        return view( 'messages.home' )->with( 'user', new UserRessource( \Auth::user() ) )
            ->with('offersAwaiting', DiscussionLastMessageResource::collection( $offersAwaiting ) )
            ->with('buyingDiscussions',  DiscussionLastMessageResource::collection( $buyingDiscussions ) )
            ->with('sellingDiscussions',  DiscussionLastMessageResource::collection( $sellingDiscussions ) );
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
