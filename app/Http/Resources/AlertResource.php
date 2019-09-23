<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlertResource extends JsonResource
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
            'id'                => $this->id,
            'user'              => new UserRessource( $this->user ),
            'email'             => $this->email,
            'travel_date_start' => $this->travel_date_start,
            'travel_date_end'   => $this->travel_date_end,
            'departure_city'    => new StationRessource( $this->departureStation ),
            'arrival_city'      => new StationRessource( $this->arrivalStation ),
        ];
    }
}
