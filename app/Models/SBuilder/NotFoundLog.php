<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;

class NotFoundLog extends SBuilder
{
    use MassPrunable;

    protected $table = 'sb_404_log';

    protected $casts = [
        'l_date' => 'timestamp',
    ];

    public function prunable() : Builder
    {
        return static::query()
            ->where('l_date', '<=', now()->startOfDay()->subDays(7)->timestamp);
    }
}
