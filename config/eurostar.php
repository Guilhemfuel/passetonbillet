<?php

return [

    // New eurostar api
    'booking_url' => env( 'EUROSTAR_BOOKING', 'https://api.prod.eurostar.com/mobile/bookings/bookingDetails/GBZXA/' ),
    'pdf_url'     => env( 'EUROSTAR_PDF', 'https://api.prod.eurostar.com/etap/bookings/' ),

    'api_key'     => env( 'EUROSTAR_API_KEY' ),
    'api_key_web' => env( 'EUROSTAR_API_KEY_WEB' )

];