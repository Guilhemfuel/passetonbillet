<?php

namespace Tests;

abstract class LastarTestCase extends TestCase
{

    public function postWithCsrf( $url, $data )
    {
        $data['_token']='token';
        return $this->withSession(['_token'=>'token'])
                         ->post($url,$data);
    }

}
