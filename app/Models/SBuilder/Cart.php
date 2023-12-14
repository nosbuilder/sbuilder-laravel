<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

use App\Models\SBuilder\Plugins\SBuilderPlugin;

abstract class Cart extends SBuilderPlugin
{
    public function getOrder() : mixed
    {
        return $this->getAttribute('p_order');
    }
}
