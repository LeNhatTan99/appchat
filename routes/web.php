<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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




// Route User
Route::group(['prefix' => '/user', 'middleware' => 'lang'], function () {
    Route::get('login', [App\Http\Controllers\Auth\UserLoginController::class, 'login'])->name('login');
    // Route::post('login', [App\Http\Controllers\Auth\UserLoginController::class, 'postLogin'])->name('post.login');
    Route::post('logout', [App\Http\Controllers\Auth\UserLoginController::class, 'logout'])->name('user.logout');

    // Route forget and reset password for user
    Route::get('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgetPasswordForm'])->name('show.forget.password.form');
    Route::post('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('submit.forget.password.form');
    Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetPasswordForm'])->name('show.reset.password.form');
    Route::post('reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitResetPasswordForm'])->name('submit.reset.password.form');
});

// Change language
Route::get('language/{language}', [App\Http\Controllers\Language\LanguageController::class, 'language'])->name('language');


Route::view('/{any}', 'app')->where('any', '.*');
