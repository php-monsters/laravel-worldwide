<?php

namespace PhpMonsters\Worldwide\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use PhpMonsters\Worldwide\WorldServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        //
    }

    protected function getPackageProviders($app): array
    {
        return [
            WorldServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
    }
}
