<?php

namespace App\Models\SBuilder;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends SBuilder
{
    protected $table = 'sb_categs';

    protected $primaryKey = 'cat_id';

    protected $casts = [
        'cat_rubrik' => 'bool',
        'cat_closed' => 'bool',
    ];

    public function categoryLinks() : HasMany
    {
        return $this->hasMany(
            related: CategoryLinks::class,
            foreignKey: 'link_cat_id',
        );
    }
}
