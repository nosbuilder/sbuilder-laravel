<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\Commands\SBuilder\DB\InstallSBuilderDatabaseCommand;
use App\Console\Commands\SBuilder\FTP\InstallSBuilderFTPCommand;
use Illuminate\Console\Command;
use Illuminate\Foundation\Console\KeyGenerateCommand;
use Illuminate\Foundation\Console\StorageLinkCommand;

class InstallCommand extends Command
{
    protected $signature = 'install';

    public function handle() : int
    {
        if(!file_exists($this->laravel->environmentFilePath())) {
            file_put_contents(
                filename: $this->laravel->environmentFilePath(),
                data: file_get_contents($this->laravel->basePath('.env.example'))
            );
        }

        $this->call(KeyGenerateCommand::class);
        $this->call(InstallSBuilderDatabaseCommand::class);
        $this->call(InstallSBuilderFTPCommand::class);
        $this->call(InstallBasicAuthCommand::class);
        $this->call(StorageLinkCommand::class);

        return self::SUCCESS;
    }
}
