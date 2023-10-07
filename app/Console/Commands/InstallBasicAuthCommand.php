<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Traits\EnvironmentKeyReplacementPattern;
use Illuminate\Console\Command;

class InstallBasicAuthCommand extends Command
{
    use EnvironmentKeyReplacementPattern;

    protected $signature = 'install:basic-auth {user?} {pass?}';

    public function handle() : int
    {
        $this->components->info('Setting basic auth accesses.');

        $this->replaceKey('user', 'BASIC_AUTH_USER', 'auth.basic_auth.user');
        $this->replaceKey('pass', 'BASIC_AUTH_PASS', 'auth.basic_auth.pass');

        $this->components->info('Success!');

        return self::SUCCESS;
    }
}
