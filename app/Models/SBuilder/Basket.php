<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Basket extends SBuilder
{
    protected $table = 'sb_basket';

    protected $casts = [
        'b_date'     => 'timestamp',
        'b_id_mod'   => 'int',
        'b_id_el'    => 'int',
        'b_count_el' => 'int',
        'b_discount' => 'int',
        'b_reserved' => 'bool',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'b_id_user');
    }
}
