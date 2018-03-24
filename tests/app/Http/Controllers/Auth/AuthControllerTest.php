<?php

namespace Tests\app\Http\Controllers\Auth;

use Illuminate\Support\Facades\Event;
use App\Events\RegisteredEvent;
use App\User;
use Tests\LastarTestCase;

class LoginControllerTest extends LastarTestCase
{

    /**
     * Make sure login works properly
     */
    public function testLogin()
    {

        $user = factory( User::class )->create();
        $response = $this->postWithCsrf(route('login'),['email'=>$user->email,'password'=>'password']);
        $response->assertRedirect(route('public.ticket.buy.page'));

        $this->assertEquals(\Auth::user()->id, $user->id);

    }

    /**
     * Make sure unconfirmed user can't login
     */
    public function testLoginUnconfirmedUser()
    {

        $user = factory( User::class )->states('not_confirmed')->create();
        $response = $this->postWithCsrf(route('login'),['email'=>$user->email,'password'=>'password']);
        $response->assertRedirect(route('home'))->assertSessionHasErrors();

        $this->assertNull(\Auth::user());

    }

}
