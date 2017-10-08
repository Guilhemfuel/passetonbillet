<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class StationRessource extends Resource
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
            'eurostar_id' => $this->eurostar_id,
            'name' => $this->name,
            'short_name' => $this->short_name,
            'country' => $this->country,
        ];
    }
}
