<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TrainRessource extends Resource
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
            'id'             => $this->id,
            'number'         => $this->number,
            'departure_date' => $this->departure_date,
            'departure_time' => $this->departure_time,
            'arrival_date'   => $this->arrival_date,
            'arrival_time'   => $this->arrival_time,
            'departure_city' => new StationRessource( $this->departureCity ),
            'arrival_city'   => new StationRessource( $this->arrivalCity ),
        ];
    }
}
