<?php

namespace Tests\app\Listeners;

use App\Events\RegisteredEvent;
use App\Listeners\RegisteredListener;
use App\Mail\EmailVerification;
use App\User;
use Tests\LastarTestCase;

class RegisteredListenerTest extends LastarTestCase
{
    public function testRegisterEvent(){

        \Mail::fake();

        $user = factory( User::class )->states( 'not_confirmed' )->create();

        $listener = new RegisteredListener();
        $listener->handle(new RegisteredEvent($user));

        \Mail::assertSent(EmailVerification::class, function ($mail) use ($user) {
            return $mail->user->id === $user->id;
        });
    }
}
