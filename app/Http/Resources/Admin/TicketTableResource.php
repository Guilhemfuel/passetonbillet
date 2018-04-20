<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray( $request )
    {
        return [
            'id'             => $this->id,
            'seller_name'    => $this->user->full_name,
            'seller_link'      => route('users.edit',$this->user_id),
            'departure_date' => $this->train->carbon_departure_date->format( 'd/m/Y' ),
            'departure_city' => substr( $this->train->departureCity->short_name, 2 ),
            'arrival_city'   => substr( $this->train->arrivalCity->short_name, 2 ),
            'currency'       => $this->currency_symbol,
            'price'          => $this->price,
            'offers_count'   => $this->discussions->count(),
            'status'         => $this->status,
            'edit_link'      => route( 'tickets.edit', [ 'ticket_id' => $this->id ] ),
            'share_link'     => route( 'ticket.unique.page', [ 'ticket_id' => \Hashids::encode( $this->id ) ] ),
        ];
    }
}
