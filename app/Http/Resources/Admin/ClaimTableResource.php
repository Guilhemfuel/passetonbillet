<?php

namespace App\Http\Resources\Admin;

use App\Claim;
use App\Http\Resources\TrainRessource;
use App\Http\Resources\UserRessource;
use Illuminate\Http\Resources\Json\Resource;
use Vinkla\Hashids\Facades\Hashids;

class ClaimTableResource extends Resource
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
            'seller'                 => $this->claim ? new UserRessource( $this->claim->seller ) : null,
            'purchaser'              => $this->claim ? new UserRessource( $this->claim->purchaser ) : null,
            'seller_link'            => route( 'users.edit', $this->user_id ),
            'purchaser_link'         => route( 'users.edit', $this->claim->purchaser_id ),
            'train'                  => new TrainRessource( $this->train ),
            'departure_date'         => $this->train->carbon_departure_date->format( 'd/m/Y' ),
            'departure_city'         => $this->train->departureCity->name,
            'arrival_city'           => $this->train->arrivalCity->name,
            'status_claim'           => $this->claim->status ? $this->claim->status : 'None',
            'date_claim'             => $this->claim->created_at->format( 'd/m/Y' ),
            'show_link'              => route( 'claims.show', $this->id ),
            'price'                  => $this->price,
            'currency'               => $this->currency,
            'currency_symbol'        => $this->currency_symbol,
            'bought_price'           => $this->bought_price,
            'bought_currency'        => $this->bought_currency,
            'bought_currency_symbol' => $this->bought_currency_symbol,
            'maxPrice'               => $this->max_price,
            'hasPdf'                 => $this->has_pdf,
            'hasClaim'               => $this->has_claim,
            'claimLimitPurchaser'    => $this->limit_claim_purchaser->format('Y-m-d H:i:s'),
            'claimLimitSeller'       => $this->limit_claim_seller ? $this->limit_claim_seller->format('Y-m-d H:i:s') : null,
            'dateBeforeTransfer'     => $this->date_before_transfer ? $this->date_before_transfer->format('Y-m-d H:i:s') : null,

            // Only for seller, or when selecting (user id is null)
            'ticket_number'          => $this->when( ( \Auth::check() && \Auth::user()->id == $this->user_id ) || $this->user_id == null, $this->ticket_number ),
        ];
    }
}
