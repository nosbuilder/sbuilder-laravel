<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Traits\EnvironmentKeyReplacementPattern;
use Illuminate\Console\Command;

class UpdateReleaseDatetimeCommand extends Command
{
    use EnvironmentKeyReplacementPattern;

    protected $signature = 'release:update-datetime';

    public function handle() : int
    {
        $this->replaceKeyValue('RELEASE_DATETIME', 'app.release_datetime', date('d.m.Y_H:i'));

        return self::SUCCESS;
    }
}
