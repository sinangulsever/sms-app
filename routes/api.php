<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\SmsController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('login', 'login');
            Route::post('register', 'register');
            Route::get('user', 'user');
        });
    });


    Route::middleware(["auth:api"])->group(function () {

        Route::controller(SmsController::class,)->group(function () {
            Route::get('sms', 'index');
            Route::post('sms', 'store');
            Route::get('sms/{id}', 'show');
            Route::get('sms/{id}/report', 'report');
            Route::delete('sms/{id}', 'destroy');
        });

    });

});
