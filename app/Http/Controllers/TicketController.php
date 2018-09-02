<?php

namespace App\Http\Controllers;

use App\Exceptions\EurostarException;
use App\Exceptions\PasseTonBilletException;
use App\Facades\AppHelper;
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
use App\Mail\OfferEmail;
use App\Models\Discussion;
use App\Models\Statistic;
use App\Notifications\OfferNotification;
use App\Ticket;
use App\Train;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Facades\Eurostar;

class TicketController extends Controller
{

    /**
     * @param SellTicketRequest $request
     *
     * Save ticket and make it available to buy
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

        // Make sure price doesn't over exceed original price
        if ( $ticket->bought_price < $request->price ) {
            flash( __( 'tickets.sell.errors.max_value' ) )->error()->important();

            return redirect()->route( 'public.ticket.sell.page' );
        }


        // Make sure we don't have such a ticket yet
        $oldTicket = Ticket::withScams()
                           ->whereRaw( "lower(provider_code) = ? ", strtolower( $ticket->provider_code ) )
                           ->where( 'provider', $ticket->provider )
                           ->where( 'train_id', $ticket->train_id )
                           ->where( 'buyer_name', $ticket->buyer_name )
                           ->where( 'ticket_number', $ticket->ticket_number )
                           ->first();
        if ( $oldTicket ) {
            flash( __( 'tickets.sell.errors.duplicate' ) )->error()->important();

            return redirect()->route( 'public.ticket.sell.page' );
        }

        $ticket->user_id = \Auth::id();
        $ticket->price = $request->price;
        $ticket->currency = $ticket->bought_currency;
        $ticket->user_notes = $request->notes;
        $ticket->save();

        // Log the IP of the seller
        AppHelper::stat( 'add_ticket', [
            'ticket_id' => $ticket->id,
            'ip_adress' => $request->ip(),
        ] );

        flash( __( 'tickets.sell.success' ) )->success()->important();

        return redirect()->route( 'public.ticket.owned.page' );
    }

    /**
     *
     * Allow user to sell a ticket simply by filling form
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sellManualTicket( ManualTicketSellRequest $request )
    {
        // Make sure price doesn't over exceed original price
        if ( $request->bought_price < $request->price ) {
            flash( __( 'tickets.sell.errors.max_value' ) )->error()->important();

            return redirect()->route( 'public.ticket.sell.page' );
        }

        $travelDate = Carbon::createFromFormat('m/d/Y',$request->travel_date);

        // Create train
        $train = Train::firstOrCreate( [
            'number'         => $request->train_number,
            'departure_date' => $travelDate,
            'departure_time' => $request->departure_time,
            'arrival_date'   => $travelDate,
            'arrival_time'   => $request->arrival_time,
            'departure_city' => $request->departure_station,
            'arrival_city'   => $request->arrival_station
        ] );

        // Then create ticket
        $ticket = Ticket::create( [
            'train_id'        => $train->id,
            'user_id'         => \Auth::id(),
            'price'           => $request->price,
            'bought_price'    => $request->bought_price,
            'currency'        => $request->currency,
            'bought_currency' => $request->currency,
            'correspondence'  => false,
            'inbound'         => false,
            'manual'          => true,
            'provider'        => $request->company,
            'provider_code'   => null,
            'flexibility'     => $request->flexibility,
            'class'           => $request->classe,
            'buyer_email'     => \Auth::user()->email,
            'buyer_name'      => \Auth::user()->last_name
        ] );

        // Log the IP of the seller
        AppHelper::stat( 'add_ticket', [
            'ticket_id' => $ticket->id,
            'ip_adress' => $request->ip(),
        ] );

        flash( __( 'tickets.sell.success' ) )->success()->important();

        return redirect()->route( 'public.ticket.owned.page' );
    }

    /**
     * Remove a ticket currently looking for a buyer
     */
    public function delete( Request $request )
    {
        $this->validate( $request, [
            'ticket_id' => 'required|exists:tickets,id'
        ] );

        // Make sure that ticket is valid, and that user is the owner of the ticket
        $ticket = Ticket::find( $request->ticket_id );
        if ( ! $ticket || $ticket->passed || $ticket->sold_to_id != null || \Auth::user()->id != $ticket->user_id ) {
            flash( __( 'common.error' ) )->error()->important();

            return redirect()->route( 'public.ticket.owned.page' );
        }

        // for each tickets

        $ticket->delete();
        flash( __( 'tickets.delete.success' ) )->success()->important();

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
        if ( ! \Auth::user()->isAdmin() || ! $ticket || $ticket->passed ) {
            if ( $ticket->buyer->id != \Auth::user()->id ) {
                flash( __( 'common.error' ) )->error()->important();

                return redirect()->route( 'public.ticket.owned.page' );
            }
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
        // Lock to family name
        if ( ! \Auth::user()->isAdmin() && AppHelper::removeAccents( $request->last_name ) != AppHelper::removeAccents( \Auth::user()->last_name ) ) {
            throw new PasseTonBilletException( 'No tickets were found.' );
        }

        if ( \Auth::user()->isAdmin() ) {

            try {
                $ticketArray = Eurostar::retrieveTicket( $request->last_name, $request->booking_code );
            } catch ( PasseTonBilletException $e ) {
                try {
                    $ticketArray = Sncf::retrieveTicket( $request->last_name, $request->booking_code );
                } catch ( PasseTonBilletException $e ) {
                    $ticketArray = Thalys::retrieveTicket( $request->last_name, $request->booking_code );
                }
            }

            $tickets = collect( $ticketArray );

        } else {

            AppHelper::stat( 'retrieve_tickets', [
                'name'         => \Auth::user()->last_name,
                'booking_code' => $request->booking_code,
            ] );

            try {
                $ticketArray = Sncf::retrieveTicket( \Auth::user()->last_name, $request->booking_code );
            } catch ( PasseTonBilletException $e ) {
                try {
                    $ticketArray = Sncf::retrieveTicket( \Auth::user()->last_name, $request->booking_code );
                } catch ( PasseTonBilletException $e ) {
                    $ticketArray = Thalys::retrieveTicket( \Auth::user()->last_name, $request->booking_code );
                }
            }

            $tickets = collect( $ticketArray );
        }

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
            'trip_time'         => $request->trip_time
        ] );

        $tickets = Ticket::applyFilters(
            $request->get( 'departure_station' ),
            $request->get( 'arrival_station' ),
            Carbon::createFromFormat('d/m/Y',$request->get( 'trip_date' )),
            $request->get( 'trip_time', null )
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
            flash()->error( __( 'offer.errors.ticket_not_found' ) );

            return redirect()->back();
        }

        // Price verification
        if ( $price <= 0 ) {
            flash()->error( __( 'offer.errors.price_null' ) );

            return redirect()->back();
        }
        if ( $price > $ticket->price ) {
            flash()->error( __( 'offer.errors.over_price' ) );

            return redirect()->back();
        }

        // User verification (not owner)
        if ( \Auth::user()->id == $ticket->user->id ) {
            flash()->error( __( 'offer.errors.ticket_owned' ) );

            return redirect()->back();
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
