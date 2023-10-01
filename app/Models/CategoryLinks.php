<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryLinks extends SBuilder
{
    protected $table = 'sb_catlinks';

    public function category() : BelongsTo
    {
        return $this->belongsTo(
            related: Category::class,
            foreignKey: 'link_cat_id',
            ownerKey: 'cat_id'
        );
    }
}
