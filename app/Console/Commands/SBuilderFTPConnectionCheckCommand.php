<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\Commands\Install\InstallSBuilderFTPCommand;
use App\Services\StorageService;
use Exception;
use Illuminate\Console\Command;

class SBuilderFTPConnectionCheckCommand extends Command
{
    protected $signature = 'sbuilder:ftp-check';

    public function handle(StorageService $storageService) : int
    {
        $this->components->info('Start testing FTP connection.');

        try {
            $storageService->ftp()->directories('/');
        } catch (Exception $exception) {
            $this->components->error("{$exception->getMessage()} Code: {$exception->getCode()}");

            if($this->components->confirm('Start setting up FTP accesses?', true)) {
                return $this->call(InstallSBuilderFTPCommand::class);
            }

            return self::FAILURE;
        }

        $this->components->info('Connection success!');

        return self::SUCCESS;
    }
}
