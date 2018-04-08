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
        'cta_sell_to'     => 'Sell this ticket to',
        'cancel'          => 'Cancel',

        'explanation_buyer'  =>'Reminder: the purpose of the chat is for the buyer and the seller to agree on the best payment method. You will receive the ticket as soon as the seller will have received the money.',

        'modal_sell' => [
            'part_1' => 'You are about to send this ticket to',
            'part_2' => 'Make sure to click there, only once you received the payment.',
            'part_3' => 'will then automatically receive your ticket.',
        ]


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
