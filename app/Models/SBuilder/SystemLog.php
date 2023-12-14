<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemLog extends SBuilder
{
    use MassPrunable;

    protected $table = 'sb_system_log';

    protected $primaryKey = 'sl_id';

    protected $casts = [
        'sl_date' => 'timestamp',
    ];

    public function prunable() : Builder
    {
        return static::query()
            ->where('sl_date', '<=', now()->startOfDay()->subDays(7)->timestamp);
    }

    public function user() : BelongsTo
    {
        return $this
            ->belongsTo(related: User::class, foreignKey: 'sl_user_id');
    }
}
