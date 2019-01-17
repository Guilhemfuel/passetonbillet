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
        'base_url'        => env( 'THALYS_BASE_URL', 'https://www.thalys.com/' ),
        'booking_url'     => env( 'THALYS_BOOKING', 'https://www.thalys.com/?ajax=Services_PopinRecuperation' ),
        'prepare_pdf_url' => env( 'THALYS_PREPARE_PDF_URL', 'https://www.thalys.com/?ajax=Services_LoadTicketPage&ticket={ticket_id}&pnr={reference}&name={name}' ),
        'pdf_url'         => env( 'THALYS_PDF_URL', 'https://www.thalys.com/fr/en/services-print-ticket' ),
    ]
];