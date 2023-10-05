<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

use App\Casts\SettingValueCast;

class Setting extends SBuilder
{
    protected $table = 'sb_settings';

    protected $casts = [
        's_value' => SettingValueCast::class,
    ];
}
