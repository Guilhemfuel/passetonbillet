<?php

return [

    'optico' => [
        'paid_phone_url' => env( 'OPTICO_PAID_PHONE_URL', 'https://www.optico.fr/ospClick​​' ),
        'api_key'        => env( 'OPTICO_API_KEY' ),
    ],

    'sncf_affiliate' => [
        'url'     => env( 'SNCF_AFFILIATE_URL', 'https://api.oui.sncf/ftc/proposals/v4/{departure}/{arrival}/{date}/1' ),
        'api_key' => env( 'SNCF_AFFILIATE_API_KEY' ),
    ]
];