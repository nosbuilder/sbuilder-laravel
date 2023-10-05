<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

class ExternalScript extends SBuilder
{
    protected $table = 'sb_external_script';

    protected $primaryKey = 'es_id';

    protected $casts = [
        'es_date' => 'timestamp',
    ];
}
