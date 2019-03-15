<?php

namespace App\Http\Controllers;

use App\EurostarAPI\Eurostar as EurostarSrc;
use App\Exceptions\PasseTonBilletException;
use App\Facades\Amplitude;
use App\Facades\AppHelper;
use App\Facades\Eurostar;
use App\Http\Resources\DiscussionCollectionResource;
use App\Http\Resources\DiscussionLastMessageResource;
use App\Http\Resources\StationRessource;
use App\Http\Resources\TicketRessource;
use App\Http\Resources\UserRessource;
use App\Models\Discussion;
use App\Notifications\OfferNotification;
use App\Notifications\Verification\IdConfirmed;
use App\Station;
use App\Ticket;
use App\Train;
use App\User;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Mockery\Exception;


class PageController extends Controller
{

    public function home()
    {

        // Order of stations
        $defaultStations = collect([
            Station::find(4916),
            Station::find(8267),
            Station::find(5974),
            Station::find(4718),
            Station::find(4790),
        ]);

        return view( 'welcome' )->with([
            'defaultStations' => StationRessource::collection( $defaultStations )
        ]);
    }

    public function homeRedirect() {
        return redirect()->route('home');
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

        if (\Auth::check()) {

            return view('tickets.sell.auth');

        }

        else {

            $defaultStations = collect([
                Station::find(4916),
                Station::find(8267),
                Station::find(5974),
                Station::find(4718),
                Station::find(4790),
            ]);

            $tickets = Ticket::getMostRecentTickets( 5 );
            $recentTickets = TicketRessource::collection($tickets);



            return view( 'tickets.sell.public' )->with([
                'recentTickets' => $recentTickets,
                'defaultStations' => StationRessource::collection( $defaultStations )
            ]);
        }
    }

    /**
     *
     * Display page to sell a ticket
     *
     */
    public function buyPage( Request $request )
    {
        $this->validate( $request, [
            'departure_station' => 'nullable|exists:stations,id',
            'arrival_station'   => 'nullable|exists:stations,id',
            'departure_date'    => 'nullable|date_format:d/m/Y'
        ] );

        if ( ! $request->has( 'departure_station' )
             || ! $request->has( 'arrival_station' ) ) {
            return redirect()->route( 'home' );
        }

        $view = view( 'tickets.buy' );

        if ( \Auth::check() ) {
            $view = $view->with( 'userData', new UserRessource( \Auth::user(), true ) );
        }

        return $view->with( 'search', [
            "departure_station" => $request->departure_station,
            "arrival_station"   => $request->arrival_station,
            "trip_date"         => $request->get( "departure_date", null ),
            "trip_time"         => null
        ] );
    }

    /**
     *
     * Display page with all tickets owned by user
     *
     */
    public function myTicketsPage( $tab = null )
    {

        // Possibility to specify which tab is opened first
        $state = 3;
        switch ( $tab ) {
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
                                      ->with( 'boughtTickets', TicketRessource::collection( \Auth::user()->boughtTickets ) )
                                      ->with( 'offerSent', DiscussionLastMessageResource::collection( \Auth::user()->offers
                                          ->whereIn( 'status', [
                                              Discussion::AWAITING,
                                              Discussion::DENIED,
                                              Discussion::ACCEPTED
                                          ] )
                                      ) )->with( 'state', $state );

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
        \Auth::user()->unreadNotifications->where( 'type', OfferNotification::class )->markAsRead();

        return view( 'messages.home' )->with( 'user', new UserRessource( \Auth::user() ) )
                                      ->with( 'offersAwaiting', DiscussionLastMessageResource::collection( $offersAwaiting->sortByDesc( 'updated_at' ) ) )
                                      ->with( 'buyingDiscussions', DiscussionLastMessageResource::collection( $buyingDiscussions->sortByDesc( 'updated_at' ) ) )
                                      ->with( 'sellingDiscussions', DiscussionLastMessageResource::collection( $sellingDiscussions->sortByDesc( 'updated_at' ) ) );
    }

    /**
     * Display the unique ticket page
     *
     * Shows a different page if a user is connected or not
     */
    public function ticketUnique( Request $request, $ticket_id )
    {
        $ticket = Ticket::find(
            \Vinkla\Hashids\Facades\Hashids::decode( $ticket_id )[0]
        );

        if (!$ticket || $ticket->passed) {
            flash( __( "tickets.errors.passed" ) )->error();

            return redirect( 'home' );
        }

        if ( \Auth::check() ) {
            // If the user is connected, we redirect him to the seller's page
            return redirect()->route( 'public.profile.stanger', [
                'user_id' => \Vinkla\Hashids\Facades\Hashids::encode( $ticket->user_id ),
            ] );
        } else {
            session( [ 'register-source' => 'ticket-preview' ] );
            AppHelper::pageStat('register','ticket-preview');

            return view( 'auth.auth_ticket', [
                'type'      => 'register',
                'ticket'    => new TicketRessource( $ticket ),
                'pageImagePreview' => route('image.ticket.preview',$ticket_id),
                'pageTitle' => $ticket->description,
            ] );
        }
    }

    /**
     * Returns an image for a given ticket
     */
    public function ticketPreview( Request $request, $ticket_id )
    {
        $ticket = Ticket::findOrFail(
            \Vinkla\Hashids\Facades\Hashids::decode( $ticket_id )[0]
        );

        return \App\Facades\ImageHelper::ticketPreview( $ticket )->response('png');
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
     * Display the help page
     */
    public function help()
    {
        return view( 'help.help' );
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
