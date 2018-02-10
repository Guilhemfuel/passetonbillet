<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class DiscussionLastMessageResource extends Resource
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
            'id'           => $this->id,
            'status'       => $this->status,
            'buyer'        => new UserRessource( $this->buyer ),
            'seller'       => new UserRessource( $this->seller ),
            'ticket'       => new TicketRessource( $this->ticket ),
            'price'        => $this->price,
            'last_message' => $this->last_message,
            'currency'     => $this->currency,
            'updated_at'   => $this->updated_at,
        ];
    }
}
