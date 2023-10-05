<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\SBuilder\Category;

trait HasCategory
{
    public function category()
    {
        return Category::query()
            ->select('sb_categs.*')
            ->join(
                table: 'sb_catlinks',
                first: "sb_categs.cat_id",
                operator: '=',
                second: 'sb_catlinks.link_cat_id'
            )
            ->join(
                table: $this->table,
                first: 'sb_catlinks.link_el_id',
                operator: '=',
                second: "$this->table.$this->primaryKey"
            )
            ->where(
                column: 'sb_categs.cat_ident',
                operator: '=',
                value: $this->getIdent()
            )
            ->first();
    }
}
