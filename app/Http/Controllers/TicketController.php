<?php

namespace App\Http\Controllers;

use App\Events\TicketAddedEvent;
use App\Exceptions\EurostarException;
use App\Exceptions\PasseTonBilletException;
use App\Facades\Amplitude;
use App\Facades\AppHelper;
use App\Facades\Izy;
use App\Facades\Ouigo;
use App\Facades\Sncf;
use App\Facades\Thalys;
use App\Http\Requests\BuyTicketsRequest;
use App\Http\Requests\ManualTicketSellRequest;
use App\Http\Requests\OfferRequest;
use App\Http\Requests\SearchTicketsRequest;
use App\Http\Requests\SellTicketRequest;
use App\Http\Resources\DiscussionLastMessageResource;
use App\Http\Resources\StationRessource;
use App\Http\Resources\TicketRessource;
use App\Http\Resources\TrainRessource;
use App\Jobs\DownloadTicketPdf;
use App\Listeners\Admin\Checks\CheckPriceTicketAddedListener;
use App\Mail\OfferEmail;
use App\Models\AdminWarning;
use App\Models\Discussion;
use App\Models\Statistic;
use App\Notifications\OfferNotification;
use App\Ticket;
use App\Train;
use App\Trains\TrainConnector;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Facades\Eurostar;
use Mockery\Exception;

class TicketController extends Controller
{

    const LIMIT_OFFERS_PER_DAY = 8;

    /**
     * List of UK eurostar stations
     */
    const UK_EUROSTAR_STATIONS_DB = [
        // London
        5892,
        7840,
        8172,
        8260,
        8263,
        8265,
        8266,
        8267,
        8268,
        8269,
        8270,
        8273,
        8274,
        22654,
        25012,
        25717,
        25718,
        25722,
        25814,

        // Ebbsfleet
        8224,

        // Ashford
        8155,
        8154,
    ];

    /**
     * List of eurostar station id in DB
     */
    const EUROSTAR_STATIONS_IDS = [

        // Disney
        4819,
        4757,

        // Lille Europe
        4652,
        123,
        1326,
        4616,
        4653,

        // Paris
        4916,
        4917,
        4919,
        4920,
        4921,
        4922,
        4923,
        4924,
        23599,
        34616,
        34617,
        34618,
        34619,

        // Calais
        1417,
        148,
        1419,

        // Avignon
        489,
        171,
        485,

        // Lyon
        4718,
        3652,
        4022,
        4676,
        4677,
        4699,
        4717,

        // Moutiers
        23615,
        5038,

        // Bourg St Maurice
        5028,

        // Marseille
        4790,
        4116,
        4117,
        4723,
        4791,
        4947,
        4948,
        4949,
        23020,

        // Bruxelles
        5974,
        5893,
        5971,
        17738,

        // Amsterdam
        8657,
        5894,
        8609,
        8643,
    ];

