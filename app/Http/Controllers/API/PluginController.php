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
        $pluginId  = (int) abs($pluginId);
        $elementId = (int) abs($elementId);

        $table = DB::connection('mysql-sbuilder')
            ->table(table: "sb_plugins_$pluginId");

        try {
            if($elementId !== null) {
                $data = $table->where('p_id', '=', $elementId)->first();
            } else {
                $data = $table->paginate();
            }
        } catch (QueryException $exception) {
            $data = [
                'error' => $exception->getMessage(),
            ];
        }

        return response()->json(compact('data'));
    }
}
