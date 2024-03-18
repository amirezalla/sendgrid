<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestEmailController;
use App\Http\Controllers\SendGridController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/test-mail', function () {
    \Mail::raw('This is a simple test mail.', function ($message) {
        $message->to('a.allahverdi@icoa.it')->subject('Test Mail');
    });
    return 'Test mail sent.';
});


Route::group(['prefix' => 'domains'], function () {
    Route::get('/list', [SendGridController::class, 'getDomains']);

    Route::get('/add', function () {
        return view('domains.add');
    });

    Route::post('/add', [SendGridController::class, 'webAddDomain']);

});

Route::group(['prefix' => 'mail'], function () {

    Route::get('/send', function () {
        return view('send');
    });

    Route::post('/send', [TestEmailController::class, 'sendEmail']);

});




