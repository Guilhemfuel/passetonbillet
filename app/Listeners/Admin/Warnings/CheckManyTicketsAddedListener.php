<?php

namespace App\Listeners\Admin\Warnings;

use App\Events\TicketAddedEvent;
use App\Models\AdminWarning;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class CheckManyTicketsAddedListener
 * @package App\Listeners\Admin\Warnings
 *
 * A fraudulent users can suddenly put a lot of tickets on sale, just after creating an account. New users usually
 * add one or two tickets (with return ticket). If a new user post more than 2 tickets, admins should check that he
 * does not look suspicious.
 */
class CheckManyTicketsAddedListener implements ShouldQueue
{

    const NB_TICKETS_LIMIT_FOR_RECENT_USERS = 2;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TicketAddedEvent $event)
    {
        $ticket = $event->ticket;
        if (!$ticket) {
            return;
        }

        $user = $ticket->user;
        if (!$user) {
            return;
        }

        // Now check if it's a new user (no ticket sold), but more than two tickets selling
        if ( $user->is_recent && $user->tickets->count() > self::NB_TICKETS_LIMIT_FOR_RECENT_USERS) {
            AdminWarning::create( [
                'action' => AdminWarning::MANY_TICKETS_NEW_USER,
                'link'   => route( 'users.edit', $ticket->user_id ),
                'data'   => [
                    'user_id' => $ticket->user_id,
                    'message' => 'This recent user added many tickets.',
                ]
            ] );
        }
    }
}
