<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PluginController
{
    public function __invoke(int $pluginId, int $elementId = null) : JsonResponse
    {
        $table = DB::connection('mysql-sbuilder')
            ->table(table: sprintf('sb_plugins_%d', (int) abs($pluginId)));

        try {
            if($elementId !== null) {
                $data = $table->where('p_id', '=', (int) abs($elementId))->first();
            } else {
                $data = $table->paginate();
            }
        } catch (QueryException $exception) {
            $data = [
                'error'  => $exception->getMessage(),
                'code'   => $exception->getCode(),
                'sql' => $exception->getSql(),
            ];
        }

        return response()->json(compact('data'));
    }
}
