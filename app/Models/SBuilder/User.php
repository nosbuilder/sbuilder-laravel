<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

use App\Traits\HasCategory;
use App\Traits\HasChanges;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends SBuilder
{
    use HasChanges;
    use HasCategory;

    protected $table = 'sb_users';

    protected $primaryKey = 'u_id';

    public function actions() : HasMany
    {
        return $this
            ->hasMany(
                related: Changes::class,
                foreignKey: 'change_user_id'
            );
    }
}
