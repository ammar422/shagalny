<?php

use Illuminate\Support\Facades\Route;
use Modules\Codes\App\Http\Controllers\Api\CodesApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

route::middleware(['auth:api'])->group(function () {

    Route::post('charge', [CodesApiController::class, 'charge']);
});
