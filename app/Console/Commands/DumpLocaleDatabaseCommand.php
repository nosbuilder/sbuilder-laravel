<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DumpLocaleDatabaseCommand extends Command
{
    private const BACKUP_PATH = 'databases/sqlite/backups';

    protected $signature = 'db:dump-sqlite';

    public function handle() : int
    {
        $path = sprintf('%s/%s_database.sqlite', self::BACKUP_PATH, date('Y-m-d_H-i-s'));

        if(!File::exists(config('database.connections.sqlite.database'))) {
            $this->components->error('Database not exists!');

            return self::FAILURE;
        }

        $database = File::get(config('database.connections.sqlite.database'));

        Storage::put($path, $database);

        $this->components->info('Success. Save to: ' . Storage::path($path));

        $this->clearOldBackups();

        return self::SUCCESS;
    }

    private function clearOldBackups() : void
    {
        foreach (Storage::files(self::BACKUP_PATH) as $file) {
            if(Date::createFromTimestamp(Storage::lastModified($file))->diffInDays(now()) >= 7) {
                Storage::delete($file);
            }
        }
    }
}
