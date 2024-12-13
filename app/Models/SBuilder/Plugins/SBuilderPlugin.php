<?php

declare(strict_types=1);

namespace App\Models\SBuilder\Plugins;

use App\Enums\ChangesActionEnum;
use App\Models\SBuilder\CatChange;
use App\Models\SBuilder\SBuilder;
use App\Models\SBuilder\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;
use Throwable;

abstract class SBuilderPlugin extends SBuilder
{
    protected static function boot() : void
    {
        parent::boot();

        static::updated(
            static function(SBuilder $builder) : bool {
                $insert = false;

                try {
                    $insert = CatChange::query()->create([
                        'el_id'     => $builder->getKey(),
                        'cat_ident' => $builder->getIdent(),
                        'action'    => ChangesActionEnum::Edit,
                    ]);

                } catch (Throwable $throwable) {
                    Log::error($throwable->getMessage() . str_repeat(PHP_EOL, 2) . $throwable->getTraceAsString());
                }

                return (bool) $insert;
            }
        );
    }

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'p_user_id');
    }

    public function changes() : HasMany
    {
        return $this->hasMany(CatChange::class, 'el_id')
            ->where('cat_ident', $this->getIdent());
    }

    public function category(): HasOneThrough
    {
        return $this->hasOneThrough(
            Category::class,
            CategoryLinks::class,
            'link_el_id',
            'cat_id',
            'p_id',
            'link_cat_id'
        )->where('cat_ident', $this->getIdent());
    }

    public function getUserF(int $id) : mixed
    {
        return $this->getAttribute("user_f_$id");
    }

    public function getId() : mixed
    {
        return $this->getAttribute('p_id');
    }

    public function getTitle() : mixed
    {
        return $this->getAttribute('p_title');
    }

    public function getActive() : bool
    {
        return (bool) $this->getAttribute('p_active');
    }

    public function getUrl() : mixed
    {
        return $this->getAttribute('p_url');
    }

    public function getSort() : mixed
    {
        return $this->getAttribute('p_order');
    }

    public function getExtId() : mixed
    {
        return $this->getAttribute('p_ext_id');
    }

    public function pActive() : Attribute
    {
        return Attribute::make(
            get: static fn(int $value) : bool => (bool) $value,
            set: static fn(mixed $value) : int => (int) (bool) $value
        );
    }
}
