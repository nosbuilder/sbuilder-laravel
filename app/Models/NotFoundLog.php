<?php

namespace App\Models;

class NotFoundLog extends SBuilder
{
    protected $table = 'sb_404_log';

    protected $casts = [
        'l_date' => 'timestamp',
    ];
}
