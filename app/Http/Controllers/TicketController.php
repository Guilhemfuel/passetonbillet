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
use App\Mail\SendAfterDepartureEmail;
use App\Mail\SendNotifToSellerEmail;
use App\Mail\SendTicketEmail;
use App\Models\AdminWarning;
use App\Models\Discussion;
use App\Models\Statistic;
use App\Notifications\OfferNotification;
use App\Ticket;
use App\Train;
use App\Trains\TrainConnector;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Facades\Eurostar;
use Mockery\Exception;
use Illuminate\Support\Facades\Storage;
use App\Services\MangoPayService;
use App\Services\PdfService;


class TicketController extends Controller
{

    const LIMIT_OFFERS_PER_DAY = 8;

    const COOKIE_TRIP_DEPARTURE = 'train_departure';

    const COOKIE_TRIP_ARRIVAL = 'train_arrival';

    //After user put credit card and click on payment
    //We can create user mangopay and wallet
    //If there is a 3DSecure transaction we send the callback URL from mangopay
    //If not we can send the success by ourselves
    public function buyTicket(Request $request, $id)
    {
        $this->middleware('auth');

        $user = \Auth::user();
        $ticket = Ticket::where('id', $id)->first();
        $transaction = Transaction::where('ticket_id', $ticket->id)->first();

        //If ticket exist and available
        if (!$ticket) {
            return response()->json(['message' => trans('tickets.buy_modal.ticket_doesnt_exist')]);
        }

        if (!$user->mangopay_id) {
            return response()->json(['message' => trans('tickets.buy_modal.no_mangopay')]);
        }

        $mangoPaySeller = new MangoPayService();

        $seller = User::where('id', $ticket->user->id)->first();

        //Create MangoPay for seller if doesn't exist
        if (!$seller->mangopay_id) {
            $mangoSeller = $mangoPaySeller->createMangoUser($seller);

            $seller->mangopay_id = $mangoSeller->Id;
            $seller->save();
        } else {
            $mangoPaySeller->getMangoUser($ticket->user->mangopay_id);
        }

        //If ticket has no transaction yet, then we can create a wallet for it
        if (!$transaction) {
            $wallet = $mangoPaySeller->createWallet($ticket->id, $ticket->currency);

            $transaction = new Transaction();

            $transaction->wallet_id = $wallet->Id;
            $transaction->seller_id = $seller->id;
            $transaction->purchaser_id = $user->id;
            $transaction->ticket_id = $ticket->id;

            $transaction->save();
        } else {

            //If ticket is already bought
            if ($transaction->status === 'SUCCEEDED') {
                return response()->json(['message' => trans('tickets.buy_modal.ticket_already_sold')]);
            }

            $wallet = $mangoPaySeller->getWallet($transaction->wallet_id);

            //If there is a current wallet with wrong currency we need to make a new one
            //It is not allow to change currency in Mangopay
            if($wallet->Currency != $ticket->currency) {
                $wallet = $mangoPaySeller->createWallet($ticket->id, $ticket->currency);

                $transaction->wallet_id = $wallet->Id;
                $transaction->save();
            }
        }

        $payIn = [
            'CreditedWalletId' => $transaction->wallet_id,
            'AuthorId' => $user->mangopay_id,
            'Currency' => $ticket->bought_currency,
            'Amount' => $ticket->price,
            'CurrencyFees' => $ticket->bought_currency,
            'AmountFees' => 1,
            'CardId' => $request->idCard,
            'SecureModeReturnURL' => route('api.ticket.transaction.success')
        ];

        $payIn = $mangoPaySeller->directPayIn((object)$payIn);

        if(!$payIn OR !is_object($payIn)) {
            return response()->json(['state' => 'error', 'payIn' => $payIn]);
        }

        $transaction->purchaser_id = $user->id;
        $transaction->status = $payIn->Status;
        $transaction->transaction_mangopay = $payIn->Id;
        $transaction->save();

        if($transaction->status === 'SUCCEEDED') {
            return response()->json(['state' => 'success', 'redirect' => route('api.ticket.transaction.success') . '?transactionId=' . $transaction->transaction_mangopay]);
        }

        if($payIn->ExecutionDetails->SecureModeNeeded) {
            return response()->json(['state' => 'created', 'payIn' => $payIn, 'redirect' => $payIn->ExecutionDetails->SecureModeRedirectURL]);
        }

        return response()->json(['state' => 'error', 'payIn' => $payIn]);
    }

    //After 3DSecure from MangoPay we get a callback with transactionId
    //We can refresh status of Transaction then display a message to user if payment succeed or failed
    public function successPayment(Request $request) {

        $this->middleware('auth');

        //MangoPay SecureModeReturnURL
        $transaction = Transaction::where('transaction_mangopay', $request->transactionId)->first();

        if ($transaction) {
            $mangoPay = new MangoPayService();
            $transactionMango = $mangoPay->getTransaction($transaction->transaction_mangopay, $transaction->wallet_id);

            if ($transactionMango) {
                $transaction->status = $transactionMango->Status;
                $transaction->save();

                if($transaction->status === 'SUCCEEDED') {
                    //Send email with ticket PDF to user
                    $this->sendTicket($transaction->ticket);

                    $request->session()->put('successPurchase', $request->transactionId);
                } else {
                    $request->session()->put('failPurchase', $request->transactionId);
                }
            }
        }

        return redirect()->route('home');
    }

