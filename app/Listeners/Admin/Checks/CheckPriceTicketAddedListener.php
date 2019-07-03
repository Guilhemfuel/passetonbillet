<?php

namespace App\Listeners\Admin\Checks;

use App\Events\TicketAddedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Some sellers put ticket on sale for a very cheap price (usually 1), to then be able to negotiate and ask for
 * a price higher than original. This listener automatically changes back the price to original price when that happens.
 *
 * Class CheckPriceTicketAddedListener
 * @package App\Listeners\Admin\Warnings
 */
class CheckPriceTicketAddedListener implements ShouldQueue
{
    const TICKET_WARNING_PRICE = 5;

    /**
     * Handle the event.
     *
     * @param  object $event
     *
     * @return void
     */
    public function handle( TicketAddedEvent $event )
    {
        // Check if lower than warning, and lower than original price
        $ticket = $event->ticket;

        if ( $ticket
             && $ticket->price <= self::TICKET_WARNING_PRICE
             && $ticket->price < $ticket->bought_price
        ) {
            $ticket->price = $ticket->bought_price;
            $ticket->save();
        }
    }
}
