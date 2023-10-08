<?php

declare(strict_types=1);

namespace App\Console\Commands\SBuilder\DB;

use App\Traits\EnvironmentKeyReplacementPattern;
use Illuminate\Console\Command;

class InstallSBuilderDatabaseCommand extends Command
{
    use EnvironmentKeyReplacementPattern;

    protected $signature = 'sbuilder:db-install {host?} {db?} {username?} {password?}';

    public function handle() : int
    {
        $this->components->info('Setting database accesses');

        $this->replaceKey('host', 'DB_SBUILDER_HOST', 'database.connections.mysql-sbuilder.host');
        $this->replaceKey('db', 'DB_SBUILDER_DATABASE', 'database.connections.mysql-sbuilder.database');
        $this->replaceKey('username', 'DB_SBUILDER_USERNAME', 'database.connections.mysql-sbuilder.username');
        $this->replaceKey('password', 'DB_SBUILDER_PASSWORD', 'database.connections.mysql-sbuilder.password');

        $this->components->info('Success! Check connection: php artisan sbuilder:db-check');

        return self::SUCCESS;
    }
}
