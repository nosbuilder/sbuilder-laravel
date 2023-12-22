<?php

use App\Http\Controllers\SystemLogController;
use App\Http\Integrations\GitHub\GitHubConnector;
use App\Http\Integrations\GitHub\Requests\ListCommitsRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', static fn() : View => view('welcome'));

Route::get('github/last-commit', static function(GitHubConnector $connector) {
    $response = $connector->send(new ListCommitsRequest);

    if($response->ok()) {
        return redirect($response->json('0.html_url'));
    }

    abort($response->status());
});

Route::get('system-logs', SystemLogController::class);
