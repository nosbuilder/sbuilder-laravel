<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SQLiteInitCommand extends Command
{
    protected $signature = 'sqlite:init';

    public function handle() : int
    {
        $path = database_path('database.sqlite');

        if(file_exists($path)) {
            $this->components->warn('Database exists!');

            if($this->components->confirm('Drop current database?')) {
                return $this->createDatabase($path);
            }

            return self::FAILURE;
        }

        return $this->createDatabase($path);
    }

    public function createDatabase(string $path) : int
    {
        file_put_contents($path, NULL);

        $this->components->info('Database created!');

        return self::SUCCESS;
    }
}
