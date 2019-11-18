<?php

namespace App\Http\Controllers;

use App\Claim;
use App\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClaimController extends Controller
{
    public function addClaimBuyer(Request $request) {
        $this->middleware('auth');

        $user = \Auth::user();

        if(!$request->ticket && !$request->answers) {
            return response(['status' => 'error', 'message' => trans('tickets.claim.api.no_data')], 400);
        }

        $ticket = Ticket::where('id', $request->ticket['id'])->first();

        if(!$ticket) {
            return response(['status' => 'error', 'message' => trans('tickets.buy_modal.ticket_doesnt_exist')], 400);
        }

        $departure = $ticket->train->departure_date;
        $time = explode(":", $ticket->train->departure_time);
        $departureDate = clone $departure->setTime($time[0], $time[1], $time[2]);

        $dateLimitClaim = $departure->addDays(2);
        $dateNow = Carbon::now();

        //If departure train has not started yet
        if($departureDate > $dateNow) {
            return response(['status' => 'error', 'message' => trans('tickets.claim.api.claim_before_departure')], 400);
        }

        //If 48 hours of claim are expired
        if($dateLimitClaim < $dateNow) {
            return response(['status' => 'error', 'message' => trans('tickets.claim.api.claim_date_limit')], 400);
        }

        $claim = claim::where('ticket_id', $ticket->id)->first();

        if (!$claim) {
            $claim = new Claim();

            $claim->seller_id = $ticket->user->id;
            $claim->purchaser_id = $user->id;
            $claim->ticket_id = $ticket->id;
        }

        $claim->claim_purchaser = serialize($request->answers);
        $claim->save();

        return response()->json(['status' => 'success', 'message' => trans('tickets.claim.api.claim_sent')]);
    }

    public function addClaimSeller(Request $request) {
        $this->middleware('auth');

        return response()->json(['status' => 'success', 'message' => 'oui']);
    }
}
