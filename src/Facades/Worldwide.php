<?php

namespace PhpMonster\Worldwide\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PhpMonster\Worldwide\World
 */
class Worldwide extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \PhpMonster\Worldwide\Worldwide::class;
    }
}
