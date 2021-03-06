<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nav Language Lines
    |--------------------------------------------------------------------------
    */

    'component' => [
        'buy'                       => 'Buy',
        'contact'                   => 'Contact',
        'details'                   => 'Details',
        'call'                      => 'Call',
        'sell'                      => 'Sell this ticket',
        'sold_by'                   => 'Published {{days}} ago by',
        'sold_ago'                  => 'Published <b>{{days}}</b> ago',
        'sold_by_sm'                => 'Published by',
        'edit'                      => 'Edit',
        'edit_ticket'               => 'Edit ticket',
        'buy_ticket'                => 'Buy ticket',
        'your_offer'                => 'Your offer',
        'seller_ticket_sold'        => 'Ticket(s)<br>sold',
        'seller_ticket_sold_mobile' => 'Ticket(s) sold',
        'member_since'              => 'Member<br>since',
        'member_since_mobile'       => 'Member since',
        'price'                     => 'Price',
        'send_offer'                => 'Send offer',
        'if_interested'             => 'The seller will contact you soon if interested.',
        'infos'                     => 'Infos',
        'booking_code'              => 'Booking code',
        'booking_name'              => 'Booking name',
        'delete'                    => 'You don\'t want to sell this ticket anymore?',
        'share'                     => 'Link to share this ticket',
        'share_btn'                 => 'Share',
        'copied'                    => 'Link copied to clipboard.',
        'edit_price_cta'            => 'Change Price',
        'delete_cta'                => 'Remove ticket',
        'offer_sent'                => 'Seller received your offer! If interested, he\'ll contact you.',
        'register'                  => 'Safety first !',
        'register_cta'              => 'Please click here to create an account and send your offer!',
        'user_verified'             => 'We verified the identity of this user.',
        'user_verification_pending' => 'We are currently veryfing the identity of this user.',
        'user_not_verified'         => 'We have not verified the identity of this user yet.',
        'discuss'                   => 'Discuss',
        'new_offer'                 => 'New Offer',
        'download_ticket'           => 'Download Ticket',
        'download'                  => 'Download',
        'eurostar_ticket_number'    => 'Ticket number',
        'security_infos'            => 'Security details',

        'status' => [
            'awaiting' => 'Awaiting',
            'accepted' => 'Discuss',
            'refused'  => 'Refused'
        ],

        'security' => [
            'identity'      => [
                'verified'     => 'ID verified',
                'pending'      => 'ID check pending',
                'not_verified' => 'ID not verified'
            ],
            'tickets_sold'  => 'Ticket(s) sold',
            'register_date' => 'Registration date'
        ],

        'buying_actions' => [
            'offer' => [
                'btn'          => 'Send an offer',
                'back_to_call' => 'Direct Call'
            ],
            'call'  => [
                'btn'     => 'Direct Call',
                'refresh' => 'Refresh Number',
                'pricing' => '3€/call + price for the call',
            ]
        ],

        'help_modal' => [
            'title' => 'Which option should I choose ?',
            'offer' => [
                'title'   => 'Take your time, there are a lot of other tickets !',
                'content' => 'The seller will receive your offer via email and he/she will be able to accept or deny it. You’ll only be able to talk to the seller through our chat if your offer is accepted.'
            ],
            'call'  => [
                'title'   => 'Don’t miss out on your ideal ticket !',
                'content' => 'You can now directly call the seller and negociate the ticket. This is much more efficient !'
            ]
        ],

        'share_modal' => [
            'title'        => 'Sell your ticket much faster by publishing it on facebook!',
            'step_1'       => '1. Share the ticket with your friends on your facebook account',
            'step_2'       => '2. Publish it on our facebook group ',
            'share_on_fb'  => 'Share it on facebook',
            'text_link'    => 'Your direct sharing link',
            'copy_link'    => 'Copy Link',
            'our_fb_group' => 'Post your direct sharing link on our group: '
        ],

        'delete_modal' => [
            'already_sold'         => [
                'text_offers'     => 'Have you already sold your ticket? Awesome! Please let us know who\'s the buyer, so that we can mark your ticket as sold.
                    If you click on "I sold this ticket somewhere else", your ticket will be completely removed from PasseTonBillet.',
                'text_no_offers'  => 'You have not accepted any offers yet for this ticket. Click on "I sold this ticket somewhere else" to completely remove this ticket from PasseTonBillet.',
                'sold_to'         => 'Sold to',
                'sold_else_where' => 'I sold this ticket somewhere else',
            ],
            'sold_else_where'      => [
                'text'               => 'If you sold this ticket on PasseTonBillet, <b>DO NOT CLICK</b> the button below and please let us know who did you sell it to.
                This will help us manage status of currenct transactions, and more importantly it will <b>increase your reputation</b> on PasseTonBillet!
                Indeed, The number of tickets you successfully sold that is displayed on your profile, will increase 👍',
                'sold_on_ptb_button' => 'Whoops, I sold this ticket to someone else on PasseTonBillet',
                'sold_else_where'    => 'I confirm that I sold this ticket somewhere else',
            ],
            'not_for_sale_anymore' => [
                'text'               => 'If you sold this ticket on PasseTonBillet, <b>DO NOT CLICK</b> the button below and please let us know who did you sell it to.
                This will help us manage status of currenct transactions, and more importantly it will <b>increase your reputation</b> on PasseTonBillet!
                Indeed, The number of tickets you successfully sold that is displayed on your profile, will increase 👍',
                'sold_on_ptb_button' => 'Whoops, I sold this ticket to someone else on PasseTonBillet',
                'confirm_button'     => 'I don\'t want to sell this ticket anymore'
            ],
            'find_reason'          => [
                'text'                => 'Do you really wish to delete this ticket? If so, please let us know why!',
                'already_sold_button' => 'I have already sold this ticket',
                'not_for_sale_button' => 'I don\'t want to sell this ticket anymore'
            ],
            'cancel_button'        => 'Whoops, I don\'t want to remove it'
        ],

        'call_seller_modal' => [
            'title'      => 'Call Seller',
            'text'       => 'You can call the seller to negotiate the ticket straight away. It\'s much faster ! Click on the button corresponding to the country of your mobile carrier to get a contact number.',
            'btn_cta'    => 'Get Number',
            'refresh'    => 'Refresh Number',
            'pricing_fr' => '3€/call + call price',
            'pricing_uk' => '2.5£/call + call price',
        ],

        'edit_price_modal' => [
            'title'  => 'Edit price of your ticket',
            'text'   => 'You can change the price of your ticket at any moment.',
            'submit' => 'Save Price'
        ],

        'type' => [
            'second_hand' => "second hand<br/> train ticket",
            'new'         => "new<br/> train ticket"
        ]

    ],
    'sell'      => [
        'title' => 'Sell a ticket',

        'public' => [
            'title'            => 'Resell SNCF, OuiGo, Eurostar, or Thalys train tickets on PasseTonBillet.fr',
            'meta_description' => 'You have a train ticket to resell (Billet SNCF, Prems, e-billet, Eurostar, Thalys...). On PasseTonBillet.fr, you will sell it in less than a day ! It\'s fast and free.',
            'subtitle'         => 'We currrently support all major ticket types, including SNCF, Eurostar, Prems, Thalys, and OuiGo',
            'favorites'        => [
                'title'    => 'Sell you ticket in 1 click',
                'subtitle' => 'Sell a ticket from London, Paris, Marseille, Lyon, or any where else.'
            ],
            'reviews'          => 'Our reviews',
            'recent'           => 'Recent tickets',
            'question'         => 'Do you have a non-exchangeable/non-refundable train ticket to resell?',
            'subquestion'      => 'PasseTonBillet.fr specialises in the resale of used train tickets. With PasseTonBillet, passengers can easily: ',
            'video_title'      => 'Selling tickets at PasseTonBillet'
        ],

        'step_1'            => 'Step 1/2: find your ticket',
        'description'       => 'Selling a ticket is very easy and super quick. All we need to do is to enter your name and your booking code. All the tickets corresponding to your specific booking will appear and you only have to select those that you want to sell.',
        'inputs'            => [
            'first_name'   => 'First Name of any passenger',
            'last_name'    => 'Last name of any passenger',
            'email'        => 'Email used for the booking',
            'booking_code' => 'Booking code',
            'price'        => 'Selling price',
            'notes'        => 'Your can write notes here about this ticket...'
        ],
        'search'            => 'Search for ticket(s)',
        'other_name'        => 'Contact us to sell a ticket with another name.',
        'help_booking_code' => 'This code can be found on your booking/order confirmation email, after "Booking Reference" or "PNR", and is 6 characters long.',
        'searching'         => 'Searching for your tickets...',
        'select'            => 'Hooray ! We found your tickets. Select the ticket you want to sell.',
        'step_2'            => 'Step 2/2: Fill selling details',
        'details'           => 'We\'re almost done! Just enter your selling price. You can preview your changes directly on the ticket.',
        'submit'            => 'Sell ticket',
        'preview'           => 'Ticket Preview',
        'errors'            => [
            'min_value'       => 'Whoops! Selling price can\'t be lower than 1 ! Try again with a higher price.',
            'manual_eurostar' => 'Whoops! You can\'t use the manual form to sell eurostar tickets.',
            'duplicate'       => 'Whoops! This ticket has already been published once. Contact us if you wish to publish it again.',
            'search'          => 'Whoops! No tickets were found... Try again and if the issue persists please contact us.'
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
                'title'                => 'No tickets found with this booking code.',
                'message'              => 'Unfortunately, we couldn\'nt find any ticket with this booking code.',
                'message_extra_fields' => 'We could\'nt find your ticket. Let us know the email address you used for the booking and try again.',
            ],
            'text'           => "If you wish to sell a print-at-station ticket, or if we couldn't retrieve your ticket with your booking code, you simply have to fill this form.",
            'back_link'      => 'You have your booking code? Click here to automatically retrieve your ticket!',

            'eurostar_back_to_automatic' => 'Please use the automatic form to sell a Eurostar ticket.',

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
                'cgu'               => 'I have read and accept the <a href="' . route( 'cgu.page' ) . '" target="blank" >general terms and conditions</a>.'

            ]

        ],

        'eurostar_warning_fb_group' => [
            'title'   => '<span class="text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><br> Warning: do not post your Eurostar® ticket on Facebook groups !</span>',
            'message' => 'Eurostar® now checks all the tickets published on ALL Facebook groups. 
            If your post can be linked to your Eurostar® booking via Facebook name and the content of your publication,
             then your ticket may be cancelled, without any possible refund.<br><br>
             PasseTonBillet cannot be held responsible if your ticket is cancelled.',
            'button'  => "I understood and I will not post my ticket on Facebook"
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
        'title'                  => 'My Tickets',
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
    'alerts'    => [

        'page' => [
            'title'          => 'My Alerts',
            'btn_create_new' => 'Click here to create a new Alert'
        ],

        'create_alert'   => 'Create an alert',
        'catchline_text' => 'Tired of missing the perfect ticket ?',
        'action_text'    => 'Create an alert and be the first to know !',

        'modal'          => [
            'title'       => 'Create an alert',
            'form'        => [
                'departure_station'    => 'Departure Station',
                'arrival_station'      => 'Arrival Station',
                'departure_date_start' => 'Alert start date',
                'departure_date_end'   => 'Alert end date',
            ],
            'explanation' => 'Create an alert now, and receive email notifications whenever a user publishes a ticket that matches your criterias.',
            'submit'      => 'Create Alert'
        ],
        'success'        => 'Success ! Alert created !',
        'success_delete' => 'Alert deleted.',

        'duplicate_alert' => 'You already have this alert set.',
        'past_alert'      => 'You can\'t create an alert in the past.',
        'date_order'      => 'Start date must be before or equal to end date.',
        'alert_not_found' => 'Alert not found.',
        'existing_user'   => 'You already have a PasseTonBillet account. Please login to create an alert.',

    ],
    'updated'   => 'Ticket successfully updated.',
    'delete'    => [
        'success' => 'Your ticket was successfully deleted.'
    ],
    'errors'    => [
        'passed' => 'This ticket is already passed.'
    ]


];
