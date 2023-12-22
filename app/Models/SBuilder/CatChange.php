<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

use App\Enums\ChangesActionEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatChange extends SBuilder
{
    protected $table = 'sb_catchanges';

    protected $primaryKey = 'sl_id';

    protected $casts = [
        'change_date'    => 'timestamp',
        'change_user_id' => 'int',
        'action'         => ChangesActionEnum::class,
    ];

    protected static function boot() : void
    {
        parent::boot();

        static::creating(
            static function(CatChange $changes) {
                $changes->setAttribute('change_user_id', config('sbuilder.user_id'));
                $changes->setAttribute('change_date', time());
            }
        );
    }

    public function causer() : BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'change_user_id'
        );
    }
}
