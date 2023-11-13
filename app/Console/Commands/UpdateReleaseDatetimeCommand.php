<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Traits\EnvironmentKeyReplacementPattern;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpdateReleaseDatetimeCommand extends Command
{
    use EnvironmentKeyReplacementPattern;

    protected $signature = 'release:update-datetime';

    public function handle() : int
    {
        Storage::put('release_date', now()->isoFormat('LLLL'));

        return self::SUCCESS;
    }
}
