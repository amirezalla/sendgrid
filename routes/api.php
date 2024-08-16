<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestEmailController;
use App\Http\Controllers\SendGridController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sendEmail', [TestEmailController::class, 'send'] );

Route::post('/auth-sendEmail', [TestEmailController::class, 'auth_send'] );

Route::post('/sendBatchEmail', [TestEmailController::class, 'sendBatch'] );

Route::post('/createSender', [SendGridController::class, 'createSender']);

Route::post('/apiTest', [TestEmailController::class, 'apiTest']);






