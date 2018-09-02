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
        'accept'                 => 'Accept',
        'deny'                   => 'Deny'
    ],

    'discussions' => [
        'title'           => 'Discussions',
        'send'            => 'Send',
        'sold_to_so_else' => 'Ticket already sold to someone else!',
        'sold_disc_ended' => 'Ticket was sold to someone else. The discussion ended.',
        'bought_from'     => 'You bought this ticket from',
        'sold_to'         => 'You sold this ticket to',
        'cta_sell_to'     => 'Transaction Done',
        'cancel'          => 'Cancel',

        'modal_title' => 'How does it work?',
        'modal_explanation_buyer' => 'The unique purpose of the chat is for you and the buyer to agree on the best payment method and to share the relevant payment information.<br>
                        Once you receive the money from the buyer, you must send the ticket through the agreed method. You then only have to click on the button "Transaction Done"!',
        'modal_explanation_seller' => 'The unique purpose of the chat is for you and the seller to agree on the best payment method and to share the relevant payment information.<br>
                        Once the seller receives your payment, she/he will will send you the ticket through the agreed method. The seller wil then have to click on the "Transaction Done" button, and we\'ll mark this ticket as sold.',
        'modal_open_chat'          => 'A question? A doubt? Click here to chat with us!',
        'modal_close_understand'   => 'I understand !',

        'disclaimer'  => 'Passe Ton Billet is only designed to put you in contact with tickets buyers and sellers. Passe Ton Billet denies every responsability related to the transaction.',

        'modal_sell' => [
            'part_1' => 'You are about to mark this ticket as sold to',
            'part_2' => 'Make sure to click there, only once you received the payment and sent the ticket.',
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
                'third_part'  => 'will then automatically receive your ticket'
            ]
        ]
    ]


];
