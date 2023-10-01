<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemLog extends SBuilder
{
    protected $table = 'sb_system_log';

    protected $primaryKey = 'sl_id';

    protected $casts = [
        'sl_date' => 'timestamp',
    ];

    public function user() : BelongsTo
    {
        return $this
            ->belongsTo(related: User::class, foreignKey: 'sl_user_id');
    }
}
