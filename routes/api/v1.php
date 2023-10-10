<?php

declare(strict_types=1);

use App\Http\Controllers\API\Database;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('db/plugins/{plugin_id}/{element_id?}', Database\PluginController::class)
    ->where('pluginId', '[0-9]+')
    ->where('elementId', '[0-9]+');
