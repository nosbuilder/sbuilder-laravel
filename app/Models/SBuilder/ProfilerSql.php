<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

use App\Models\SBuilder\SBuilder;
use Illuminate\Database\Eloquent\Builder;

class ProfilerSql extends SBuilder
{
    protected $table = 'sb_profiler_sql';

    protected $primaryKey = 'pr_id';

    protected $casts = [
        'pr_date' => 'timestamp',
    ];

    public function prunable() : Builder
    {
        return static::query()
            ->where('pr_date', '<=', now()->startOfDay()->subDays(7)->timestamp);
    }
}
