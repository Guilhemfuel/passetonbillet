<?php

namespace App\Http\Controllers\API;

use App\Exceptions\PasseTonBilletException;
use App\Facades\Optico;
use App\Http\Resources\DiscussionLastMessageResource;
use App\Models\Discussion;
use App\Ticket;
use App\Train;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{

    /**
     * For a given ticket returns collection of offers
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function getOffers( Request $request, Ticket $ticket )
    {

        // Check that ticket belongs to current user
        if ( ! \Auth::check() || \Auth::id() != $ticket->user_id ) {
            return response( [ 'Unauthorized' => 'Not your ticket' ], 403 );
        }

        $offers = $ticket->discussions->where( 'status', Discussion::ACCEPTED );

        return DiscussionLastMessageResource::collection( $offers );
    }

    /**
     * Return a paid phone number to call to contact seller of a given ticket.
     *
     * @param Request $request
     * @param Ticket  $ticket
     */
    public function getPaidPhoneNumber( Request $request, Ticket $ticket )
    {

        // Make sure ticket is still for sale, and not passed
        if ( $ticket->passed || $ticket->sold ) {
            throw new PasseTonBilletException( "Ticket is passed or sold." );
        }

        $user = $ticket->user;
        $phone = "00" . $user->phone_country_code . substr( $user->phone, 1 );

        return [
            'status' => 'success',
            'phone'  => Optico::getPaidPhoneNumber( $phone )
        ];

    }
}
