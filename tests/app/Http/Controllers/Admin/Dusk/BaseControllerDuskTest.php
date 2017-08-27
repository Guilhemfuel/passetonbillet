<?php

namespace Tests\app\Http\Controllers\Admin\Dusk;

use App\User;
use Tests\DuskTestCase;

abstract class BaseControllerDuskTest extends DuskTestCase
{
    protected $basePath = 'lastadmin/';

    protected function logAsAdmin(&$browser){
        $user = factory(User::class)->make();
        $user->status = 100;
        $user->save();
        $browser->loginAs($user);
    }
}
