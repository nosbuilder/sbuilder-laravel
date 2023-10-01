<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

class UserSession extends SBuilder
{
    protected $table = 'sb_users_sessions';

    protected $primaryKey = 'us_id';

    protected $with = 'user';

    protected $casts = [
        'us_session_time' => 'timestamp',
        'us_active_time'  => 'timestamp',
    ];

    public function user() : HasOne
    {
        return $this->hasOne(related: User::class, foreignKey: 'u_id', localKey: 'us_user_id');
    }
}
