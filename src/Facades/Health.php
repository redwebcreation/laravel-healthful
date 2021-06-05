<?php

namespace RWC\Healthful\Facades;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool check()
 * @method static Route route()
 *
 * @see \RWC\Healthful\Health
 */
class Health extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'health';
    }
}
