<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Database;

use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * @tags Кастомные модули
 */
class PluginController
{
    /**
     * Выборка элементов модуля
     *
     *  Можно выбрать полный список элементов либо конкретный элемент по ID
     *
     * @param  int  $pluginId       ID модуля
     * @param  int|null  $elementId ID элемента
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $pluginId, int $elementId = null) : JsonResponse
    {
        $table = DB::connection('mysql-sbuilder')
            ->table(table: sprintf('sb_plugins_%d', (int) abs($pluginId)));

        try {
            if($elementId !== null) {
                $data = $table->where('p_id', '=', (int) abs($elementId))->first();
            } else {
                $data = $table->count() > 100 ? $table->paginate() : $table->get();
            }
        } catch (QueryException $exception) {
            $data = [
                'error' => $exception->getMessage(),
                'code'  => $exception->getCode(),
                'sql'   => $exception->getSql(),
            ];
        }

        return response()->json(compact('data'));
    }
}