    /**
     * @param SellTicketRequest $request
     *
     * Save ticket and make it available to buy
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sellTicket( SellTicketRequest $request )
    {
        $tickets = $request->session()->get( 'tickets' );
        $request->session()->forget( 'tickets' );
        // Make sure we find ticket in session
        if ( ! $tickets || ! ( isset( $tickets[ $request->index ] ) ) ) {
            flash( __( 'common.error' ) )->error()->important();

            return redirect()->route( 'public.ticket.sell.page' );
        }

        $ticket = $tickets[ $request->index ];

        // Make sure we don't have such a ticket yet
        $oldTicket = Ticket::withScams()
                           ->withTrashed()
                           ->whereRaw( "lower(provider_code) = ? ", strtolower( $ticket->provider_code ) )
                           ->where( 'provider', $ticket->provider )
                           ->where( 'train_id', $ticket->train_id )
                           ->where( 'buyer_name', $ticket->buyer_name )
                           ->where( 'ticket_number', $ticket->ticket_number )
                           ->first();

        if ( $oldTicket ) {
            // Scammers tend to try to put on sale tickets already on the website, so we create a warning if that happens
            AdminWarning::create( [
                'action' => AdminWarning::TRY_TO_RESALE_TICKET,
                'link'   => route( 'users.edit', \Auth::id() ),
                'data'   => [
                    'user_id'              => \Auth::id(),
                    'old_ticket_seller_id' => $oldTicket->user->id,
                    'old_ticket_id'        => $oldTicket->id,
                    'message'              => 'This user tried to sell a ticket that was either already sold, or deleted from the 
                    platform. Please check if there is anything suspicious about him or her.',
                ]
            ] );

            flash( __( 'tickets.sell.errors.duplicate' ) )->error()->important();

            return redirect()->route( 'public.ticket.sell.page' );
        }

        $ticket->user_id = \Auth::id();
        $ticket->price = $request->price;
        $ticket->currency = $ticket->bought_currency;
        $ticket->user_notes = $request->notes;
        $ticket->save();

        Amplitude::logEvent( 'add_ticket', [
            'ticket_id'       => $ticket->id,
            'ticket_provider' => $ticket->provider
        ] );

        // Dispatch ticket added event
        event( new TicketAddedEvent( $ticket ) );

        flash( __( 'tickets.sell.success' ) )->success()->important();

        return redirect()->route( 'public.ticket.owned.page' )
                         ->with( [ 'addedTicket' => new TicketRessource( $ticket ) ] );
    }

    /**
     * Remove a ticket currently looking for a buyer
     */
    public function deleteOrSell( Request $request )
    {
        $this->validate( $request, [
            'ticket_id'                => 'required|exists:tickets,id',
            'delete_ticket'            => 'boolean',
            'discussion_where_sold_id' => 'exists:discussions,id'
        ] );

        // Ticket can't be deleted and marked as sold as same time
        if ( $request->has( 'delete_ticket' ) && $request->has( 'discussion_where_sold_id' ) ) {
            flash( __( 'common.error' ) )->error()->important();

            return redirect()->route( 'public.ticket.owned.page' );
        }

        // Check ticket exists, is not passed, is not sold and belongs to user
        $ticket = Ticket::find( $request->ticket_id );
        if ( ! $ticket || $ticket->user_id != \Auth::id() || $ticket->passed || $ticket->sold_to_id != null ) {
            flash( __( 'common.error' ) )->error()->important();

            return redirect()->route( 'public.ticket.owned.page' );
        }

        // If ticket was sold to someone else
        if ( $request->has( 'discussion_where_sold_id' ) ) {
            // No need to mark discussion as denied, call to markAsSold will do it
            $result = DiscussionController::markTicketAsSold( $request, $ticket->id, $request->discussion_where_sold_id );
            if ( $result === true ) {
                flash( __( 'message.success.sold' ) )->success()->important();

                return redirect()->route( 'public.message.discussion.page', [
                    $ticket->id,
                    $request->discussion_where_sold_id
                ] );
            } else {
                flash( $result['message'] )->error()->important();

                return redirect( $result['url'] );
            }
        } // Delete ticket (no need to deny offer)
        elseif ( $request->has( 'delete_ticket' ) ) {

            Amplitude::logEvent( 'delete_ticket', [
                'ticket_id' => $ticket->id,
            ] );

            $ticket->delete();
            flash( __( 'tickets.delete.success' ) )->success()->important();

            return redirect()->route( 'public.ticket.owned.page' );
        } // Should not go through there: either sold or deleted
        else {
            flash( __( 'common.error' ) )->error()->important();

            return redirect()->route( 'public.ticket.owned.page' );
        }

    }

    /**
     * Change ticket price
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeTicketPrice( Request $request, $ticket_id )
    {
        $this->validate( $request, [
            'price' => 'required'
        ] );

        // Check ticket exists, is not passed, is not sold and belongs to user
        $ticket = Ticket::find( $ticket_id );
        if ( ! $ticket || $ticket->user_id != \Auth::id() || $ticket->passed || $ticket->sold_to_id != null ) {
            flash( __( 'common.error' ) )->error()->important();

            return redirect()->route( 'public.ticket.owned.page' );
        }


        // Check price
        if ( 0 > $request->price ) {
            flash( __( 'tickets.sell.errors.min_value' ) )->error()->important();

            return redirect()->route( 'public.ticket.sell.page' );
        }


        // If the user lowers the ticket price a lot
        if ( $request->price <= CheckPriceTicketAddedListener::TICKET_WARNING_PRICE && $request->price <= $ticket->bought_price ) {
            $ticket->price = $ticket->bought_price;
        } else {
            $ticket->price = $request->price;
        }

        Amplitude::logEvent( 'change_ticket_price', [
            'ticket_id' => $ticket->id,
            'old_price' => $ticket->price,
            'new_price' => $request->price
        ] );

        $ticket->price = $request->price;
        $ticket->save();
        flash( __( 'tickets.updated' ) )->success()->important();

        return redirect()->route( 'public.ticket.owned.page' );

    }

    /**
     * Redirects to the link to download the pdf of a ticket
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function downloadTicket( $ticket_id )
    {
        $ticket = Ticket::find( $ticket_id );
        // Make sure allowed user
        if ( ! $ticket || $ticket->passed || ( $ticket->buyer->id != \Auth::user()->id && ! \Auth::user()->isAdmin() ) ) {
            flash( __( 'common.error' ) )->error()->important();

            return redirect()->route( 'public.ticket.owned.page' );
        }

        // Check if file exists
        $filePath = 'pdf/tickets/' . $ticket->pdf_file_name;
        if ( ! \Storage::disk( 's3' )->exists( $filePath ) ) {
            flash( __( 'common.error' ) )->error()->important();

            return redirect()->route( 'public.ticket.owned.page' );
        }

        // Store stat
        AppHelper::stat( 'download_pdf', [
            'ticket_id' => $ticket_id
        ] );

        $url = \Storage::disk( 's3' )->temporaryUrl(
            $filePath, now()->addMinutes( 5 )
        );

        return redirect( $url );
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
     * @throws PasseTonBilletException
     */
    public function searchTickets( SearchTicketsRequest $request )
    {
        // List of connectors and their Facades
        $connectors = [
            \App\Trains\Ouigo::class    => Ouigo::class,
            \App\Trains\Izy::class      => Izy::class,
            \App\Trains\Eurostar::class => Eurostar::class,
            \App\Trains\Sncf::class     => Sncf::class,
            \App\Trains\Thalys::class   => Thalys::class,
        ];

        $tickets = null;
        $errors = []; // For debug purposes only

        // Try each connector until you find a correct result
        foreach ( $connectors as $connector => $facade ) {

            // Only search for classic providers (with name) if email not specified
            if ( ( $request->email == '' || is_null( $request->email ) )
                 && ! in_array( $connector::PROVIDER, TrainConnector::CLASSIC_PROVIDERS ) ) {
                continue;
            }

            // Query tickets for provider
            try {
                $tickets = $facade::retrieveTicket( $request->email, $request->last_name, $request->booking_code );
                break;
            } catch ( PasseTonBilletException $e ) {
                $errors[] = [
                    'message' => $e->getMessage(),
                    'trace' => $e->getFile().' line: '. $e->getLine()
                ];
                continue;
            }
        }

        // Return Debug infos
        if (\App::environment() == 'local' && count($errors) > 0 && $tickets == null) {
            return response([
                'message' => 'Multiple errors found.',
                'errors' => $errors
            ],400);
        }

        $tickets = collect( $tickets );

        Amplitude::logEvent( 'retrieve_tickets', [
            'name'            => \Auth::user()->last_name,
            'booking_code'    => $request->booking_code,
            'result(s)_count' => count( $tickets ),
            'email'           => $request->email
        ] );

        // All tickets expired
        if ( count( $tickets ) == 0 ) {
            throw new PasseTonBilletException( 'No tickets were found.' );
        }
        session( [ 'tickets' => $tickets ] );

        return TicketRessource::collection( $tickets );
    }

