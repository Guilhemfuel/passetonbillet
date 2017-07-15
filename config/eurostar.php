<?php

return [

    'trains_url'  => env( 'EUROSTAR_TRAINS', "https://m.eurostar.com/api/mob/fr-fr/booking/proposals" ),
    'booking_url' => env( 'EUROSTAR_BOOKING', 'https://m.eurostar.com/api/v2/mob/fr-fr/booking/retrieve' ),
    'ticket_type' => env( 'EUROSTAR_TICKET', 'https://m.eurostar.com/api/mob/fr-fr/refdata/tickets.json' ),
    'stations'    => env( 'EUROSTAR_STATIONS', 'https://m.eurostar.com/api/mob/fr-fr/refdata/stations' ),

];