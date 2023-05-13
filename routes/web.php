<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return redirect()->route('question.index');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login.index');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'store'])->name('login.store');
    Route::get('/signup', [\App\Http\Controllers\Account\AccountController::class, 'index'])->name('account.index');
    Route::post('/signup', [\App\Http\Controllers\Account\AccountController::class, 'store'])->name('account.store');
    Route::get('/verify/email/{token}', [\App\Http\Controllers\Account\AccountController::class, 'verifyEmail'])->name('account.verifyEmail'); 
    Route::get('/forgot-password', [\App\Http\Controllers\Account\AccountController::class, 'showForgotPassword'])->name('account.showForgotPassword'); 
    Route::post('/forgot-password', [\App\Http\Controllers\Account\AccountController::class, 'storeForgotPassword'])->name('account.storeForgotPassword'); 
    Route::get('/reset-password', [\App\Http\Controllers\Account\AccountController::class, 'showResetPassword'])->name('account.showResetPassword'); 
    Route::post('/reset-password', [\App\Http\Controllers\Account\AccountController::class, 'storeResetPassword'])->name('account.storeResetPassword'); 
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'destroy'])->name('login.destroy');
    Route::prefix('account')->group(function (){
        Route::get('', [\App\Http\Controllers\Account\AccountController::class, 'show'])->name('account.show');
        Route::delete('', [\App\Http\Controllers\Account\AccountController::class, 'destroy'])->name('account.destroy');
        Route::post('/update-password', [\App\Http\Controllers\Account\AccountController::class, 'updatePassword'])->name('account.updatePassword');
        Route::get('/questions', [\App\Http\Controllers\Account\AccountController::class, 'questions'])->name('account.questions');
        Route::get('/logout', [\App\Http\Controllers\Account\AccountController::class, 'showLogout'])->name('account.showLogout');
        Route::get('/delete', [\App\Http\Controllers\Account\AccountController::class, 'showDelete'])->name('account.showDelete');
    });
    Route::get('/questions/ask', [\App\Http\Controllers\Questions\QuestionController::class, 'indexAsk'])->name('question.indexAsk');
    Route::post('/questions', [\App\Http\Controllers\Questions\QuestionController::class, 'store'])->name('question.store');
    Route::get('/questions/{question}/delete', [\App\Http\Controllers\Questions\QuestionController::class, 'destroy'])->name('question.destroy');
    Route::post('/questions/{question}/answer', [\App\Http\Controllers\Questions\QuestionAnswerController::class, 'store'])->name('questionAnswer.store');
    Route::post('/upload/image', [\App\Http\Controllers\Upload\ImageUploadController::class, 'store'])->name('imageUpload.store');
});

Route::get('/questions', [\App\Http\Controllers\Questions\QuestionController::class, 'index'])->name('question.index');
Route::get('/questions/{question}', [\App\Http\Controllers\Questions\QuestionController::class, 'show'])->name('question.show');
