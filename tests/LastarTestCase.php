<?php

namespace Tests;

use App\User;

abstract class LastarTestCase extends TestCase
{

    public function beAnAdmin(){
        $user = factory(User::class)->states('admin')->create();
        $this->actingAs($user);
        return $this;
    }

    public function postWithCsrf( $url, $data = [] )
    {
        $data['_token']='token';
        return $this->withSession(['_token'=>'token'])
                         ->post($url,$data);
    }

    public function putWithCsrf( $url, $data = [] )
    {
        $data['_token']='token';
        return $this->withSession(['_token'=>'token'])
                    ->put($url,$data);
    }

    public function deleteWithCsrf( $url, $data = [] )
    {
        $data['_token']='token';
        return $this->withSession(['_token'=>'token'])
                    ->delete($url,$data);
    }

}
