<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\SBuilder\CatChange;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasChanges
{
    public function changes() : HasMany
    {
        return $this
            ->hasMany(related: CatChange::class, foreignKey: 'el_id')
            ->where(column: 'cat_ident', operator: '=', value: 'pl_users');
    }
}
