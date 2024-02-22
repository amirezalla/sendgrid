<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestEmailController;

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
