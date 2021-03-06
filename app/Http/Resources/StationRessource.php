<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class StationRessource extends Resource
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
            'id'                    => $this->id,
            'sncf_id'               => $this->sncf_id ?: null,
            'name'                  => $this->name,
            'name_country_specific' => $this->name_country_specific,
            'short_name'            => $this->short_name,
            'slug'                  => $this->slug,
            'country'               => $this->country,
        ];
    }
}
