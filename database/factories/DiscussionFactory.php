<?php

use Faker\Generator as Faker;

$factory->define( App\Models\Discussion::class, function ( Faker $faker ) {
    $ticket = factory( App\Ticket::class )->create();
    $user = factory( App\User::class )->create();

    return [
        'ticket_id' => $ticket->id,
        'buyer_id'  => $user->id,
        'status'    => \App\Models\Discussion::AWAITING,
        'price'     => $ticket->price,
        'currency'  => $ticket->currency,
    ];
} );
