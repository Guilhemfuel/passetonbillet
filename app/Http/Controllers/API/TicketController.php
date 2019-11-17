<?php

namespace App\Http\Controllers\API;

use App\Exceptions\PasseTonBilletException;
use App\Facades\Optico;
use App\Http\Resources\DiscussionLastMessageResource;
use App\Http\Resources\DiscussionResource;
use App\Http\Resources\TicketRessource;
use App\Models\Discussion;
use App\Ticket;
use App\Train;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\PdfService;

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
    public function getPaidPhoneNumber( Request $request, Ticket $ticket, $country )
    {

        // Make sure ticket is still for sale, and not passed
        if ( $ticket->passed || $ticket->sold ) {
            throw new PasseTonBilletException( "Ticket is passed or sold." );
        }

        $user = $ticket->user;
        $phone = "00" . $user->phone_country_code . substr( $user->phone, 1 );

        return [
            'status' => 'success',
            'phone'  => Optico::getPaidPhoneNumber( $phone, $country )
        ];

    }

    /**
     * API for the owned ticket page
     *
     * @param $type
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function owned($type)
    {
        $this->middleware('auth');

        switch ( $type ) {
            case 'selling':
                return TicketRessource::collection( \Auth::user()->tickets );
                break;
            case 'bought':

                $tickets = Ticket::select('*', 'tickets.id')
                    ->join('transactions', 'tickets.id', '=', 'transactions.ticket_id')
                    ->where('purchaser_id', \Auth::user()->id)
                    ->where('status', 'SUCCEEDED')->get();

                return TicketRessource::collection($tickets);
                break;
            case 'offers_sent':
                return DiscussionResource::collection( \Auth::user()->offers
                    ->whereIn( 'status', [
                        Discussion::AWAITING,
                        Discussion::DENIED,
                        Discussion::ACCEPTED
                    ] )
                );
                break;
        }

        return response([
            'status' => 'error',
            'message' => 'Wrong type specified.'
        ], 400);
    }

    public function updatePrice($id, Request $request)
    {
        $this->middleware('auth');

        $user = \Auth::user();
        $ticket = Ticket::where('id', $id)->first();

        if($ticket) {
            return response(['status' => 'error', 'message' => trans('tickets.buy_modal.ticket_doesnt_exist')], 400);
        }

        if ($ticket->user_id === $user->id) {
            return response(['status' => 'error', 'message' => trans('tickets.api.not_allowed')], 400);
        }

        if (!$ticket->hasBeenSold()) {
            return response()->json(['status' => 'error', 'message' => trans('tickets.buy_modal.ticket_already_sold')], 400);
        }

        if ($request->price) {
            return response()->json(['status' => 'error', 'message' => trans('tickets.api.price_empty')], 400);
        }

        if ($ticket->maxPrice >= $request->price) {

            $ticket->price = $request->price;
            $ticket->save();

            return response()->json(['status' => 'success', 'message' => trans('tickets.api.price_updated')]);
        }
        return response()->json(['status' => 'error', 'message' => trans('tickets.pdf.price_too_high') . ' ' . $ticket->maxPrice . $ticket->currency], 400);
    }

    public function updatePdf($id, Request $request)
    {
        $this->middleware('auth');

        $user = \Auth::user();
        $ticket = Ticket::where('id', $id)->first();

        if($ticket) {
            return response(['status' => 'error', 'message' => trans('tickets.buy_modal.ticket_doesnt_exist')], 400);
        }

        if ($ticket->user_id === $user->id) {
            return response(['status' => 'error', 'message' => trans('tickets.api.not_allowed')], 400);
        }

        if (!$ticket->hasBeenSold()) {
            return response()->json(['status' => 'error', 'message' => trans('tickets.buy_modal.ticket_already_sold')], 400);
        }

        if ($request->file && $request->page) {
            return response()->json(['status' => 'error', 'message' => trans('tickets.api.pdf_empty')], 400);
        }

        $pdfService = new PdfService();

        if ($pdfService->checkPdf()) {

            if ($ticket->has_pdf) {
                Storage::delete(env('STORAGE_PDF') . '/' . $ticket->pdf);
            }

            $pdf = $pdfService->storePdfBase64($request->file);
            $pdfService->splitPdf($request->page);

            $ticket->pdf = $pdf;
            $ticket->page_pdf = $request->page;
            $ticket->save();

            return response()->json(['status' => 'success', 'message' => trans('tickets.api.pdf_uploaded')]);
        }
        return response()->json(['status' => 'error', 'message' => trans('tickets.pdf.verif_pdf_error')], 400);
    }

    public function deleteTicket($id)
    {
        $this->middleware('auth');

        $user = \Auth::user();
        $ticket = Ticket::where('id', $id)->first();

        if($ticket) {
            return response(['status' => 'error', 'message' => trans('tickets.buy_modal.ticket_doesnt_exist')], 400);
        }

        if($ticket->user_id === $user->id) {

            if($ticket->has_pdf) {
                Storage::delete(env('STORAGE_PDF') . '/' . $ticket->pdf);
            }

            if(!$ticket->transaction or $ticket->transaction->status != "SUCCEEDED")
            {
                $ticket->delete();
                return response()->json(['status' => 'success', 'message' => trans('tickets.api.ticket_deleted')]);
            }
        }
        return response(['status' => 'error', 'message' => trans('tickets.api.delete_ticket_no_right')], 400);
    }
}
