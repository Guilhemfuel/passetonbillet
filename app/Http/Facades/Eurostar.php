<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Description of AppIntercom Facade Accessor
 */
class Eurostar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'eurostar';
    }
}