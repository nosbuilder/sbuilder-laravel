<?php

declare(strict_types=1);

namespace App\Models;

class Page extends SBuilder
{
    protected $table = 'sb_pages';

    protected $primaryKey = 'p_id';

    protected $casts = [
        'p_default' => 'bool',
        'p_nocache' => 'bool',
    ];
}
