<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiscussionLastMessageResource;
use App\Models\Discussion;
use App\Notifications\OfferNotification;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{

    public function __construct(  )
    {
        $this->middleware('auth');
    }

    public function messages( $type )
    {
        switch ($type) {
            case 'buying':
                $buyingDiscussions = \Auth::user()
                                          ->offers()
                                          ->where( 'status', '>=', Discussion::ACCEPTED )
                                          ->get();

                return DiscussionLastMessageResource::collection( $buyingDiscussions->sortByDesc( 'updated_at' ) );
                break;
            case 'offers_accepted':
                $tickets = \Auth::user()->tickets;
                $sellingDiscussions = collect();
                foreach ( $tickets as $ticket ) {
                    $discussions = $ticket->discussions;
                    $sellingDiscussions = $sellingDiscussions->merge( $discussions->where( 'status', '>=', Discussion::ACCEPTED ) );
                }
                // Mark notification of offers as read in database (as we're on page)
                \Auth::user()->unreadNotifications->where( 'type', OfferNotification::class )->markAsRead();

                return DiscussionLastMessageResource::collection( $sellingDiscussions->sortByDesc( 'updated_at' ) );
                break;
            case 'offers_received':
                $tickets = \Auth::user()->tickets;
                $offersAwaiting = collect();
                foreach ( $tickets as $ticket ) {
                    $discussions = $ticket->discussions;
                    $offersAwaiting = $offersAwaiting->merge( $discussions->where( 'status', Discussion::AWAITING ) );
                }
                return DiscussionLastMessageResource::collection( $offersAwaiting->sortByDesc( 'updated_at' ) );
                break;
        }

        return response([
            'status' => 'error',
            'message' => 'Wrong type specified.'
        ], 400);
    }
}
