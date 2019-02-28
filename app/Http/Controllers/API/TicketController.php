<?php

namespace App\Http\Controllers\API;

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
    public function getOffers( Request $request, Ticket $ticket ){

        // Check that ticket belongs to current user
        if ( !\Auth::check() || \Auth::id() != $ticket->user_id) {
            return response(['Unauthorized'=>'Not your ticket'],403);
        }

        $offers = $ticket->discussions->where('status',Discussion::ACCEPTED);

        return DiscussionLastMessageResource::collection($offers);
    }
}
