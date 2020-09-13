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


//Auth::routes();
/* ----------------------- Admin Routes START -------------------------------- */
//use App\Http\Controllers\Admin\Auth\LoginController;
Route::prefix('/admin/')->name('admin.')->namespace('Admin\Auth')->group(function(){

    
//	Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

    
	Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
/*
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::get('logout', 'LoginController@logout')->name('getlogout');

    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');

    Route::get('password/confirm', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'ConfirmPasswordController@confirm');

    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
*/
});

Route::get('/admin/welcome', function () {
    return view('welcome');
});



//use App\Http\Controllers\HomeController;
//oute::get('admin/home', [HomeController::class, 'index'])->name('home');
Route::get('admin/home', 'HomeController@index')->name('home');
