<?php

namespace StarfolkSoftware\Pigeonhole\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \StarfolkSoftware\Pigeonhole\Pigeonhole
 */
class Pigeonhole extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pigeonhole';
    }
}
