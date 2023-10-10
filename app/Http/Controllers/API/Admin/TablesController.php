<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Schema;

class TablesController
{
    public function __invoke() : JsonResponse
    {
        return response()->json([
            'tables' => Schema::connection('mysql-sbuilder')->getAllTables(),
        ]);
    }
}
