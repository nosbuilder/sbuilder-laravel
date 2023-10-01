<?php

declare(strict_types=1);

namespace App\Models;

class Cron extends SBuilder
{
    protected $table = 'sb_cron';

    protected $primaryKey = 'sc_id';

    protected $casts = [
        'sc_active'     => 'bool',
        'sc_manual'     => 'bool',
        'sv_inprogress' => 'bool',
    ];
}
