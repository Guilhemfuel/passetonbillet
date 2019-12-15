<?php

namespace App\Http\Controllers;

use App\EurostarAPI\Eurostar as EurostarSrc;
use App\Exceptions\PasseTonBilletException;
use App\Facades\Amplitude;
use App\Facades\AppHelper;
use App\Facades\Eurostar;
use App\Http\Resources\AlertResource;
use App\Http\Resources\Content\HelpQuestionResource;
use App\Http\Resources\DiscussionCollectionResource;
use App\Http\Resources\DiscussionLastMessageResource;
use App\Http\Resources\DiscussionResource;
use App\Http\Resources\StationRessource;
use App\Http\Resources\TicketRessource;
use App\Http\Resources\UserRessource;
use App\Models\Content\HelpQuestion;
use App\Models\Discussion;
use App\Models\Review;
use App\Notifications\OfferNotification;
use App\Notifications\Verification\IdConfirmed;
use App\Station;
use App\Ticket;
use App\Train;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Mockery\Exception;


class PageController extends Controller
{

    public function home(Request $request)
    {

        $successPurchase = false;
        if($transactionId = $request->session()->pull('successPurchase')) {
            $transaction = Transaction::where('transaction_mangopay', $transactionId)->first();

            $successPurchase = (object) ['ticket' => $transaction->ticket_id, 'email' => $transaction->purchaser->email];
        }

        // Order of stations
        $defaultStationsIds = [ 4916, 8267, 5974, 4718, 4790 ];
        $defaultStations = Station::findMany( $defaultStationsIds );

        // Check if cookies for default stations are set
        $departureStationID = request()->cookie( TicketController::COOKIE_TRIP_DEPARTURE, null );
        $arrivalStationID = request()->cookie( TicketController::COOKIE_TRIP_ARRIVAL, null );

        $departureStation = Station::find( $departureStationID );
        $arrivalStation = Station::find( $arrivalStationID );

        if ( $departureStation && $arrivalStation ) {
            $defaultStations = $defaultStations->add( $departureStation )->add( $arrivalStation );
        }

        $questions = HelpQuestionResource::collection( HelpQuestion::getCached( 4 ) );

        return view( 'welcome' )->with( [
            'defaultStations'  => StationRessource::collection( $defaultStations->unique( 'id' ) ),
            'departureStation' => $departureStation ? new StationRessource( $departureStation ) : null,
            'arrivalStation'   => $arrivalStation ? new StationRessource( $arrivalStation ) : null,
            'questions'        => $questions,
            'successPurchase'  => $successPurchase
        ] );
    }

    public function homeRedirect()
    {
        return redirect()->route( 'home' );
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
    public function sellPage() {
        if ( \Auth::check() ) {
            return view( 'tickets.sell.auth' );
        } else {

            $tickets = Ticket::getMostRecentTickets( 8 );
            $recentTickets = TicketRessource::collection( $tickets );
            $reviews = Review::getSelectedReviews( 3 );

            return view( 'tickets.sell.public' )->with( [
                'recentTickets' => $recentTickets,
                'reviews'       => $reviews,
            ] );
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
            'departure_date'    => 'nullable|date_format:d/m/Y',
            'alert'             => 'nullable|in:true,false,1,0'
        ] );

        if ( ! $request->has( 'departure_station' )
             || ! $request->has( 'arrival_station' ) ) {
            return redirect()->route( 'home' );
        }

        $alert = $request->get('alert');
        if ($alert != null && $alert != ""){
            $alert = ($alert == "1" || $alert == "true") ? true : false;
        }

        $view = view( 'tickets.buy' );

        if ( \Auth::check() ) {
            $view = $view->with( 'userData', new UserRessource( \Auth::user(), true ) );
        }

        return $view->with( 'search', [
            "departure_station" => $request->departure_station,
            "arrival_station"   => $request->arrival_station,
            "trip_date"         => $request->get( "departure_date", null ),
            "trip_time"         => null,
        ] )->with('alert',$alert);
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

        return view( 'tickets.owned' )->with( 'state', $state );
    }

    public function myTicketsBought() {
        return view( 'tickets.bought' );
    }

    public function myTicketsSold() {
        return view( 'tickets.sold' );
    }

    public function myTicketsPayments() {
        return view( 'tickets.payments' );
    }

    /**
     *
     * Display page to manage alerts
     *
     */
    public function alertsPage()
    {
        $alerts = \Auth::user()->alerts;

        return view( 'tickets.alerts' )->with( [
            'alerts' => AlertResource::collection( $alerts ),
        ] );

    }

    /**
     * Display the message page
     */
    public function messagePage()
    {
        return view( 'messages.home' );
    }

    /**
     * Display the unique ticket page
     *
     * Shows a different page if a user is connected or not
     */
    public function ticketUnique( Request $request, $ticket_id )
    {
        $hash = \Vinkla\Hashids\Facades\Hashids::decode( $ticket_id );

        if (!is_array($hash) || count($hash)<1) {
            flash( __( "tickets.errors.passed" ) )->error();
            return redirect(  )->route('home');
        }

        $ticket = Ticket::find($hash[0]);

        if ( ! $ticket ) {
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
            AppHelper::pageStat( 'register', 'ticket-preview' );

            return view( 'auth.auth_ticket', [
                'type'             => 'register',
                'ticket'           => $ticket,
                'pageImagePreview' => route( 'image.ticket.preview', $ticket_id ),
                'pageTitle'        => $ticket->description,
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

        return \App\Facades\ImageHelper::ticketPreview( $ticket )->response( 'png' );
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
        $questions = HelpQuestion::getCached();

        return view( 'help.help', [
            'questions' => HelpQuestionResource::collection( $questions )
        ] );
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
