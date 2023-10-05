<?php

declare(strict_types=1);

namespace App\Models\SBuilder;

use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

abstract class SBuilder extends Model
{
    use PowerJoins;

    protected $connection = 'mysql-sbuilder';

    public $timestamps = false;

    protected $guarded = [];

    public function getIdent() : string
    {
        return str_replace('sb', 'pl', $this->table);
    }
}
