<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\App\Http\Controllers\UsersAuthController;



   

    Route::post('login', [UsersAuthController::class, 'login']);
    Route::post('register', [UsersAuthController::class, 'register']);

   
    route::middleware(['auth:api'])->group(function () {
        Route::post('logout', [UsersAuthController::class, 'logout']);
        Route::post('refresh', [UsersAuthController::class, 'refresh']);
        Route::get('me', [UsersAuthController::class, 'me']);
    });
