<?php

namespace App\Http\Controllers\API\Admin;

use App\Claim;
use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Discussion;
use App\Models\Verification\IdVerification;
use App\Station;
use App\Ticket;
use App\Train;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    const RESOURCES = [
        'ticketCount',
        'currentTicketCount',
        'ticketSoldCount',
        'trainCount',
        'userCount',
        'stationCount',
        'idVerificationCount',
        'offerCount',
        'alertCount',
        'alertCurrentCount',
        'claimsCount',
    ];

    /**
     * Return the required resource returned by the homepage
     *
     * @param $resource
     */
    public function getHomeResource( $resource )
    {
        if ( ! in_array( $resource, self::RESOURCES ) ) {
            return response( [
                'error' => 'The resource specified is unknown.'
            ], 400 );
        }

        switch ( $resource ) {
            case 'ticketCount':
                return $this->getTicketCount();
                break;
            case 'currentTicketCount':
                return $this->getCurrentTicketCount();
                break;
            case 'ticketSoldCount':
                return $this->getTicketSoldCount();
                break;
            case 'trainCount':
                return $this->getTrainCount();
                break;
            case 'userCount':
                return $this->getUserCount();
                break;
            case 'stationCount':
                return $this->getStationCount();
                break;
            case 'idVerificationCount':
                return $this->getIdVerifCount();
                break;
            case 'offerCount':
                return $this->getOfferCount();
                break;
            case 'alertCount':
                return $this->getAlertCount();
                break;
            case 'alertCurrentCount':
                return $this->getCurrentAlertCount();
                break;
            case 'claimsCount':
                return $this->getClaimsCount();
                break;
        }

        return [];
    }

    private function getTicketCount(){
        return [
            'count' => Ticket::count()
        ];
    }

    private function getCurrentTicketCount(){
        return [
            'count' => Ticket::currentTickets()->count()
        ];
    }

    private function getTicketSoldCount(){
        return [
            'count' => Ticket::whereNotNull( 'sold_to_id' )->count()
        ];
    }

    private function getTrainCount(){
        return [
            'count' => Train::count(),
        ];
    }

    private function getUserCount(){
        return [
            'count' => User::count(),
        ];
    }

    private function getStationCount(){
        return [
            'count' => Station::count(),
        ];
    }

    private function getIdVerifCount(){
        return [
            'count' => IdVerification::awaitingCount(),
        ];
    }

    private function getOfferCount(){
        return [
            'count' => Discussion::count(),
        ];
    }

    private function getAlertCount(){
        return [
            'count' => Alert::count(),
        ];
    }

    private function getCurrentAlertCount(){
        return [
            'count' => Alert::current()->count(),
        ];
    }

    private function getClaimsCount() {
        return [
            'count' => Claim::where('status', null)->count(),
        ];
    }

}
