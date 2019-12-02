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
            ->orderBy('claims.status', 'DESC')
            ->get();

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

        if (!$claim->status) {
            //Update Claim Status
            $claim->status = Claim::CLAIM_STATUS_WON;
            $claim->save();

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

            if (!$claim->status) {
                //Update claim status
                $claim->status = Claim::CLAIM_STATUS_LOST;
                $claim->save();

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

        if (!$claim->status) {
            $claim->status = Claim::CLAIM_STATUS_EQUALITY;
            $claim->save();

            flash('Claim résolu pour les 2 partis !')->success();
        } else {
            flash('Ce claim a déjà été traité')->error();
        }

        return redirect()->back();
    }
}
