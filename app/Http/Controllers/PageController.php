<?php

namespace App\Http\Controllers;

use App\EurostarAPI\Eurostar as EurostarSrc;
use App\Exceptions\PasseTonBilletException;
use App\Facades\Eurostar;
use App\Http\Resources\DiscussionCollectionResource;
use App\Http\Resources\DiscussionLastMessageResource;
use App\Http\Resources\StationRessource;
use App\Http\Resources\TicketFullRessource;
use App\Http\Resources\TicketRessource;
use App\Http\Resources\UserRessource;
use App\Models\Discussion;
use App\Notifications\OfferNotification;
use App\Notifications\Verification\IdConfirmed;
use App\Station;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Mockery\Exception;


class PageController extends Controller
{

    public function home()
    {
        if ( \Auth::check() ) {
            return redirect()->route( 'public.ticket.buy.page' );
        } else {
            //TODO: change tickets to only show the latest or the previously searched etc..
            $tickets = Ticket::join( 'trains', 'trains.id', '=', 'tickets.train_id' )
                             ->orderBy( 'trains.departure_date' )
                            ->where('trains.departure_date','>',Carbon::now())
                             ->take( 3 )
                             ->get();

            return view( 'welcome' )->with( 'tickets', $tickets?TicketRessource::collection( $tickets ):[] );
        }
    }

    /**
     * ============================ Tickets Pages ============================
     * Sell
     * Buy
     * My tickets
     * Messages
     * Ticket Unique
     *
     */

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
    public function myTicketsPage($tab=null)
    {

        // Possibility to specify which tab is opened first
        $state = 3;
        switch ($tab){
            case 'selling':
                $state = 3;
                break;
            case 'sold':
                $state = 1;
                break;
            case 'offered':
            case 'offers':
                $state = 4;
                break;
            case 'bought':
                $state = 2;
                break;
        }

        return view( 'tickets.owned' )->with( 'user', new UserRessource( \Auth::user() ) )
                                      ->with( 'tickets', TicketRessource::collection( \Auth::user()->tickets ) )
                                      ->with( 'boughtTickets', TicketFullRessource::collection( \Auth::user()->boughtTickets ) )
                                      ->with( 'offerSent', DiscussionLastMessageResource::collection( \Auth::user()->offers
                                          ->whereIn( 'status', [
                                              Discussion::AWAITING,
                                              Discussion::DENIED,
                                              Discussion::ACCEPTED
                                          ] )
                                      ) )->with('state',$state);

    }

    /**
     * Display the message page
     */
    public function messagePage()
    {
        // Offers done by user
        $buyingDiscussions = \Auth::user()->offers()->where( 'status', '>=', Discussion::ACCEPTED )->get();

        // For each ticket the user have, we find corresponding discussions
        $tickets = \Auth::user()->tickets;
        $sellingDiscussions = collect();
        $offersAwaiting = collect();
        foreach ( $tickets as $ticket ) {
            $discussions = $ticket->discussions;
            $sellingDiscussions = $sellingDiscussions->merge( $discussions->where( 'status', '>=', Discussion::ACCEPTED ) );
            $offersAwaiting = $offersAwaiting->merge( $discussions->where( 'status', Discussion::AWAITING ) );
        }

        // Mark notification of offers as read in database (as we're on page)
        \Auth::user()->unreadNotifications->where('type',OfferNotification::class)->markAsRead();

        return view( 'messages.home' )->with( 'user', new UserRessource( \Auth::user() ) )
                                      ->with( 'offersAwaiting', DiscussionLastMessageResource::collection( $offersAwaiting->sortByDesc('updated_at') ) )
                                      ->with( 'buyingDiscussions', DiscussionLastMessageResource::collection( $buyingDiscussions->sortByDesc('updated_at') ) )
                                      ->with( 'sellingDiscussions', DiscussionLastMessageResource::collection( $sellingDiscussions->sortByDesc('updated_at')) );
    }

    /**
     * Display the unique ticket page
     *
     * Shows a different page if a user is connected or not
     */
    public function ticketUnique( Request $request, $ticket_id )
    {
        $ticket = Ticket::findOrFail(
            \Vinkla\Hashids\Facades\Hashids::decode( $ticket_id )[0]
        );

        // We don't display past tickets
        if ( $ticket->passed ) {
            flash( __( "tickets.errors.passed" ) )->error();

            return redirect( 'home' );
        }

        if ( \Auth::check() ) {
            // If the user is connected, we redirect him to the seller's page
            return redirect()->route( 'public.profile.stanger', [
                'user_id' => \Vinkla\Hashids\Facades\Hashids::encode( $ticket->user_id )
            ] );
        } else {
            return view( 'auth.auth_ticket', [
                'type' => 'register',
                'ticket' => new TicketRessource( $ticket )
            ] );
        }
    }


    /**
     * ============================ Profile Pages ============================
     * Profile
     * Profile Stranger
     *
     */

    /**
     * Display the profile page
     */
    public function profile()
    {
        return view( 'profile.profile' )->with( [
            'userData' => new UserRessource( \Auth::user() ),
            'user'     => \Auth::user()
        ] );
    }

    /**
     * Display the profile page of another user
     */
    public function profileStranger( Request $request, $user_id )
    {
        $user = User::findOrFail(
            \Vinkla\Hashids\Facades\Hashids::decode( $user_id )[0]
        );

        if ( \Auth::user()->id == $user->id ) {
            return redirect()->route( 'public.profile.home' );
        }

        return view( 'profile.profile' )->with( [
            'userData' => new UserRessource( \Auth::user(), true ),
            'user'     => $user,
            'tickets'  => TicketRessource::collection( $user->tickets->where( 'passed', false ) )
        ] );
    }

    /**
     * ============================= Infos static pages =============================
     * Contact
     * Partners
     * About
     * CGU
     * Privacy
     *
     */

    /**
     * Display the contact page
     */
    public function contact()
    {
        return view( 'help.contact' );
    }

    /**
     * Display the about page
     */
    public function about()
    {
        return view( 'help.about' );
    }

    /**
     * Display the Terms page
     */
    public function cgu()
    {

        if ( \App::getLocale() == 'fr' ) {
            return view( 'help.cgu-privacy.fr.cgu' );
        }

        return view( 'help.cgu-privacy.en.cgu' );

    }

    /**
     * Display the privacy policy
     */
    public function privacy()
    {
        if ( \App::getLocale() == 'fr' ) {
            return view( 'help.cgu-privacy.fr.privacy' );
        }

        return view( 'help.cgu-privacy.en.privacy' );
    }

}
