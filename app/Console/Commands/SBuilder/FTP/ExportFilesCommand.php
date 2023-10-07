<?php

declare(strict_types=1);

namespace App\Console\Commands\SBuilder\FTP;

use App\Services\StorageService;
use Illuminate\Console\Command;

class ExportFilesCommand extends Command
{
    protected $signature = 'ftp:export {path?} {--force}';

    public function __construct(
        private readonly StorageService $storageService
    )
    {
        parent::__construct();
    }

    public function handle() : int
    {
        if($path = $this->argument('path')) {
            if(!$this->storageService->local()->exists($path)) {
                $this->components->error(sprintf('Path %s not exists', $this->storageService->local()->path($path)));

                return self::FAILURE;
            }

            if(is_file($this->storageService->local()->path($path))) {
                return $this->moveFile($path);
            }
        }

        foreach ($this->storageService->local()->allFiles($path) as $path) {
            $this->moveFile($path);
        }

        $this->components->info('Finish!');

        return self::SUCCESS;
    }

    private function moveFile(string $file) : int
    {
        $ftp   = $this->storageService->ftp();
        $local = $this->storageService->local();

        $localFilepath = $local->path($file);
        $ftpFilePath   = $ftp->path($file);

        if(!$local->exists($file) || !is_file($localFilepath)) {
            $this->components->error(sprintf('File in %s not found!', $localFilepath));

            return self::FAILURE;
        }

        if($file !== $ftpFilePath) {
            $this->components->warn(sprintf('No overlap in paths. %s to %s', $localFilepath, $ftpFilePath));

            return self::FAILURE;
        }

        if(
            $this->hasOption('force') ||
            ($ftp->exists($ftpFilePath) && $this->components->ask(sprintf('Replace the file `%s`?', $ftpFilePath)))
        ) {
            $ftp->delete($file);
            $moved = $ftp->put(
                path: $file,
                contents: $this->handleContentFile($local->get($file))
            );

            if($moved) {
                $this->components->info(
                    sprintf(
                        'File from %s imported to %s',
                        $localFilepath,
                        config('sbuilder.url') . '/' . $ftpFilePath
                    )
                );
            } else {
                $this->components->error(sprintf('File import error: %s', $localFilepath));
            }
        }

        return self::SUCCESS;
    }

    private function handleContentFile(string $content) : string
    {
        $replacement = [
            [
                '{USERPWD}',
                config('auth.basic_auth.user') . ':' . config('auth.basic_auth.pass'),
            ],
        ];

        return str_replace(
            search: array_map(
                callback: static fn(array $array) => array_shift($array),
                array: $replacement,
            ),
            replace: array_map(
                callback: static fn(array $array) => array_pop($array),
                array: $replacement,
            ),
            subject: $content,
        );
    }
}
