<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Message Language Lines
    |--------------------------------------------------------------------------
    */

    'empty' => 'You don\'t have any message yet!',

    'awaiting_offers' => [
        'title'                  => 'Awaiting offers',
        'confirm_denial_message' => 'This offer was successfully denied.',
        'confirm_accept'         => 'Offer accepted! Start discussing details now.',
        'accept'                 => 'Discuss',
        'deny'                   => 'Deny',

        'table' => [
            'ticket'  => 'Ticket',
            'buyer'   => 'Buyer Name',
            'price'   => 'Price',
            'actions' => 'Actions'
        ],

        'deny_modal' => [
            'title' => 'Deny an offer',
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
                'text'                => 'Do you really wish to deny this offer? If so, please let us know why!',
                'low_price_button'    => 'Price is too low',
                'already_sold_button' => 'I have already sold this ticket',
                'not_for_sale_button' => 'I don\'t want to sell this ticket anymore'
            ],
            'cancel_button'        => 'Whoops, I don\'t want to deny this offer'
        ]
    ],

    'discussions' => [
        'title'           => 'Discussions',
        'send'            => 'Send',
        'sold_to_so_else' => 'Ticket already sold to someone else!',
        'sold_disc_ended' => 'Ticket was sold to someone else. The discussion ended.',
        'bought_from'     => 'You bought this ticket from',
        'sold_to'         => 'You sold this ticket to',
        'cta_sell_to'     => 'Sold to',
        'showPastBuying' => 'Show past buying discussions',
        'showPastSelling' => 'Show past selling discussions',
        'showCurrentBuying' => 'Show current buying discussions',
        'showCurrentSelling' => 'Show current selling discussions',
        'cancel'          => 'Cancel',

        'table' => [
            'ticket'       => 'Ticket',
            'buyer'        => 'Name',
            'last_message' => 'Last Message',
        ],

        'modal_title'              => 'How does it work?',
        'modal_explanation_buyer'  => 'The unique purpose of the chat is for you and the buyer to agree on the best payment method and to share the relevant payment information.<br>
                        Once you receive the money from the buyer, you must send the ticket through the agreed method. You then only have to click on the button "Transaction Done"!',
        'modal_explanation_seller' => 'The unique purpose of the chat is for you and the seller to agree on the best payment method and to share the relevant payment information.<br>
                        Once the seller receives your payment, she/he will will send you the ticket through the agreed method. The seller wil then have to click on the "Transaction Done" button, and we\'ll mark this ticket as sold.',
        'modal_open_chat'          => 'A question? A doubt? Click here to chat with us!',
        'modal_close_understand'   => 'I understand !',

        'disclaimer'          => 'Passe Ton Billet is only designed to put you in contact with tickets buyers and sellers. Passe Ton Billet denies every responsability related to the transaction.',
        'disclaimer_eurostar' => 'Identity check may happen rarely for eurostar tickets. If the name on the provided ID does not match with the name on the ticket, access to train may be refused.',


        'modal_sell' => [
            'part_1' => 'You are about to mark this ticket as sold to',
            'part_2' => 'Make sure to click there, only once you received the payment and sent the ticket.',
            'important'=> [
                'title' => 'IMPORTANT',
                'text' => 'Please you make sure you receive the funds on your account. A simple screenshot or a confirmation email is not enough!'
            ]
        ],

    ],

    'success' => [
        'sold' => 'Your ticket was successfully sold! Thank you for your trust.'
    ],

    'errors' => [
        'not_found'               => 'Discussion not found.',
        'ticket_not_found'        => 'Ticket not found',
        'cant_accept'             => 'Offer can\'nt be accepted',
        'not_active'              => 'This conversation is not active',
        'wrong_user'              => 'This discusssion is not yours!',
        'wrong_ticket_discussion' => 'The match ticket-discussion failed.',
        'something'               => 'Something went wrong.',
        'already_sold'            => 'Ticket is already sold by seller!'
    ],

    'discussion_page' => [
        'modals' => [
            'sell' => [
                'first_part'  => 'You are about to mark this ticket as sold to',
                'secund_part' => 'Make sure to click there only once you received the payment',
            ]
        ]
    ]


];
