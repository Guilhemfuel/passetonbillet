<?php

namespace App\Http\Controllers\Admin;

use App\Claim;
use App\Http\Requests\Admin\TrainRequest;
use App\Http\Resources\Admin\ClaimTableResource;
use App\Services\MangoPayService;
use App\Ticket;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClaimController extends BaseController
{

    protected $CRUDmodelName = 'claims';
    protected $CRUDsingularEntityName = 'Claim';
    protected $model = Claim::class;
    protected $searchable = false;
    protected $creatable = false;
    protected $paginable = false;

    public function index( Request $request )
    {

        $entities = Ticket::join( 'claims', 'tickets.id', '=', 'claims.ticket_id' )
            ->join( 'trains', 'tickets.train_id', '=', 'trains.id' )
            ->select( 'tickets.*')
            ->get();

        /*
        $entities = $this->model::join( 'trains', 'tickets.train_id', '=', 'trains.id' )
            ->join( 'stations', 'trains.departure_city', '=', 'stations.id' )
            ->with( $this->model::$relationships )
            ->orderBy( 'sold_to_id', 'desc' )
            ->orderBy( 'trains.departure_date' )
            ->where('trains.departure_date','>',Carbon::now()->addWeek(-1))
            ->orderBy( 'stations.name_en' )
            ->select( 'tickets.*', 'trains.departure_city', 'trains.departure_date', 'stations.name_en' )
            ->withScams()
            ->get();
        */

        $data = ['entities' => ClaimTableResource::collection( $entities ),
            'searchable' => $this->searchable,
            'creatable' => $this->creatable];

        return $this->ptbView( 'admin.CRUD.index', $data );
    }

    public function show($id) {

        $entity = Ticket::where('tickets.id', $id)
            ->join( 'claims', 'tickets.id', '=', 'claims.ticket_id' )
            ->join( 'trains', 'tickets.train_id', '=', 'trains.id' )
            ->select( '*', 'tickets.id', 'claims.id AS claim_id')
            ->first();

        //Get all history claims from Purchaser
        $claimsPurchaser = Claim::where('id', '!=', $entity->claim->id)
            ->where(function ($query) use ($entity) {
            $query->where('purchaser_id', $entity->claim->purchaser_id)
                ->orWhere('seller_id', $entity->claim->purchaser_id);
            })
            ->get();

        //Get all history claims from Seller
        $claimsSeller = Claim::where('id', '!=', $entity->claim->id)
            ->where(function ($query) use ($entity) {
                $query->where('purchaser_id', $entity->claim->seller_id)
                    ->orWhere('seller_id', $entity->claim->seller_id);
            })
            ->get();

        //Get all history bought and sold ticket from Purchaser
        $ticketsPurchaser = Ticket::where('tickets.id', '!=', $entity->id)
            ->join( 'transactions', 'tickets.id', '=', 'transactions.ticket_id' )
            ->where(function ($query) use ($entity) {
                $query->where('transactions.purchaser_id', $entity->claim->purchaser_id)
                    ->orWhere('transactions.seller_id', $entity->claim->purchaser_id);
            })
            ->where('status', 'SUCCEEDED')
            ->orderBy('transactions.updated_at')
            ->select( '*', 'tickets.id')
            ->get();

        //Get all history bought and sold ticket from Seller
        $ticketsSeller = Ticket::where('tickets.id', '!=', $entity->id)
            ->join( 'transactions', 'tickets.id', '=', 'transactions.ticket_id' )
            ->where(function ($query) use ($entity) {
                $query->where('transactions.purchaser_id', $entity->claim->seller_id)
                    ->orWhere('transactions.seller_id', $entity->claim->seller_id);
            })
            ->where('status', 'SUCCEEDED')
            ->orderBy('transactions.updated_at')
            ->select( '*', 'tickets.id')
            ->get();

        //Get ticket on sale from Purchaser
        $ticketsPurchaserOnSale = Ticket::select('*', 'tickets.id')
            ->where('user_id', $entity->claim->purchaser_id)
            ->whereNotIn('tickets.id', function($query) use($entity) {
                $query->select('ticket_id')->from('transactions')
                    ->where('seller_id', $entity->claim->purchaser_id)
                    ->where('status', 'SUCCEEDED');
            })
            ->get();

        //Get ticket on sale from Seller
        $ticketsSellerOnSale = Ticket::select('*', 'tickets.id')
            ->where('user_id', $entity->claim->seller_id)
            ->whereNotIn('tickets.id', function($query) use($entity) {
                $query->select('ticket_id')->from('transactions')
                    ->where('seller_id', $entity->claim->seller_id)
                    ->where('status', 'SUCCEEDED');
            })
            ->get();

        return view( 'admin.CRUD.claims.show', [
            'ticket' => $entity,
            'claimsPurchaser' => $claimsPurchaser,
            'claimsSeller' => $claimsSeller,
            'ticketsPurchaser' => $ticketsPurchaser,
            'ticketsSeller' => $ticketsSeller,
            'ticketsPurchaserOnSale' => $ticketsPurchaserOnSale,
            'ticketsSellerOnSale' => $ticketsSellerOnSale,
        ]);
    }

    public function refund($id) {

        $ticket = Ticket::where('tickets.id', $id)->first();

        if (!$ticket) {
            flash('Ce ticket n\'existe pas')->error();
            return redirect()->back();
        }

        $claim = Claim::where('ticket_id', $ticket->id)->first();
        $transaction = Transaction::where('ticket_id', $ticket->id)->first();

        if (!$claim->status) {
            $transactionId = $transaction->transaction_mangopay;
            $mangoUser = $transaction->purchaser->mangopay_id;

            $mangoPay = new MangoPayService();
            $refunds = $mangoPay->listRefundsPayIn($transactionId);
            $refund = $mangoPay->createRefundPayIn($transactionId, $mangoUser);

            $transaction->status_transfer = Transaction::STATUS_REFUND_PURCHASER;
            $claim->status = Claim::CLAIM_STATUS_WON;

            $claim->save();
            $transaction->save();

            flash('Claim résolu pour l\'acheteur !')->success();

        } else {
            flash('Ce claim a déjà été traité')->error();
        }

        return redirect()->back();
    }

    public function pay($id) {

        $ticket = Ticket::where('tickets.id', $id)->first();

        if (!$ticket) {
            flash('Ce ticket n\'existe pas')->error();
            return redirect()->back();
        }

            $claim = Claim::where('ticket_id', $ticket->id)->first();
            $transaction = Transaction::where('ticket_id', $ticket->id)->first();

            if (!$claim->status) {
                $wallet = $transaction->wallet_id;
                $mangoUser = $transaction->seller->mangopay_id;

                $mangoPay = new MangoPayService();
                $mangoPay->getMangoUser($mangoUser);
                $bankAccount = $mangoPay->getBankAccount();
                $wallet = $mangoPay->getWallet($wallet);

                $payOut = $mangoPay->createPayOut($bankAccount, $mangoUser, $wallet);

                $claim->status = Claim::CLAIM_STATUS_LOST;
                $claim->save();

                if (isset($payOut->Status)) {
                    $transaction->status_transfer = $payOut->Status;
                } else {
                    $transaction->status_transfer = Transaction::STATUS_TRANSFER_FAIL;
                }

                $transaction->save();

                flash('Claim résolu pour le vendeur !')->success();
            } else {
                flash('Ce claim a déjà été traité')->error();
            }

        return redirect()->back();
    }

    public function payEach($id) {

        $ticket = Ticket::where('tickets.id', $id)->first();

        if (!$ticket) {
            flash('Ce ticket n\'existe pas')->error();
            return redirect()->back();
        }

        $claim = Claim::where('ticket_id', $ticket->id)->first();
        $transaction = Transaction::where('ticket_id', $ticket->id)->first();

        if (!$claim->status) {
            $wallet = $transaction->wallet_id;
            $transactionId = $transaction->transaction_mangopay;
            $mangoBuyerUser = $transaction->purchaser->mangopay_id;
            $mangoSellerUser = $transaction->seller->mangopay_id;

            $mangoPay = new MangoPayService();
            $mangoPay->getMangoUser($mangoSellerUser);
            $bankAccount = $mangoPay->getBankAccount();
            $wallet = $mangoPay->getWallet($wallet);

            $refund = $mangoPay->createRefundPayIn($transactionId, $mangoBuyerUser, $wallet->Balance->Amount, true);
            $payOut = $mangoPay->createPayOut($bankAccount, $mangoSellerUser, $wallet);

            $claim->status = Claim::CLAIM_STATUS_EQUALITY;
            $claim->save();

            if (isset($payOut->Status)) {
                $transaction->status_transfer = $payOut->Status;
            } else {
                $transaction->status_transfer = Transaction::STATUS_TRANSFER_FAIL;
            }

            $transaction->save();

            flash('Claim résolu pour les 2 partis !')->success();
        } else {
            flash('Ce claim a déjà été traité')->error();
        }

        return redirect()->back();
    }
}
