<?php

namespace App\Http\Controllers;

use App\Exceptions\EurostarException;
use App\Exceptions\LastarException;
use App\Http\Requests\BuyTicketsRequest;
use App\Http\Requests\OfferRequest;
use App\Http\Requests\SearchTicketsRequest;
use App\Http\Requests\SellTicketRequest;
use App\Http\Resources\DiscussionResource;
use App\Http\Resources\StationRessource;
use App\Http\Resources\TicketRessource;
use App\Http\Resources\TrainRessource;
use App\Mail\OfferEmail;
use App\Models\Discussion;
use App\Notifications\OfferNotification;
use App\Ticket;
use App\Train;
use Illuminate\Http\Request;
use App\Facades\Eurostar;

class TicketController extends Controller
{

    /**
     * @param SellTicketRequest $request
     * 
     * Save ticket and make it available to buy
     */
    public function sellTicket(SellTicketRequest $request) {
        $tickets = $request->session()->get('tickets');
        $request->session()->forget('tickets');
        // Make sure we find ticket in session
        if (!$tickets || !(isset($tickets[$request->index])) ) {
            flash(__('common.error'))->error()->important();
            return redirect()->route('public.ticket.sell.page');
        }

        $ticket = $tickets[$request->index];

        // Make sure price doesn't over exceed original price
        if ($ticket->bought_price < $request->price){
            flash(__('tickets.sell.errors.max_value'))->error()->important();
            return redirect()->route('public.ticket.sell.page');
        }

        // Make sure we don't have such a ticket yet
        $oldTicket = Ticket::where('eurostar_code',$ticket->eurostar_code)
                            ->where('buyer_name', $ticket->buyer_name)
                            ->first();
        if ($oldTicket && $oldTicket->train_id == $ticket->train_id){
            flash(__('tickets.sell.errors.duplicate'))->error()->important();
            return redirect()->route('public.ticket.sell.page');
        }

        $ticket->user_id = \Auth::id();
        $ticket->price = $request->price;
        $ticket->currency = $ticket->bought_currency;
        $ticket->user_notes = $request->notes;
        $ticket->save();

        flash(__('tickets.sell.success'))->success()->important();
        return redirect()->route('home');
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

    /**
     * Given a departure and arrival station and a date returns a list of tickets
     *
     * @param BuyTicketsRequest $request
     *
     * @return mixed
     */
    public function buyTickets( BuyTicketsRequest $request )
    {
        $tickets = Ticket::applyFilters(
            $request->get('departure_station'),
            $request->get('arrival_station'),
            $request->get('trip_date'),
            $request->get('trip_time',null)
        );

        return TicketRessource::collection($tickets);
    }

    /**
     * Make an offer for a ticket
     */

    public function makeAnOffer(OfferRequest $request) {

        $ticket = Ticket::find($request->ticket_id);
        $price = $request->price;

        if (!$ticket) {
            throw new LastarException(__('offer.errors.ticket_not_found'));
        }

        // Price verification
        if($price <=0){
            throw new LastarException(__('offer.errors.price_null'));
        }

        if($price > $ticket->price){
            throw new LastarException(__('offer.errors.over_price'));
        }

        // User verification (not owner)
        if(\Auth::user()->id == $ticket->user->id){
            throw new LastarException(__('offer.errors.ticket_owned'));
        }

        // User verification (no existing offer)
        $discussion = Discussion::where('ticket_id',$ticket->id)
                                ->where('buyer_id',\Auth::user()->id)->first();
        if($discussion){
            throw new LastarException(__('offer.errors.offer_already_done'));
        }

        $discussion = new Discussion([
            'buyer_id' => \Auth::user()->id,
            'ticket_id'=> $ticket->id,
            'price'    => $price
        ]);
        $discussion->save();

        $discussion->seller->notify( new OfferNotification($discussion->ticket) );

        return new DiscussionResource($discussion);

    }
}
