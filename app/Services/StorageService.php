<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class StorageService extends Storage
{
    public function make() : static
    {
        return new static;
    }

    public function local() : Filesystem
    {
        return self::disk('sbuilder-local');
    }

    public function ftp() : Filesystem
    {
        return self::disk('sbuilder-ftp');
    }
}
