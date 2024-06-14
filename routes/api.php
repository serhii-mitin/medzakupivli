<?php

use App\Http\Controllers\Api\v1\Admin\VaccineController;
use App\Http\Controllers\Api\v1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth routes
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});


/*
|--------------------------------------------------------------------------
| For authorized users
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth:sanctum']], function () {

    /*
    |--------------------------------------------------------------------------
    | Auth Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    /*
    |--------------------------------------------------------------------------
    | SuperAdmin Routes
    |--------------------------------------------------------------------------
    */
    Route::group([
        'middleware' => 'role:' . \App\Utils\Enums\User\UserRoleEnum::SUPER_ADMIN,
        'prefix' => 'admin'
    ], function () {


        /*
        |--------------------------------------------------------------------------
        | Vaccines Routes
        |--------------------------------------------------------------------------
        */
        Route::apiResource('vaccines', VaccineController::class)->only(['index', 'show']);
    });
});

