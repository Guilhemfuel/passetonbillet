<?php

namespace App\Listeners;

use App\Events\RegisteredEvent;
use App\Helper\AppHelper;
use App\Mail\EmailVerification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class RegisteredListener
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
        // If user registered with email
        if (!$event->user->fb_id) {
            \Mail::to( $event->user )->send( new EmailVerification( $event->user ) );
        }

        // Store event and IP
        \AppHelper::stat( 'register', [
            'source' => session()->pull('register-source', null),
            'ip_address' => $this->request->ip()
        ],$event->user );
    }
}
