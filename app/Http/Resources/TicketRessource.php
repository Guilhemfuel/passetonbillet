<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TicketRessource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserRessource($this->user),
            'train' => new TrainRessource($this->train),
            'price' => $this->price,
            'currency' => $this->currency,
            'flexibility' => $this->flexibility,
            'class' => $this->class,
            'bought_price' => $this->bought_price,
            'bought_currency' => $this->bought_currency,
            'inbound' => $this->inbound,
        ];
    }
}
