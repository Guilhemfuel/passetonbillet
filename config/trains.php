<?php

return [

    'eurostar' => [
        // New eurostar api
        'booking_url'           => env( 'EUROSTAR_BOOKING', 'https://api.prod.eurostar.com/mobile/bookings/bookingDetails/GBZXA/' ),
        'pdf_url'               => env( 'EUROSTAR_PDF', 'https://api.prod.eurostar.com/etap/bookings/' ),
        'auth_booking_url'      => env( 'EUROSTAR_AUTH_BOOKING', 'https://api.prod.eurostar.com/etap/bookings/auth/authenticate?pos=GBZXA' ),
        'update_passengers_url' => env( 'EUROSTAR_AUTH_BOOKING', 'https://api.prod.eurostar.com/etap/bookings/{booking_code}/passengers' ),

        'api_key'     => env( 'EUROSTAR_API_KEY' ),
        'api_key_web' => env( 'EUROSTAR_API_KEY_WEB' )
    ],

    'sncf' => [
        'booking_url' => env( 'SNCF_BOOKING', 'https://en.oui.sncf/vsa/api/order/{country}/{name}/{booking_code}?source=vsa' ),
        'pdf_url'     => env( 'SNCF_PDF', 'https://ebillet.voyages-sncf.com/ticketingServices/public/e-ticket/' )
    ],

    'thalys' => [
        'booking_url'     => env( 'THALYS_BOOKING', 'https://www.thalys.com/api/svoc_tickets/search?PNR={pnr}&LastName={name}' ),
    ]
];