    //After payment success we can send ticket to user by email
    private function sendTicket($ticket) {

        $this->middleware('auth');

        $user = \Auth::user();

        $file = storage_path('app/uploads/' . $ticket->pdf);

        //Send email to Purchaser
        \Mail::to($user->email)->send(new SendTicketEmail($user, $ticket, $file));

        //Send email to Seller
        \Mail::to($user->email)->send(new SendNotifToSellerEmail($ticket->transaction->seller, $ticket));

        //Put email in Queue to send 1 hour after departure of train
        $when = $ticket->train->carbon_date_email_after_departure;
        \Mail::to($user->email)->later($when, new SendAfterDepartureEmail($user, $ticket));
    }

    public function downloadTicket($id)
    {
        $user = \Auth::user();

        if (!$user) {
            flash()->error('User not found.');
            return redirect()->back();
        }

        $ticket = Ticket::where('id', $id)->first();

        if (!$ticket) {
            flash('Ce ticket n\'existe pas')->error();
            return redirect()->back();
        }

        if ($ticket->user_id === $user->id OR ($ticket->transaction->purchaser_id === $user->id && $ticket->transaction->status === 'SUCCEEDED')) {
            $name = 'PTB Ticket n°' . $ticket->id . ' - ' . $ticket->train->departureCity->name . '-' . $ticket->train->arrivalCity->name . '.pdf';
            return Storage::download(env('STORAGE_PDF') . '/' . $ticket->pdf, $name);
        }

        return redirect()->route('home');
    }

    /**
     * @param SellTicketRequest $request
     *
     * Save ticket and make it available to buy
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sellTicket(SellTicketRequest $request)
    {
        $this->middleware('auth');

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
            flash( __( 'tickets.sell.errors.duplicate' ) )->error()->important();

            return redirect()->route( 'public.ticket.sell.page' );
        }

        $pdfService = new PdfService();
        $pdf = $pdfService->storePdfBase64($request->file);

        //Class to check PDF in the futur
        if (!$pdfService->checkPdf()) {
            flash(__('tickets.pdf.verif_pdf_error'))->error()->important();
            return redirect()->route('public.ticket.sell.page');
        }

        $pdfService->splitPdf($request->page);

        //We put additional fees to the price ticket
        $price = ceil(((Transaction::FEES_TICKET_ON_SALE / 100) * $request->price) + $request->price);

        $ticket->user_id = \Auth::id();
        $ticket->price = $price;
        $ticket->currency = $ticket->bought_currency;
        $ticket->user_notes = $request->notes;
        $ticket->pdf = $pdf;
        $ticket->save();

        Amplitude::logEvent('add_ticket', [
            'ticket_id' => $ticket->id,
            'ticket_provider' => $ticket->provider
        ]);

        // Dispatch ticket added event
        event(new TicketAddedEvent($ticket));

        flash(__('tickets.sell.success'))->success()->important();

        return redirect()->route('public.ticket.sold.page')
            ->with(['addedTicket' => new TicketRessource($ticket)]);

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
        // Local testing
        if ( \App::environment() != 'prod' && $request->last_name == 'ptb' ) {
            $ticket = factory( Ticket::class )->state( 'new' )->make();

            switch ( $request->booking_code ) {
                case 'sncfff':
                case 'sncffff':
                    $ticket->provider = 'sncf';
                    break;
                case 'eurosta':
                case 'eurost':
                    $ticket->provider = 'eurostar';
                    break;
                case 'thalys':
                case 'thalyss':
                    $ticket->provider = 'thalys';
                    break;
                case 'izyyyy':
                case 'izyyyyy':
                    $ticket->provider = 'izy';
                    break;
                case 'ouigooo':
                case 'ouigoo':
                    $ticket->provider = 'ouigo';
                    break;
                default:
                    throw new \Exception( 'Debug booking code ' . $request->booking_code . ' does not
                    correspond to a valid provider.' );
            }
            $tickets = [$ticket];
        } else {

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
                        'trace'   => $e->getFile() . ' line: ' . $e->getLine()
                    ];
                    continue;
                }
            }

            // Return Debug infos
            if ( \App::environment() == 'local' && count( $errors ) > 0 && $tickets == null ) {
                return response( [
                    'message' => 'Multiple errors found.',
                    'errors'  => $errors
                ], 400 );
            }
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

        // Put cookie to remember trip for one week
        return response( TicketRessource::collection( $tickets ) )->cookie(
            self::COOKIE_TRIP_DEPARTURE, $request->departure_station, 24 * 60 * 7
        )->cookie(
            self::COOKIE_TRIP_ARRIVAL, $request->arrival_station, 24 * 60 * 7
        );
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
