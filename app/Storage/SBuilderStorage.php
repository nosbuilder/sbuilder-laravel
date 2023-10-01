<?php

declare(strict_types=1);

namespace App\Storage;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class SBuilderStorage extends Storage
{
    public static function local() : Filesystem
    {
        return self::disk('sbuilder-local');
    }

    public static function ftp() : Filesystem
    {
        return self::disk('sbuilder-ftp');
    }
}
