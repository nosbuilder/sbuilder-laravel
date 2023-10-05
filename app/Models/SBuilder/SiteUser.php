<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

class SiteUser extends SBuilder
{
    protected $table = 'sb_site_users';

    protected $primaryKey = 'su_id';

    protected $casts = [
        'su_mail_status' => 'bool',
    ];
}
