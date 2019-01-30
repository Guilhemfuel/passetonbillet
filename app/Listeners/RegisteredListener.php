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

    /**
     * Check if registered user used an IP used by a banned user. If so, creates an admin warning
     *
     * @param RegisteredEvent $event
     */
    private function checkNewUserIP(RegisteredEvent $event) {

        $bannedUsers = User::where('status',User::STATUS_BANNED_USER)->get();
        $bannedIP = [];

        foreach ($bannedUsers as $user){
            $registerStat = $user->stats->where('action','register')->first();
            if ($registerStat && !in_array($registerStat->data['ip_address'],$bannedIP)) {
                $bannedIP[] = $registerStat->data['ip_address'];
            }
        }


    }
}
