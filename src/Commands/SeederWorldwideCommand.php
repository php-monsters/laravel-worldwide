<?php

namespace PhpMonsters\Worldwide\Commands;

use Illuminate\Console\Command;
use PhpMonsters\Worldwide\Worldwide;

class SeederWorldwideCommand extends Command
{
    public $signature = 'worldwide:seeder
        {--R|refresh : Reset and restart migrations for countries/states/cities in the table }
        {--F|force : Override if the file seeder already exists }
    ';

    public $description = 'Seeder All Countries/States/Cities Data';

    public function __construct(
        protected Worldwide $serves
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        if (! $this->serves->isSeedersPublished()) {
            $this->components->error('Please RUN `php artisan vendor:publish --tag=worldwide-seeders` to publish seeder class');

            return self::INVALID;
        }

        if (! $this->serves->hasMigrationFileName(migrationFileName: 'create_worldwide_table.php')) {
            $this->components->error('Please RUN `php artisan vendor:publish --tag=worldwide-migrations` to publish migrations tables');

            return self::INVALID;
        }

        if ($this->option('force')) {
            $this->call('vendor:publish', [
                '--tag' => 'worldwide-seeders',
                '--force' => true,
            ]);
        }

        if ($this->option('refresh')) {
            if ($this->confirm('Are you sure you want to delete all data in the Countries/States/Cities tables?')) {
                $this->callSilently('migrate:refresh', [
                    '--path' => 'database/migrations/'.$this->serves->getMigrationFileName(migrationFileName: 'create_worldwide_table.php'),
                ]);
            } else {
                $this->components->warn('counsel command.');

                return self::INVALID;
            }
        } else {
            if (! $this->serves->isAllTablesEmpty()) {
                if (! $this->serves->isCountriesTableEmpty()) {
                    $this->components->error("You can't Seeding in countries table because table has data.");

                    return self::INVALID;
                }

                if (! $this->serves->isStatesTableEmpty()) {
                    $this->components->error("You can't Seeding in states table because table has data.");

                    return self::INVALID;
                }

                if (! $this->serves->isCitiesTableEmpty()) {
                    $this->components->error("You can't Seeding in cities table because table has data.");

                    return self::INVALID;
                }

                $this->components->warn('You can run `php artisan worldwide:seeder --refresh` this command delete tables countries/states/cities and re-seeding data.');
            }
        }

        $this->call('db:seed', [
            '--class' => 'Database\\Seeders\\WorldTableSeeder',
        ]);

        return self::SUCCESS;
    }
}
