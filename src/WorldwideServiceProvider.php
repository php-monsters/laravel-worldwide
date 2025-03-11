<?php

namespace PhpMonsters\Worldwide;

use PhpMonster\Worldwide\Commands\InstallWorldCommand;
use PhpMonster\Worldwide\Commands\SeederWorldwideCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WorldwideServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {

        $package
            ->name('laravel-world')
            ->hasConfigFile()
            ->hasMigration('create_worldwide_table')
            ->hasCommands([
                InstallWorldwideCommand::class,
                SeederWorldwideCommand::class,
            ]);
    }

    public function bootingPackage(): void
    {
        parent::bootingPackage();

        if ($this->app->runningInConsole()) {
            // publishes Models
            $this->publishes([
                __DIR__.'/../stubs/Models/Country.php.stub' => app_path('Models/Country.php'),
                __DIR__.'/../stubs/Models/State.php.stub' => app_path('Models/State.php'),
                __DIR__.'/../stubs/Models/City.php.stub' => app_path('Models/City.php'),
            ], 'worldwide-models');
            // publishes Seeders
            $this->publishes([
                __DIR__.'/../stubs/database/seeders/WorldTableSeeder.php.stub' => database_path('seeders/WorldTableSeeder.php'),
            ], 'worldwide-seeders');
        }
    }
}
