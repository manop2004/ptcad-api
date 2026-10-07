<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthCheckController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/check-login', [AuthCheckController::class, 'checkLogin']);
Route::post('/license/create', [App\Http\Controllers\API\LicenseApiController::class, 'create']);
Route::match(['get', 'post'], '/botnoi/license', [App\Http\Controllers\API\BotnoiLicenseController::class, 'checkLicense']);