<?php

namespace PhpMonsters\Worldwide\Commands;

use Illuminate\Console\Command;

class InstallWorldwideCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'worldwide:install';

    /**
     * The console command description.
     */
    protected string $description = 'Install php-monsters/laravel-worldwide package';

    protected ?string $starRepo = 'php-monsters/laravel-worldwide';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $this->callSilently('vendor:publish', [
            '--tag' => 'worldwide-config',
        ]);

        $this->callSilently('vendor:publish', [
            '--tag' => 'worldwide-migrations',
        ]);

        $this->callSilently('vendor:publish', [
            '--tag' => 'worldwide-models',
        ]);

        $this->callSilently('vendor:publish', [
            '--tag' => 'worldwide-seeders',
        ]);

        if ($this->confirm('Would you like to run the migrations now?')) {
            $this->comment('Running migrations...');

            $this->call('migrate');
        }

        if ($this->confirm('Would you like to star our repo on GitHub?')) {
            $repoUrl = "https://github.com/{$this->starRepo}";

            if (PHP_OS_FAMILY == 'Darwin') {
                exec("open {$repoUrl}");
            }
            if (PHP_OS_FAMILY == 'Windows') {
                exec("start {$repoUrl}");
            }
            if (PHP_OS_FAMILY == 'Linux') {
                exec("xdg-open {$repoUrl}");
            }
        }

        $this->info('world has been installed!');

    }
}
