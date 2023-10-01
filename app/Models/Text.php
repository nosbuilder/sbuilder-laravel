<?php

declare(strict_types=1);

namespace App\Models;

class Text extends SBuilder
{
    protected $table = 'sb_texts';

    protected $primaryKey = 't_id';

    protected $casts = [
        't_status' => 'bool',
    ];
}
