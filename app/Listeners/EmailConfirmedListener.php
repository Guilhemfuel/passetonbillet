<?php

namespace App\Listeners;

use App\Events\EmailConfirmedEvent;
use App\Mail\WelcomeEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailConfirmedListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EmailConfirmedEvent $event)
    {
        // Send welcome email
        \Mail::to( $event->user )->send( new WelcomeEmail( $event->user ) );
    }
}
