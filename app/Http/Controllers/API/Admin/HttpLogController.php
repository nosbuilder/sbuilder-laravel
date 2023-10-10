<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Admin;

use App\Http\Resources\HttpLogCollection;
use App\Http\Resources\HttpLogResource;
use DragonCode\LaravelHttpLogger\Models\HttpLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class HttpLogController
{
    public function index(Request $request) : HttpLogCollection
    {
        $query = HttpLog::query()
            ->when(
                value: $request->has('path'),
                callback: static fn(Builder $builder) : Builder => $builder->where(
                    column: 'path',
                    operator: $request->get('path_operator', '='),
                    value: $request->get('path')
                )
            )
            ->when(
                value: $request->has('ip'),
                callback: static fn(Builder $builder) : Builder => $builder->where(
                    column: 'ip',
                    operator: '=',
                    value: $request->get('ip')
                )
            );

        return new HttpLogCollection(
            $query
                ->when(
                    value: $query->count() >= 100,
                    callback: static fn(Builder $builder) : LengthAwarePaginator => $builder->paginate(),
                    default: static fn(Builder $builder) : Collection => $builder->get(),
                ),
        );
    }

    public function show(HttpLog $log) : HttpLogResource
    {
        return new HttpLogResource($log);
    }
}
