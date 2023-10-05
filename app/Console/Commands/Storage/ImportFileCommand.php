<?php

declare(strict_types=1);

namespace App\Console\Commands\Storage;

use App\Services\StorageService;
use Illuminate\Console\Command;

class ImportFileCommand extends Command
{
    protected $signature = 'ftp:import {filepath}';

    public function handle(StorageService $storageService) : int
    {
        $ftp      = $storageService->ftp();
        $local    = $storageService->local();
        $filepath = str_replace('/', DIRECTORY_SEPARATOR, $this->argument('filepath'));

        if(!$ftp->exists($filepath)) {
            $this->components->error('File not found');

            return self::FAILURE;
        }

        $moved = $local->put(
            path: $filepath,
            contents: $ftp->get($filepath),
        );

        if(!$moved) {
            $this->components->error('File not moved!');

            return self::FAILURE;
        }

        $this->components->info(sprintf('File %s moved', $filepath));

        return self::SUCCESS;
    }
}
