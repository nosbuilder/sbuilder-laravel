<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteUser extends SBuilder
{
    protected $table = 'sb_site_users';

    protected $primaryKey = 'su_id';

    protected $casts = [
        'su_mail_status' => 'bool',
    ];

    private function plugins(string $model) : HasMany
    {
        return $this->hasMany($model, 'p_user_id');
    }
}
