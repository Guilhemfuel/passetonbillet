<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TicketFullRessource extends Resource
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
            'id' => $this->id?:null,
            'user' => $this->user_id?new UserRessource($this->user):null,
            'train' => new TrainRessource($this->train),
            'price' => $this->price,
            'currency' => $this->currency,
            'currency_symbol' => $this->currency_symbol,
            'flexibility' => $this->flexibility,
            'class' => $this->class,
            'bought_price' => $this->bought_price,
            'bought_currency' => $this->bought_currency,
            'bought_currency_symbol' => $this->bought_currency_symbol,
            'inbound' => $this->inbound,
            'provider'               => $this->provider,
            'buyer' => $this->sold_to_id?new UserRessource($this->buyer):null,
            'download_link' => route('public.ticket.download',['ticket_id'=>$this->id]),
            'passbook_link' => $this->passbook_link,
            'created_at'             => $this->created_at,


            // Only for seller
            'ticket_number' => $this->when( \Auth::check() && \Auth::user()->id == $this->user_id, $this->ticket_number ),

        ];
    }
}
