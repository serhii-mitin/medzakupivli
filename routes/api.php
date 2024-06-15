<?php

use App\Http\Controllers\Api\v1\Admin\MedicalFacilityController;
use App\Http\Controllers\Api\v1\Admin\PatientController;
use App\Http\Controllers\Api\v1\Admin\VaccinationHistoryController;
use App\Http\Controllers\Api\v1\Admin\VaccineController;
use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Patient\PatientVaccinationHistoryController;
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
    | Vaccination History Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('vaccination-history')->group(function () {
        Route::prefix('store')->group(function () {
            Route::get('get-vaccines', [PatientVaccinationHistoryController::class, 'getVaccines']);
            Route::get('get-medical-facilities', [PatientVaccinationHistoryController::class, 'getMedicalFacilities']);
            Route::get('get-dates', [PatientVaccinationHistoryController::class, 'getNotAvailableDates']);

            Route::post('/', [PatientVaccinationHistoryController::class, 'store']);
        });
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

        /*
        |--------------------------------------------------------------------------
        | Medical Facility Routes
        |--------------------------------------------------------------------------
        */
        Route::apiResource('medical-facilities', MedicalFacilityController::class)->only(['index', 'show']);

        /*
        |--------------------------------------------------------------------------
        | Users Routes
        |--------------------------------------------------------------------------
        */
        Route::prefix('patients/{patient}')->group(function () {
            Route::get('vaccination-history', [VaccinationHistoryController::class, 'index']);
            Route::post('vaccination-history/{history}/cancel', [VaccinationHistoryController::class, 'cancel']);
        });

        Route::apiResource('patients', PatientController::class)->only(['index', 'show']);
    });
});

