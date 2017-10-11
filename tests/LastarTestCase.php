<?php

namespace Tests;

use App\User;

abstract class LastarTestCase extends TestCase
{

    public function beAUser(){
        $user = factory(User::class)->create();
        $this->actingAs($user);
        return $this;
    }

    public function beAnAdmin(){
        $user = factory(User::class)->states('admin')->create();
        $this->actingAs($user);
        return $this;
    }

    public function postWithCsrf( $url, $data = [], $session = [] )
    {
        $data['_token']='token';
        return $this->withSession(array_merge(['_token'=>'token'],$session))
                         ->post($url,$data);
    }

    public function putWithCsrf( $url, $data = [], $session = [] )
    {
        $data['_token']='token';
        return $this->withSession(array_merge(['_token'=>'token'],$session))
                    ->put($url,$data);
    }

    public function deleteWithCsrf( $url, $data = [] )
    {
        $data['_token']='token';
        return $this->withSession(['_token'=>'token'])
                    ->delete($url,$data);
    }

}