    /**
     * Given a departure and arrival station and a date returns a list of tickets
     *
     * @param BuyTicketsRequest $request
     *
     * @return mixed
     */
    public function buyTickets( BuyTicketsRequest $request )
    {
        AppHelper::stat( 'search_tickets', [
            'departure_station' => $request->departure_station,
            'arrival_station'   => $request->arrival_station,
            'trip_date'         => $request->trip_date,
            'trip_time'         => $request->trip_time,
            'ip_address'        => $request->ip()
        ] );

        $tickets = Ticket::applyFilters(
            $request->get( 'departure_station' ),
            $request->get( 'arrival_station' ),
            Carbon::createFromFormat( 'd/m/Y', $request->get( 'trip_date' ) ),
            $request->get( 'trip_time', Carbon::now()->format( 'h:m' ) ),
            true
        );

        return TicketRessource::collection( $tickets );
    }

    /**
     * Make an offer for a ticket
     */

    public function makeAnOffer( OfferRequest $request )
    {

        $ticket = Ticket::find( $request->ticket_id );
        $price = $request->price;

        if ( ! $ticket ) {
            throw new PasseTonBilletException( __( 'offer.errors.ticket_not_found' ) );
        }

        // Price verification
        if ( $price <= 0 ) {
            throw new PasseTonBilletException( __( 'offer.errors.price_null' ) );
        }
        if ( $price > $ticket->price ) {
            throw new PasseTonBilletException( __( 'offer.errors.over_price' ) );
        }

        // User verification (not owner)
        if ( \Auth::user()->id == $ticket->user->id ) {
            throw new PasseTonBilletException( __( 'offer.errors.ticket_owned' ) );
        }

        // User verification (no existing offer)
        $oldDiscussionCount = Discussion::where( 'ticket_id', $ticket->id )
                                        ->where( 'buyer_id', \Auth::user()->id )
                                        ->whereIn( 'status', [
                                            Discussion::SOLD,
                                            Discussion::ACCEPTED,
                                            Discussion::AWAITING
                                        ] )->count();
        if ( $oldDiscussionCount > 0 ) {
            throw new PasseTonBilletException( __( 'offer.errors.offer_already_done' ) );
        }

        // Now check number of offer done in the last 24 hours
        $offersToday = Discussion::where( 'buyer_id', \Auth::user()->id )
                                 ->where( 'created_at', '>', now()->subDay( 1 ) )->count();

        if ( $offersToday >= self::LIMIT_OFFERS_PER_DAY ) {
            throw new PasseTonBilletException( __( 'offer.errors.daily_limit' ) );
        }

        // Now if there was an offer denied before, we soft delete it
        $oldDiscussion = Discussion::where( 'ticket_id', $ticket->id )
                                   ->where( 'buyer_id', \Auth::user()->id )
                                   ->where( 'status', Discussion::DENIED )->first();
        if ( $oldDiscussion ) {
            $oldDiscussion->delete();
        }

        // Finally we create the new offer
        $discussion = new Discussion( [
            'buyer_id'  => \Auth::user()->id,
            'ticket_id' => $ticket->id,
            'price'     => $price,
            'currency'  => $ticket->currency
        ] );
        $discussion->save();

        $discussion->seller->notify( new OfferNotification( $discussion ) );

        return new DiscussionLastMessageResource( $discussion );

    }

}
