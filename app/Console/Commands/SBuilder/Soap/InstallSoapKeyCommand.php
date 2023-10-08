<?php

namespace App\Console\Commands\SBuilder\Soap;

use App\Traits\EnvironmentKeyReplacementPattern;
use Illuminate\Console\Command;

class InstallSoapKeyCommand extends Command
{
    use EnvironmentKeyReplacementPattern;

    protected $signature = 'sbuilder:soap-install {key?}';

    public function handle() : int
    {
        $this->replaceKey('key', 'SBUILDER_SOAP_TOKEN', 'sbuilder.soap.key');

        return self::SUCCESS;
    }
}
