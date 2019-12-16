<?php

namespace App\Http\Resources;

use App\Claim;
use Illuminate\Http\Resources\Json\Resource;
use Vinkla\Hashids\Facades\Hashids;

class TicketRessource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray( $request )
    {
        return [
            'id'                     => $this->id ?: null,
            'hashid'                 => $this->id ? Hashids::encode( $this->id ) : null,
            'user'                   => $this->user_id ? new UserRessource( $this->user ) : null,
            'train'                  => new TrainRessource( $this->train ),
            'price'                  => $this->price,
            'sellPrice'              => $this->sell_price,
            'currency'               => $this->currency,
            'currency_symbol'        => $this->currency_symbol,
            'flexibility'            => $this->flexibility,
            'class'                  => $this->class,
            'bought_price'           => $this->bought_price,
            'bought_currency'        => $this->bought_currency,
            'bought_currency_symbol' => $this->bought_currency_symbol,
            'inbound'                => $this->inbound,
            'buyer'                  => $this->sold_to_id ? new UserRessource( $this->buyer ) : null,
            'discussion_id'          => $this->discussionSold ? $this->discussionSold->id : null,
            'provider'               => $this->provider,
            'created_at'             => $this->created_at,
            'pdf_downloaded'         => $this->when( \Auth::check() && \Auth::user()->id == $this->user_id, $this->pdf_downloaded ),
            'passed'                 => $this->passed,
            'sold'                   => $this->sold,
            'maxPrice'               => $this->max_price,
            'hasPdf'                 => $this->has_pdf,
            'hasClaim'               => $this->has_claim,
            'statusClaim'            => $this->has_claim ? $this->claim->status : null,
            'statusTransactionPayout'      => $this->transaction ? $this->transaction->status_payout : null,
            'claimLimitPurchaser'    => $this->limit_claim_purchaser->format('Y-m-d H:i:s'),
            'claimLimitSeller'       => $this->limit_claim_seller ? $this->limit_claim_seller->format('Y-m-d H:i:s') : null,
            'dateBeforeTransfer'     => $this->date_before_transfer ? $this->date_before_transfer->format('Y-m-d H:i:s') : null,

            // Only for seller, or when selecting (user id is null)
            'ticket_number'          => $this->when( ( \Auth::check() && \Auth::user()->id == $this->user_id ) || $this->user_id == null, $this->ticket_number ),
        ];
    }
}
