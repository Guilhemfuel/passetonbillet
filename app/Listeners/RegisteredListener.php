<?php

namespace App\Listeners;

use App\Events\RegisteredEvent;
use App\Helper\AppHelper;
use App\Mail\EmailVerification;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class RegisteredListener implements ShouldQueue
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  RegisteredEvent  $event
     * @return void
     */
    public function handle(RegisteredEvent $event)
    {
        // Send verification email
        \Mail::to( $event->user )->send( new EmailVerification( $event->user ) );

        // Store event and IP
        \AppHelper::stat( 'register', [
            'source' => $event->source,
            'ip_address' => $event->ip
        ],$event->user );
    }

}
