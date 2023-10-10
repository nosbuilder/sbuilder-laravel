<?php

use App\Http\Controllers\API\Admin\HttpLogController;
use App\Http\Controllers\API\Admin\TablesController;
use Illuminate\Support\Facades\Route;

Route::prefix('http-logs')->group(static function() {
    Route::get('', [HttpLogController::class, 'index']);
    Route::get('{httpLog}', [HttpLogController::class, 'show']);
});

Route::get('db/tables', TablesController::class);
