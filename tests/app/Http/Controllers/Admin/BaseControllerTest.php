<?php

namespace Tests;

use App\User;

abstract class BaseControllerTest extends DuskTestCase
{
    protected $basePath = 'lastadmin/';

    protected function logAsAdmin(&$browser){
        $user = factory(User::class)->make();
        $user->status = 100;
        $user->save();
        $browser->loginAs($user);
    }
}
