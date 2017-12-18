<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Description of Image Helper Facade Accessor
 */
class ImageHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'imageHelper';
    }
}