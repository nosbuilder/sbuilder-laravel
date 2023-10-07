<?php

declare(strict_types=1);

namespace App;

use SoapClient;

class SoapPlugin extends SoapClient
{
    /**
     * @throws \SoapFault
     */
    public function plPluginsAdd(string $xml)
    {
        return $this
            ->__soapCall('plPluginsAdd', [
                'key' => config('sbuilder.soap.key'),
                'xml' => $xml,
            ]);
    }
}
