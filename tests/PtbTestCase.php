<?php

namespace Tests;

use App\User;
use Laracasts\Flash\Message;

abstract class PtbTestCase extends TestCase
{


    /**
     * =========
     * ---- Shortcut to be a specific user
     * =========
     */

    public function beAUser($state = ''){
        if ($state == '') {
            $user = factory(\App\User::class)->create();
        } else {
            $user = factory(\App\User::class)->states($state)->create();
        }
        $this->actingAs($user);
        return $this;
    }

    public function beAnAdmin(){
        $user = factory(\App\User::class)->states('admin')->create();
        $this->actingAs($user);
        return $this;
    }

    /**
     * ==========
     * ---- Http requests helper to deal with csrf
     * ==========
     */

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

    /**
     * ==========
     * ---- Custom assertions
     * ==========
     */

    public function assertResponseHasFlashMsg($response, $level, $message, $important, $sessionContent = [])
    {
        // Building flash message
        $flashMesage = new Message();
        $flashMesage->important = $important;
        $flashMesage->message = $message;
        $flashMesage->level = $level;

        $response->assertSessionHas(
            array_merge([ 'flash_notification' => collect( [ $flashMesage ] ) ], $sessionContent)
        );
    }

}
