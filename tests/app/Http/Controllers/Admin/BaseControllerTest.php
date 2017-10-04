<?php

namespace Tests\app\Http\Controllers\Admin;

use App\User;

abstract class BaseControllerTest extends LastarTestCase
{

    protected $basePath = '/lastadmin/';

    public function beAnAdmin(){
        $user = factory(User::class)->make();
        $user->status = 100;
        $user->save();
        $this->actingAs($user);
    }

}
