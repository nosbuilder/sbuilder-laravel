<?php

declare(strict_types=1);

namespace App\Models;

abstract class Cart extends SBuilderPlugin
{
    public function getOrder() : mixed
    {
        return $this->getAttribute('p_order');
    }
}
