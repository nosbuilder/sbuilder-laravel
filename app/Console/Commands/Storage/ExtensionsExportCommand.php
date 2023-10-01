<?php

declare(strict_types=1);

namespace App\Console\Commands\Storage;

use App\Storage\SBuilderStorage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExtensionsExportCommand extends Command
{
    protected $signature = 'ftp:extensions-export';

    public function handle() : int
    {
        $ftp   = SBuilderStorage::ftp();
        $local = SBuilderStorage::local();

        $files      = $local->allFiles();
        $countFiles = count($files);

        foreach ($files as $i => $file) {
            $path = [
                'cms',
                'extensions',
                $file,
            ];

            $path = implode(DIRECTORY_SEPARATOR, $path);
            $path = str_replace('/', DIRECTORY_SEPARATOR, $path);

            $moved = $ftp->put(
                path: $ftp->path($path),
                contents: $local->get($file)
            );

            $iteration = sprintf('%d/%d', ++$i, $countFiles,);

            if($moved) {
                $this->components->info(sprintf('%s. File from %s imported to %s', $iteration, $local->path($path), $ftp->path($path)));
            } else {
                $this->components->error(sprintf('%s. File import error: %s', $iteration, $local->path($file)));
            }
        }

        $this->components->info('Finish!');

        return self::SUCCESS;
    }
}
