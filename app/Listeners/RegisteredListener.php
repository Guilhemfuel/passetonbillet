<?php

namespace App\Listeners;

use App\Events\RegisteredEvent;
use App\Mail\EmailVerification;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisteredListener implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param  RegisteredEvent  $event
     * @return void
     */
    public function handle(RegisteredEvent $event)
    {
        \Mail::to($event->user)->send(new EmailVerification($event->user));
    }
}
