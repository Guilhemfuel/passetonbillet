<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Description of Eurostar Facade Accessor
 */
class Optico extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'optico';
    }
}