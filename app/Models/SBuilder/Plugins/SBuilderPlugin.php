<?php

declare(strict_types=1);

namespace App\Models\SBuilder\Plugins;

use App\Models\SBuilder\SBuilder;
use App\Models\SBuilder\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
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
                    $insert = DB::connection('mysql-sbuilder')
                        ->table('sb_catchanges')->insert([
                            'el_id'          => $builder->getAttribute($builder->primaryKey),
                            'cat_ident'      => $builder->getIdent(),
                            'change_user_id' => config('sbuilder.user_id'),
                            'change_date'    => time(),
                            'action'         => 'edit',
                        ]);
                } catch (Throwable $throwable) {
                    Log::error($throwable->getMessage() . PHP_EOL . $throwable->getTraceAsString());
                }

                return $insert;
            }
        );
    }

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'p_user_id');
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
