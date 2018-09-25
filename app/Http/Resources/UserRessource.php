<?php

namespace App\Http\Resources;

use App\Models\Discussion;
use Illuminate\Http\Resources\Json\Resource;
use Vinkla\Hashids\Facades\Hashids;

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
            $this->offersDone = $this->offers
                ->whereIn('status',[Discussion::AWAITING,Discussion::DENIED,Discussion::ACCEPTED])
                ->map(function ($item) {
                    return [
                        'id'=>$item['id'],
                        'ticket_id' => $item['ticket_id'],
                        'status' => $item['status'],
                        'price' => $item['price']];
                });
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
            'created_at'           => $this->created_at,
            'hashid'               => Hashids::encode($this->id),
            'first_name'           => $this->first_name,
            'last_name'            => $this->when(\Auth::check() && \Auth::user()->isAdmin() || \Auth::check() && $this->id == \Auth::id(), $this->last_name),
            'birthdate'            => $this->when(\Auth::check() && \Auth::user()->isAdmin(), $this->birthdate!=null?$this->birthdate->format('d/m/Y'):null),
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
