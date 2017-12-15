<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nav Language Lines
    |--------------------------------------------------------------------------
    */

    'component' => [
        'buy'     => 'Buy',
        'sell'    => 'Sell this ticket',
        'sold_by' => 'Sold by'
    ],
    'sell'      => [
        'title'         => 'Sell a ticket',
        'description'   => 'Selling a ticket is super simple and super fast. All we need is your name and your eurostar booking code. We will search for tickets corresponding with this reservation, and we will only save the one you will select.',
        'inputs'        => [
            'last_name'    => 'Last name of any passenger',
            'booking_code' => 'Booking code, eg: QNUSHT',
            'price'        => 'Selling price',
            'notes'        => 'Your can write notes here about this ticket...'
        ],
        'search'        => 'Search for ticket(s)',
        'searching'     => 'Searching for your tickets...',
        'your_tickets'  => 'Your tickets',
        'select'        => 'Hooray ! We find your tickets. Select the ticket you want to sell.',
        'details_title' => 'Ticket details',
        'details'       => 'We\'re almost done! Just put your price price, and if needed add notes. Note that selling price can\'t exceed original price. You can preview your changes directly on the ticket.',
        'submit'        => 'Sell ticket',
        'preview'       => 'Ticket Preview',
        'errors'        => [
            'max_value' => 'Whoops! Selling price can\'t exceed original price.',
            'duplicate' => 'Whoops! This ticket is already on sale...',
            'search'    => 'Whoops ! No tickets were found... Try again and if the issue persists please contact us.'
        ],
        'success'       => 'Hooray! Your ticket is now on the market ! Thank you for your trust !',

        'confirm_number' => [
            'last_step'  => 'One last step! Because safety is our mission number one, we need to verify your phone number. We will send you a code via a text message, and you\'ll then be able to sell your ticket!',
            'code_check' => 'Type the code you received in the text message we sent you. You\'ll then be able to start selling tickets!',
            'CTA'        => 'Verify my phone number',
            'no_code_received' => 'You didn\'t receive a code? Click here',

            'errors' => [
                'phone_already_used' => 'Phone number already used by another user. Please contact an admin.',
                'phone_already_verified' => 'Your phone number was already verified! Contact an admin to change it.',
                'verify_max_retry' => 'You already tried to verify your number 3 times. Please contact an admin.',
                'no_verification_found' => 'We didn\'t find any phone number to validate with this code...',

            ],
            'success' => [
                'code_sent' => 'A text message with a validation code was sent to your number.',
                'number_confirmed' => 'Success! Your phone number is confirmed. You can now sell tickets!'
            ]
        ]
    ],
    'buy'   => [
        'inputs' => [
            'trippicker' => [
                'departure_station' => 'Departure station',
                'arrival_satation' => 'Arrival station',
            ],
            'datetimepicker' => [
                'trip_date' => 'Travel date',
                'trip_time' => '(Optional) From'
            ]
        ],
        'title' => 'Buy a ticket',
        'catchline' => 'What is your journey?',
        'research' => 'Research'
    ]


];
