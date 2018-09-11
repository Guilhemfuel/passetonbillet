<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nav Language Lines
    |--------------------------------------------------------------------------
    */

    'component' => [
        'buy'                    => 'Buy',
        'sell'                   => 'Sell this ticket',
        'sold_by'                => 'Published {{days}} ago by',
        'edit'                   => 'Edit',
        'edit_ticket'            => 'Edit ticket',
        'buy_ticket'             => 'Buy ticket',
        'your_offer'             => 'Your offer',
        'price'                  => 'Price',
        'send_offer'             => 'Send offer',
        'if_interested'          => 'The seller will contact you soon if interested.',
        'infos'                  => 'Infos',
        'booking_code'           => 'Booking code',
        'booking_name'           => 'Booking name',
        'delete'                 => 'You don\'t want to sell this ticket anymore?',
        'share'                  => 'Link to share this ticket',
        'copied'                 => 'Link copied to clipboard.',
        'delete_cta'             => 'Remove ticket',
        'offer_sent'             => 'Seller received your offer! If interested, he\'ll contact you.',
        'register'               => 'Safety is our number one concern. Therefore, you must create an account before sending offers.',
        'register_cta'           => 'Create an account and send your offer!',
        'user_verified'          => 'We verified the identity of this user.',
        'user_not_verified'      => 'We have not verified the identity of this user yet.',
        'discuss'                => 'Discuss',
        'new_offer'              => 'New Offer',
        'download_ticket'        => 'Download Ticket',
        'download'               => 'Download',
        'eurostar_ticket_number' => 'Ticket number',


        'status' => [
            'awaiting' => 'Awaiting',
            'accepted' => 'Accepted',
            'refused'  => 'Refused'
        ],


    ],
    'sell'      => [
        'title' => 'Sell a ticket',

        'step_1'            => 'Step 1/2: find your ticket',
        'description'       => 'Selling a ticket is very easy and super quick. All we need to do is to enter your name and your booking code. All the tickets corresponding to your specific booking will appear and you only have to select those that you want to sell.',
        'inputs'            => [
            'last_name'    => 'Last name of any passenger',
            'booking_code' => 'Booking code, eg: QNUSHT',
            'price'        => 'Selling price',
            'notes'        => 'Your can write notes here about this ticket...'
        ],
        'search'            => 'Search for ticket(s)',
        'other_name'        => 'Contact us to sell a ticket with another name.',
        'help_booking_code' => 'This code can be found on your booking/order confirmation email, after "Booking Reference" or "PNR", and is 6 characters long.',
        'searching'         => 'Searching for your tickets...',
        'select'            => 'Hooray ! We found your tickets. Select the ticket you want to sell.',
        'step_2'            => 'Step 2/2: Fill selling details',
        'details'           => 'We\'re almost done! Just enter your selling price. Note that selling price can\'t exceed original price. You can preview your changes directly on the ticket.',
        'submit'            => 'Sell ticket',
        'preview'           => 'Ticket Preview',
        'errors'            => [
            'max_value' => 'Whoops! Selling price can\'t exceed original price ! Try again with a lower price.',
            'duplicate' => 'Whoops! This ticket is already on sale...',
            'search'    => 'Whoops! No tickets were found... Try again and if the issue persists please contact us.'
        ],
        'success'           => 'Hooray! Your ticket is now on the market ! Thank you for your trust !',

        'confirm_number' => [
            'last_step'        => 'One last step! Because safety is our number one mission, we need to verify your phone number. We will send you a verification code via a text message, and you\'ll then be able to sell your ticket!',
            'code_check'       => 'Type the code you received in the text message we sent you. You\'ll then be able to start selling tickets!',
            'CTA'              => 'Verify my phone number',
            'no_code_received' => 'You didn\'t receive a verification code? Click here',

            'errors'  => [
                'phone_already_used'     => 'Phone number already used by another user. Please contact us.',
                'phone_already_verified' => 'Your phone number was already verified! Please contact us to change it.',
                'verify_max_retry'       => 'You already tried to verify your number 3 times. Please contact us to solve the problem.',
                'no_verification_found'  => 'We didn\'t find any phone number to validate with this code... Please contact us to solve the problem.',

            ],
            'success' => [
                'code_sent'        => 'A text message with a validation code was sent to your number.',
                'number_confirmed' => 'Success! Your phone number is confirmed. You can now sell your tickets!'
            ]
        ],

        'manual' => [
            'link'           => 'You don\'t have a booking code? Click here to manually fill your ticket details.',
            'title'          => 'Your Ticket Details',
            'fail_retrieval' => [
                'title'   => 'No tickets found with this booking code.',
                'message' => 'Unfortunately, we couldn\'nt find any ticket with this booking code. You can manually fill the details regarding your ticket on this page. Click on this message if you wish to retry finding your ticket with your booking code.'
            ],
            'text'           => "If you wish to sell a print-at-station ticket, or if we couldn't retrieve your ticket with your booking code, you simply have to fill this form.",
            'back_link'      => 'You have your booking code? Click here to automatically retrieve your ticket!',

            'form' => [
                'title_travel'      => 'Travel information',
                'departure_station' => 'Departure station',
                'arrival_station'   => 'Arrival station',
                'travel_date'       => 'Travel date',
                'train_number'      => 'Train number',
                'departure_time'    => "Departure time",
                'arrival_time'      => "Arrival time",
                'title_ticket'      => 'Ticket information',
                'company'           => 'Train company',
                'flexibility'       => 'Flexibility',
                'classe'            => 'Class',
                'currency'          => 'Currency',
                'bought_price'      => 'Buying price',
                'price'             => 'Selling price',
                'cgu'               => 'I have read and accept the <a href="' . route( 'cgu.page' ) . '" target="blank" >general terms and conditions</a>. I swear that I\'m not making any profit selling this ticket.'

            ]

        ]

    ],
    'buy'       => [
        'inputs'         => [
            'trippicker'     => [
                'departure_station' => 'Departure station',
                'arrival_satation'  => 'Arrival station',
            ],
            'datetimepicker' => [
                'trip_date' => 'Travel date',
                'trip_time' => 'From (Optional)'
            ],
            'homepicker'     => [
                'depart'  => 'From',
                'arrival' => 'To'
            ]
        ],
        'title'          => 'Buy a ticket',
        'catchline'      => 'What is your journey?',
        'research'       => 'Search',
        'search_result'  => 'ticket(s) match your criteria.',
        'safety'         => 'Safety is our number one concern! You must register to sell one of your tickets!',
        'create_account' => 'Create a Ptb account'
    ],
    'owned'     => [
        'no_bought_tickets'      => 'You have not bought any tickets yet!',
        'no_bought_tickets_cta'  => 'Click here to buy a ticket.',
        'no_sold_tickets'        => 'You have not sold any tickets yet!',
        'no_sold_tickets_cta'    => 'Click here to sell a ticket.',
        'no_selling_tickets'     => 'You are not selling any ticket yet!',
        'no_selling_tickets_cta' => 'Click here to sell a ticket.',
        'no_offered_tickets'     => 'You have not sent any offer yet!',
        'no_offered_tickets_cta' => 'Click here to buy a ticket.',
        'bought'                 => 'Bought',
        'sold'                   => 'Sold',
        'selling'                => 'Selling',
        'offers_sent'            => 'Offers Sent',
    ],
    'delete'    => [
        'success' => 'Your ticket was successfully deleted.'
    ],
    'errors'    => [
        'passed' => 'This ticket is already passed.'
    ]


];
