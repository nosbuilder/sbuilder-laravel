<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Changes;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasChanges
{
    public function changes() : HasMany
    {
        return $this
            ->hasMany(related: Changes::class, foreignKey: 'el_id')
            ->where(column: 'cat_ident', operator: '=', value: 'pl_users');
    }
}
