<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserRessource extends Resource
{
    private $offersDone = [];

    /**
     * Create a new resource instance.
     *
     * @param  mixed $resource
     *
     * @return void
     */
    public function __construct( $ressource, $includeOffers = false )
    {
        parent::__construct( $ressource );

        if ( $includeOffers ) {
            $this->offersDone = $this->offers->where('status','>=',0)->pluck( 'ticket_id' );
        }
    }

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
            'id'                   => $this->id,
            'first_name'           => $this->first_name,
            'last_name'            => $this->last_name,
            'full_name'            => $this->full_name,
            'location'             => $this->location,
            'picture'              => $this->picture,
            'email'                => $this->email,
            'language'             => $this->language,
            'verified'             => $this->id_verified,
            'admin'                => $this->isAdmin(),
            'unread_notifications' => count( $this->unreadNotifications ),
            'offers_sent'          => $this->when( $this->offersDone != [], $this->offersDone ),
        ];
    }
}
