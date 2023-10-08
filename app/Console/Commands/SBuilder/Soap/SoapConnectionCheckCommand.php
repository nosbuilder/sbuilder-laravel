<?php

declare(strict_types=1);

namespace App\Console\Commands\SBuilder\Soap;

use App\SoapPlugin;
use Illuminate\Console\Command;
use Throwable;

class SoapConnectionCheckCommand extends Command
{
    protected $signature = 'sbuilder:soap-check';

    public function handle() : int
    {
        try {
            $this->laravel->make(SoapPlugin::class);
        } catch (Throwable $e) {
            $this->components->error($e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
