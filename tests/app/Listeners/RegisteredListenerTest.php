<?php

namespace Tests\app\Listeners;

use App\Events\RegisteredEvent;
use App\Listeners\RegisteredListener;
use App\Mail\EmailVerification;
use App\User;
use Illuminate\Http\Request;
use Tests\LastarTestCase;

class RegisteredListenerTest extends LastarTestCase
{
    public function testRegisterEvent(){

        \Mail::fake();

        $user = factory( User::class )->states( 'not_confirmed' )->create([
            'fb_id' => null
        ]);

        $request = new Request();

        $listener = new RegisteredListener($request);
        $listener->handle(new RegisteredEvent($user));

        \Mail::assertQueued(EmailVerification::class, function ($mail) use ($user) {
            return $mail->user->id === $user->id;
        });
    }
}
