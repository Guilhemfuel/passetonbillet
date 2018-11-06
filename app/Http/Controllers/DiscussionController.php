<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Resources\DiscussionAllMessagesResource;
use App\Http\Resources\DiscussionLastMessageResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\TicketRessource;
use App\Http\Resources\UserRessource;
use App\Mail\AcceptedOfferEmail;
use App\Models\Discussion;
use App\Models\Message;
use App\Notifications\AcceptOfferNotification;
use App\Notifications\MessageNotification;
use App\Notifications\DenyOfferNotification;
use App\Notifications\SoldToYouNotification;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{

    public function denyOffer( Request $request )
    {
        $this->validate( $request, [
            'discussion_id'            => 'required|exists:discussions,id',
            'delete_ticket'            => 'boolean',
            'discussion_where_sold_id' => 'exists:discussions,id'
        ] );

        // Check discussion exists
        $discussion = Discussion::find( $request->discussion_id );
        if ( ! $discussion ) {
            flash( __( 'message.errors.not_found' ) )->error()->important();
            return redirect()->route( 'public.message.home.page' );
        }

        // Check discussion status
        if ( $discussion->status != Discussion::AWAITING ) {
            flash( __( 'message.errors.cant_accept' ) )->error()->important();
            return redirect()->route( 'public.message.home.page' );
        }

        // Check discussion is yours
        if ( $discussion->seller->id != \Auth::user()->id ) {
            flash( __( 'message.errors.wrong_user' ) )->error()->important();
            return redirect()->route( 'public.message.home.page' );
        }

        // Ticket can't be deleted and marked as sold as same time
        if ($request->has('delete_ticket') && $request->has('discussion_where_sold_id')) {
            flash( __( 'common.error' ) )->error()->important();
            return redirect()->route( 'public.message.home.page' );
        }

        // If ticket was sold to someone else
        if ($request->has('discussion_where_sold_id')) {
            // No need to mark discussion as denied, call to markAsSold will do it
            $result = $this->markTicketAsSold($request,$discussion->ticket_id,$request->discussion_where_sold_id);
            if ( $result === true ) {
                flash( __( 'message.success.sold' ) )->success()->important();

                return redirect()->route( 'public.message.discussion.page', [
                    $discussion->ticket_id,
                    $request->discussion_where_sold_id
                ] );
            } else {
                flash( $result['message'] )->error()->important();
                return redirect( $result['url'] );
            }
        }

        // Delete ticket (no need to deny offer)
        elseif($request->has('delete_ticket')) {

            $ticket = $discussion->ticket;
            if ( ! $ticket || $ticket->passed || $ticket->sold_to_id != null || \Auth::user()->id != $ticket->user_id ) {
                flash( __( 'common.error' ) )->error()->important();
                return redirect()->route( 'public.ticket.owned.page' );
            }
            $ticket->delete();
            flash( __( 'tickets.delete.success' ) )->success()->important();

            return redirect()->route( 'public.ticket.owned.page' );

        }
        // Simply deny offer
        else {
            $discussion->status = Discussion::DENIED;
            $discussion->save();

            $discussion->buyer->notify( new DenyOfferNotification( $discussion ) );

            flash( __( 'message.awaiting_offers.confirm_denial_message' ) )->success()->important();

            return redirect()->route( 'public.message.home.page' );
        }

    }

    public function acceptOffer( Request $request )
    {
        $this->validate( $request, [
            'discussion_id'
        ] );

        $discussion = Discussion::find( $request->discussion_id );
        if ( ! $discussion ) {
            flash( __( 'message.errors.not_found' ) )->error()->important();

            return redirect()->route( 'public.message.home.page' );
        }

        if ( $discussion->status != Discussion::AWAITING ) {
            flash( __( 'message.errors.cant_accept' ) )->error()->important();

            return redirect()->route( 'public.message.home.page' );
        }

        if ( $discussion->seller->id != \Auth::user()->id ) {
            flash( __( 'message.errors.wrong_user' ) )->error()->important();

            return redirect()->route( 'public.message.home.page' );
        }

        $discussion->status = Discussion::ACCEPTED;
        $discussion->save();

        $discussion->buyer->notify( new AcceptOfferNotification( $discussion ) );

        flash( __( 'message.awaiting_offers.confirm_accept' ) )->success()->important();

        return redirect()->route( 'public.message.home.page' );
    }

    /**
     * If discussion is not active, deal with it
     */
    public function checkIfDiscussionActive( Request $request, $ticket, $discussion )
    {

        // Make sure discussion belongs to ticket
        if ( ! $ticket->discussions->contains( $discussion ) ) {
            if ( ! ( $request->expectsJson() || $request->acceptsJson() ) ) {
                flash( __( 'message.errors.wrong_ticket_discussion' ) )->error()->important();
            }

            return false;
        }


        // Make sure user is allowed to this conversation
        if ( \Auth::user()->id != $discussion->seller->id && \Auth::user()->id != $discussion->buyer->id ) {
            if ( ! ( $request->expectsJson() || $request->acceptsJson() ) ) {
                flash( __( 'message.errors.wrong_user' ) )->error()->important();
            }

            return false;
        }

        // Make sure that conversation is accepted
        if ( $discussion->status < Discussion::ACCEPTED ) {
            if ( ! ( $request->expectsJson() || $request->acceptsJson() ) ) {
                flash( __( 'message.errors.not_active' ) )->error()->important();
            }

            return false;
        }

        return true;
    }

    /**
     * Display the discussion
     */
    public function getDiscussion( Request $request, $ticket_id, $discussion_id )
    {

        $discussion = Discussion::find( $discussion_id );
        if ( ! $discussion ) {
            flash( __( 'message.errors.not_found' ) )->error()->important();

            return redirect()->route( 'public.message.home.page' );
        }
        $ticket = Ticket::find( $ticket_id );
        if ( ! $ticket ) {
            flash( __( 'message.errors.ticket_not_found' ) )->error()->important();

            return redirect()->route( 'public.message.home.page' );
        }

        if ( ! $this->checkIfDiscussionActive( $request, $ticket, $discussion ) ) {
            return redirect()->route( 'public.message.home.page' );
        }

        // Mark all messages as read
        foreach ( $discussion->messages as $message ) {
            if ( $message->sender_id != \Auth::user()->id && $message->read_at == null ) {
                $message->read_at = Carbon::now();
                $message->save();
            }
        }

        // Mark notifications regarding this conversation as read
        $notifications = \Auth::user()->unreadNotifications->where( 'type', MessageNotification::class );
        foreach ( $notifications as $notification ) {
            if ( isset( $notification->data["discussion_id"] ) && $notification->data["discussion_id"] == $discussion_id ) {
                $notification->markAsRead();
            }
        }

        return view( 'messages.discussion' )
            ->with( 'user', new UserRessource( \Auth::user() ) )
            ->with( 'discussion', new DiscussionAllMessagesResource( $discussion ) );

    }

    /**
     * Seller sells ticket to the user of this conversation
     */
    public function sell( Request $request, $ticket_id, $discussion_id )
    {

        $result = $this->markTicketAsSold( $request, $ticket_id, $discussion_id );

        if ( $result === true ) {
            flash( __( 'message.success.sold' ) )->success()->important();

            return redirect()->route( 'public.message.discussion.page', [
                $ticket_id,
                $discussion_id
            ] );
        } else {
            flash( $result['message'] )->error()->important();

            return redirect( $result['url'] );
        }
    }

    /**
     * Mark ticket as sold for a given discussion
     * And deny all awaiting offers
     *
     * Return true if success
     * Else return an array with a message and a url to redirect to
     *
     * @param $ticket
     * @param $discussion
     *
     * @return array|bool
     */
    private function markTicketAsSold( $request, $ticket_id, $discussion_id )
    {
        $discussion = Discussion::find( $discussion_id );
        if ( ! $discussion ) {
            return [
                'message' => __( 'message.errors.not_found' ),
                'url'     => route( 'public.message.home.page' )
            ];
        }
        $ticket = Ticket::find( $ticket_id );
        if ( ! $ticket ) {
            return [
                'message' => __( 'message.errors.ticket_not_found' ),
                'url'     => route( 'public.message.home.page' )
            ];
        }

        if ( ! $this->checkIfDiscussionActive( $request, $ticket, $discussion ) ) {
            return [
                'message' => __( 'common.error' ),
                'url'     => route( 'public.message.home.page' )
            ];
        }

        // Make sure user is ticket seller
        if ( \Auth::user()->id != $ticket->user->id ) {
            return [
                'message' => __( 'message.errors.something' ),
                'url'     => route( 'public.message.home.page' )
            ];
        }

        $discussion->status = Discussion::SOLD;
        $ticket->sold_to_id = $discussion->buyer->id;
        $ticket->save();
        $discussion->save();

        $discussion->buyer->notify( new SoldToYouNotification( $discussion ) );

        // Deny all awaiting offers
        $awaitingOffers = $ticket->discussions->where( 'status', Discussion::AWAITING );
        foreach ( $awaitingOffers as $offer ) {
            $offer->status = Discussion::DENIED;
            $offer->save();

            $offer->buyer->notify( new DenyOfferNotification( $offer ) );
        }

        return true;
    }

    /**
     *
     * =======  API  =========
     *
     */

    /**
     * Post a message to as discussion
     */
    public function sendMessage( Request $request, Ticket $ticket, Discussion $discussion )
    {
        $request->validate( [
            'message' => 'required|string'
        ] );

        if ( ! $this->checkIfDiscussionActive( $request, $ticket, $discussion ) ) {
            return response( [
                'status'  => 'error',
                'message' => __( 'message.errors.something' )
            ], 400 );
        }

        // Now make sure that ticket isn't sold yet
        if ( $ticket->sold_to_id != null && $discussion->status != Discussion::SOLD ) {
            return response( [
                'status'  => 'error',
                'message' => __( 'message.errors.already_sold' )
            ], 400 );
        }

        $message = new Message( [
            'message'       => $request->message,
            'sender_id'     => \Auth::user()->id,
            'discussion_id' => $discussion->id,
        ] );

        // Save message and mark as sent
        if ( $message->save() ) {

            broadcast( new MessageSent( $message ) )->toOthers();

            $message->receiver->notify( new MessageNotification( $discussion ) );

            return new MessageResource( $message );
        } else {
            return response( [
                "status"  => "fail",
                "message" => "Message could not be send."
            ], 500 );
        }

    }

    /**
     * Mark as read
     */
    public function markAsRead( Request $request, $ticket_id, $discussion_id )
    {
        $discussion = Discussion::find( $discussion_id );
        if ( ! $discussion ) {
            flash( __( 'message.errors.not_found' ) )->error()->important();

            return redirect()->route( 'public.message.home.page' );
        }
        $ticket = Ticket::find( $ticket_id );
        if ( ! $ticket ) {
            flash( __( 'message.errors.ticket_not_found' ) )->error()->important();

            return redirect()->route( 'public.message.home.page' );
        }

        if ( ! $this->checkIfDiscussionActive( $request, $ticket, $discussion ) ) {
            return redirect()->route( 'public.message.home.page' );
        }

        // Mark all as read
        foreach ( $discussion->messages as $message ) {
            if ( $message->sender_id != \Auth::user()->id && $message->read_at == null ) {
                $message->read_at = Carbon::now();
                $message->save();
            }
        }

        return response( [
            "status" => "OK",
        ], 200 );
    }

}
