<?php

use App\Http\Controllers\API\Admin\TablesController;
use Illuminate\Support\Facades\Route;

Route::get('db/tables', TablesController::class);
