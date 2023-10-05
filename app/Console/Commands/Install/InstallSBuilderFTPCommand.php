<?php

declare(strict_types=1);

namespace App\Console\Commands\Install;

use App\Traits\EnvironmentKeyReplacementPattern;
use Illuminate\Console\Command;

class InstallSBuilderFTPCommand extends Command
{
    use EnvironmentKeyReplacementPattern;

    protected $signature = 'install:sbuilder-ftp {host?} {username?} {password?}';

    public function handle() : int
    {
        $this->components->info('Setting FTP accesses');

        $this->replaceKey('host', 'FTP_SBUILDER_HOST', 'filesystems.disks.sbuilder-ftp.host');
        $this->replaceKey('username', 'FTP_SBUILDER_USERNAME', 'filesystems.disks.sbuilder-ftp.username');
        $this->replaceKey('password', 'FTP_SBUILDER_PASSWORD', 'filesystems.disks.sbuilder-ftp.password');

        $this->components->info('success');

        return self::SUCCESS;
    }
}
