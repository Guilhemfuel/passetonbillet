<?php

namespace App\Listeners;

use App\Events\TicketAddedEvent;
use App\Mail\AlertEmail;
use App\Models\Alert;
use App\Notifications\AlertNotification;
use App\Station;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DispatchAlertsListener implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param  object $event
     *
     * @return void
     */
    public function handle( TicketAddedEvent $event )
    {
        $ticket = $event->ticket;


        $departureStationId = $ticket->train->departure_city;
        $arrivalStationId = $ticket->train->arrival_city;

        $departureStationParentId = Station::find( $departureStationId )->parent_station_id;
        $arrivalStationParentId = Station::find( $arrivalStationId )->parent_station_id;

        // Create array of possible departure stations
        if ( $departureStationParentId != null ) {
            $departureStations = Station::where( 'parent_station_id', $departureStationParentId )->pluck( 'id' );
            $departureStations[] = intval( $departureStationParentId );
        } else {
            $departureStations = Station::where( 'parent_station_id', $departureStationId )->pluck( 'id' );
            $departureStations[] = intval( $departureStationId );
        }

        // Create array of possible arrival stations
        if ( $arrivalStationParentId != null ) {
            $arrivalStations = Station::where( 'parent_station_id', $arrivalStationParentId )->pluck( 'id' );
            $arrivalStations[] = intval( $arrivalStationParentId );
        } else {
            $arrivalStations = Station::where( 'parent_station_id', $arrivalStationId )->pluck( 'id' );
            $arrivalStations[] = intval( $arrivalStationId );
        }

        // Search for matching alerts
        $alerts = Alert::whereDate( 'travel_date_start', '<=', $ticket->train->carbon_departure_date )
                       ->whereDate( 'travel_date_end', '>=', $ticket->train->carbon_departure_date )
                       ->whereIn( 'departure_city', $departureStations )
                       ->whereIn( 'arrival_city', $arrivalStations )
                       ->get();

        if (\App::environment()=='local') {
            \Log::info('Skipping alerts dispatching as not local.');
            return;
        }

        foreach ( $alerts as $alert ) {

            // If it's a user create notification
            if ( $alert->user ) {
                $alert->user->notify( new AlertNotification( $alert, $ticket->train ) );
            } else {
                \Notification::route( 'mail', $alert->email )->notify( new AlertNotification( $alert, $ticket->train ) );
            }
        }
    }
}
