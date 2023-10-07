<?php

namespace App\Console\Commands\SBuilder\Soap;

use App\Traits\EnvironmentKeyReplacementPattern;
use Illuminate\Console\Command;

class InstallSoapKey extends Command
{
    use EnvironmentKeyReplacementPattern;

    protected $signature = 'install:soap {key?}';

    public function handle() : int
    {
        $this->replaceKey('key', 'SBUILDER_SOAP_TOKEN', 'sbuilder.soap.key');

        return self::SUCCESS;
    }
}
