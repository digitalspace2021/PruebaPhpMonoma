<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\TestController;
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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/lead', [CandidateController::class, 'store']);
    Route::get('/leads', [CandidateController::class, 'index']);
    Route::get('/lead/{id}', [CandidateController::class, 'show']);
});


