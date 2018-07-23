<?php

return [

    'eurostar' => [
        // New eurostar api
        'booking_url' => env( 'EUROSTAR_BOOKING', 'https://api.prod.eurostar.com/mobile/bookings/bookingDetails/GBZXA/' ),
        'pdf_url'     => env( 'EUROSTAR_PDF', 'https://api.prod.eurostar.com/etap/bookings/' ),

        'api_key'     => env( 'EUROSTAR_API_KEY' ),
        'api_key_web' => env( 'EUROSTAR_API_KEY_WEB' )
    ],

    'sncf' => [
        'booking_url' => env('SNCF_BOOKING','https://en.oui.sncf/vsa/api/order/en_US/{name}/{booking_code}?source=vsa')
    ]
];