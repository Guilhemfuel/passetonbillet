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
            'duration'       => $this->duration,
            'departure_date' => $this->departure_date->format( 'Y-m-d' ),
            'departure_time' => $this->departure_time,
            'arrival_date'   => $this->arrival_date->format( 'Y-m-d' ),
            'arrival_time'   => $this->arrival_time,
            'departure_city' => new StationRessource( $this->departureCity ),
            'arrival_city'   => new StationRessource( $this->arrivalCity ),
            'full_departure_date' => $this->carbon_departure_date->format('Y-m-d H:i:s'),
            'full_arrival_date' => $this->carbon_arrival_date->format('Y-m-d H:i:s'),
        ];
    }
}
