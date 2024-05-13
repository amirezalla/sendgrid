<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestEmailController;
use App\Http\Controllers\SendGridController;
use App\Http\Controllers\SmtpController;
use App\Http\Controllers\MailLogController;
use App\Http\Controllers\SchedulerController;

use App\Http\Controllers\LoginController;

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


Route::get('/login', [LoginController::class, 'getLogin']);

Route::get('/welcome', function () {
    return view('welcome');
});

// Define the route that the login form submits to
Route::get('/login/google', [loginController::class, 'redirectToGoogle'])->name('login.google');

Route::get('/login/google/callback', [loginController::class, 'handleGoogleCallback'])->name('login.google.callback');



Route::get('/test-mail', function () {
    \Mail::raw('This is a simple test mail.', function ($message) {
        $message->to('a.allahverdi@icoa.it')->subject('Test Mail');
    });
    return 'Test mail sent.';
});


// Route::middleware(['auth.session'])->group(function () {

    Route::get('/', [SendGridController::class, 'getDomains']);

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
    
    Route::group(['prefix' => 'senders'], function () {
        Route::get('/list', [SendGridController::class, 'getSenders']);
    
        Route::get('/add', function () {
            return view('senders.add');
        });
    
        Route::post('/add', [SendGridController::class, 'webAddSender']);
    
    });
    Route::get('/how-to-use', function () {
        return view('howToUse');
    });



    // _____________________ SMTP _____________________


    // Grouping SMTP-related routes
Route::group(['prefix' => 'smtp', 'as' => 'smtp.'], function () {
    // Displaying all SMTP users
    Route::get('/list', [SmtpController::class, 'list'])->name('list');

    // Form to create a new SMTP user
    Route::get('/add', function () {
        return view('smtp.add');
    })->name('add');
    
    // Storing a new SMTP user
    Route::post('/store', [SmtpController::class, 'store'])->name('store');

    // Showing the form to edit an existing SMTP user
    Route::get('/edit/{id}', [SmtpController::class, 'edit'])->name('edit');

    // Updating an existing SMTP user
    Route::put('/update/{id}', [SmtpController::class, 'update'])->name('update');

    Route::delete('/smtp/{id}', [SmtpController::class, 'destroy'])->name('destroy');

});
    // _____________________ END SMTP _____________________






    Route::get('/how-to-use', function () {
        return view('howToUse');
    });
    Route::get('/reports', function () {
        return view('reports');
    });

    Route::get('/export-maillogs', [MailLogController::class, 'exportCsv']);


    
    Route::get('/run-scheduler',[SchedulerController::class,'run']);


    




