<?php

use App\Http\Controllers\api\AuthController as ApiAuthController;
use App\Http\Controllers\api\getTripsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login' ,[ApiAuthController::class,'login']); //تسجيل دخول
Route::group(['middleware' => 'api.auth'], function () {
    Route::post('/home', [ApiAuthController::class,'home']); // احصل على معلومات المستخدم
    Route::post('/logout', [ApiAuthController::class,'logout']); //أوقع
    Route::get('/trip', [getTripsController::class,'getTrips']);
});

