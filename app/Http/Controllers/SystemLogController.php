<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SBuilder\SystemLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SystemLogController
{
    public function __invoke(Request $request) : View|RedirectResponse
    {
        if($request->exists('clear')) {
            SystemLog::query()->truncate();

            return redirect()->route('sbuilder-logs');
        }

        $chart = SystemLog::query()
            ->selectRaw('COUNT(*) as count, DATE(FROM_UNIXTIME(sl_date)) as label')
            ->groupByRaw('DATE(FROM_UNIXTIME(sl_date))')
            ->latest('sl_id')
            ->get()
            ->toJson();

        return view('sbuilder-logs', [
            'logs'             => SystemLog::query()->latest('sl_date')->paginate(),
            'logs_day_count'   => SystemLog::query()->where('sl_date', '>=', now()->startOfDay()->timestamp)->count(),
            'logs_hour_count'  => SystemLog::query()->where('sl_date', '>=', now()->startOfHour()->timestamp)->count(),
            'logs_latest_date' => SystemLog::query()->latest('sl_date')->first()?->getAttribute('sl_date')->isoFormat('LLLL'),
            'logs_oldest_date' => SystemLog::query()->oldest('sl_date')->first()?->getAttribute('sl_date')->isoFormat('LLLL'),
            'chart'            => $chart,
        ]);
    }
}
