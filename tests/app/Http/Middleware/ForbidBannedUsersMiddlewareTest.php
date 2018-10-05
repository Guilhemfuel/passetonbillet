<?php

namespace Tests\App\Http\Middleware;

use App\Http\Resources\TicketRessource;
use App\Ticket;
use App\Train;
use App\User;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
use Laracasts\Flash\Message;
use Psy\Test\ParserTestCase;
use Tests\LastarTestCase;
use Tests\PtbTestCase;
use Tests\TestCase;

class ForbidBannedUsersMiddlewareTest extends PtbTestCase
{

    /**
     * Make sure than we ban user does an action, he gets logs out
     */
    public function testBannedUserLogsOut()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        // Make sure user can access page
        $this->get(route('public.ticket.buy.page'))->assertSuccessful();

        // Ban user
        $user->status = User::STATUS_BANNED_USER;
        $user->save();

        // Make sure can't access page
        $this->get(route('public.ticket.buy.page'))->assertRedirect(route('home'));
        $this->assertFalse(\Auth::check());

    }

}
