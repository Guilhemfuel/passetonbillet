<?php

namespace Tests\app\Http\Controllers\Admin;

use App\User;
use Tests\TestCase;

abstract class BaseControllerTest extends TestCase
{

    protected $basePath = '/lastadmin/';

    public function beAnAdmin(){
        $user = factory(User::class)->make();
        $user->status = 100;
        $user->save();
        $this->actingAs($user);
    }

}
