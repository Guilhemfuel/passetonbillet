<?php

namespace App\Listeners\Admin\Warnings;

use App\Events\TicketAddedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Some sellers put ticket on sale for a very cheap price (usually 1), to then be able to negotiate and ask for
 * a price higher than original. This listener created admin warning when that happens.
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
     * @param  object  $event
     * @return void
     */
    public function handle(TicketAddedEvent $event)
    {

    }
}
