<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Changes extends SBuilder
{
    protected $table = 'sb_catchanges';

    protected $casts = [
        'change_date'    => 'timestamp',
        'change_user_id' => 'int',
    ];

    public function causer() : BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'change_user_id'
        );
    }
}
