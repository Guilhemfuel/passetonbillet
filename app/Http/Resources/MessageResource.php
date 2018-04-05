<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MessageResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'sender_id'  => $this->sender_id,
            'message'    => $this->message,
            'created_at' => $this->created_at,
            'read_at'    => $this->read_at
        ];
    }
}
