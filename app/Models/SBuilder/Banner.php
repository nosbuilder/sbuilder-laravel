<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Banner extends SBuilder
{
    protected $table = 'sb_banners';

    protected $primaryKey = 'sb_id';

    protected $casts = [
        'sb_active' => 'bool',
    ];

    public function restricted() : HasMany
    {
        return $this->hasMany(related: BannerRestricted::class, foreignKey: 'sbr_bid');
    }

    public function statistic() : HasMany
    {
        return $this->hasMany(related: BannerStatistic::class, foreignKey: 'sb_bid');
    }
}
