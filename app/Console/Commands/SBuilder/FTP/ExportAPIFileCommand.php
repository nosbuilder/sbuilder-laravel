<?php

declare(strict_types=1);

namespace App\Console\Commands\SBuilder\FTP;

use Illuminate\Console\Command;

class ExportAPIFileCommand extends Command
{
    protected $signature = 'sbuilder:ftp-export-api';

    public function handle() : int
    {
        return $this->call(ExportFilesCommand::class, [
            'path' => 'cms/extensions/API.php',
        ]);
    }
}
