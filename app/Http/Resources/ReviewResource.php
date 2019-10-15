<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ReviewResource extends Resource
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
            'id'      => $this->id,
            'name'    => $this->user->first_name,
            'text'    => $this->text,
            'date'    => $this->created_at,
            'mark'    => $this->mark,
            'picture' => $this->user->picture
        ];
    }
}
