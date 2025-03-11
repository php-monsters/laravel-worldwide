<?php

namespace PhpMonsters\Worldwide\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PhpMonsters\Worldwide\World
 */
class Worldwide extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \PhpMonsters\Worldwide\Worldwide::class;
    }
}
