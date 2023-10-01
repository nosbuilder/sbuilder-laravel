<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\SBuilder;
use App\Models\SBuilderPlugin;
use Illuminate\Support\Facades\DB;

class SBuilderRepository
{
    public function getCategoryFromPluginElement(SBuilder $SBuilder)
    {
        return $this->getCategory(
            catIdent: $SBuilder->getIdent(),
            table: $SBuilder->getTable(),
            id: $SBuilder->getAttribute($SBuilder->getKeyName())
        );
    }

    public function getCategory(string $catIdent, string $table, int $id)
    {
        return DB::table(table: 'sb_categs')
            ->join(
                table: 'sb_catlinks',
                first: 'sb_categs.cat_id',
                operator: '=',
                second: 'sb_catlinks.link_cat_id'
            )
            ->join(
                table: $table,
                first: 'sb_catlinks.link_el_id',
                operator: '=',
                second: "$table.p_id"
            )
            ->where(
                column: 'sb_categs.cat_ident',
                operator: '=',
                value: $catIdent,
            )
            ->where(
                column: 'sb_catlinks.link_el_id',
                operator: '=',
                value: $id
            )
            ->first();
    }
}
