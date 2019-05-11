<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Description of Eurostar Facade Accessor
 */
class Izy extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'izy';
    }
}