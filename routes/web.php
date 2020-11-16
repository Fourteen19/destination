<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
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


/* ----------------------- Public Routes START -------------------------------- */

//Route::get('/home', 'HomeController@index')->name('home');
//Auth::routes();

//
Route::prefix('/')->middleware('web','frontend')->name('frontend.')->namespace('FrontEnd\Auth')->domain('{clientSubdomain}.platformbrand.com')->group(function(){

	Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');

    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');

    Route::post('logout', 'LoginController@logout')->name('logout');

    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');

    Route::get('password/confirm', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'ConfirmPasswordController@confirm');

    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');


});

//Public routes without authentication
Route::prefix('/')->middleware('web','frontend')->name('frontend.')->namespace('FrontEnd')->domain('{clientSubdomain}.platformbrand.com')->group(function() {
    Route::get('/', 'HomeController@index')->name('home');
});


//Public routes with authentication
Route::prefix('/')->middleware('web','auth','frontend')->name('frontend.')->namespace('FrontEnd')->domain('{clientSubdomain}.platformbrand.com')->group(function() {

    //Route::get('/home', 'WelcomeController@index')->name('home');
    Route::get('/welcome', 'WelcomeController@index')->name('welcome');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    /*   Route::get('/', function($account) {

       });
   */
    Route::get('/content/{uuid}/{slug}', 'ContentController@index')->name('content');

});


/* ----------------------- Public Routes END -------------------------------- */





/* ----------------------- Admin Routes START -------------------------------- */



/*
Route::get('test_notification', function () {
    $admin = App\Models\Admin\Admin::find(1);

    return (new App\Notifications\adminPasswordResetNotification('00000'))->toMail($admin);
});
*/
Route::prefix('/admin/')->name('admin.')->namespace('Admin\Auth')->group(function(){

	Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');

    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');

    Route::post('logout', 'LoginController@logout')->name('logout');

    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');

    Route::get('password/confirm', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'ConfirmPasswordController@confirm');

    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');

});

Route::prefix('/admin/')->middleware('auth:admin','web','admin')->name('admin.')->namespace('Admin')->group(function(){

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::resource('roles', 'RoleController', ['except' => ['show']]);

    Route::resource('admins', 'AdminController', ['except' => ['show']]);

    Route::resource('clients', 'ClientController', ['except' => ['show']]);

    //nested route
    Route::resource('clients.institutions', 'ClientInstitutionController', ['except' => ['show']]);
    //Route::resource('clients.institutions.users', 'ClientInstitutionUserController', ['except' => ['show']]);

    Route::resource('users', 'UserController', ['except' => ['show']]);
/*
    Route::get('clients/{client:uuid}/institutions/{institution:uuid}/users',['as'=>'clients.institutions.users.index','uses'=>'ClientInstitutionUserController@index']);
    Route::get('clients/{client:uuid}/institutions/{institution:uuid}/users/create',['as'=>'clients.institutions.users.create','uses'=>'ClientInstitutionUserController@create']);
    Route::post('clients/{client:uuid}/institutions/{institution:uuid}/users/store',['as'=>'clients.institutions.users.store','uses'=>'ClientInstitutionUserController@store']);
    Route::get('clients/{client:uuid}/institutions/{institution:uuid}/users/edit/{user:uuid}',['as'=>'clients.institutions.users.edit','uses'=>'ClientInstitutionUserController@edit']);
    Route::patch('clients/{client:uuid}/institutions/{institution:uuid}/users/{user:uuid}',['as'=>'clients.institutions.users.update','uses'=>'ClientInstitutionUserController@update']);
    Route::delete('clients/{client:uuid}/institutions/{institution:uuid}/users/{user:uuid}',['as'=>'clients.institutions.users.destroy','uses'=>'ClientInstitutionUserController@destroy']);
*/


    //ajax routes to load the clients / institutions / users in add/edit admin
    Route::post('getClient', 'DropdownController@getClient')->name('getClient');
    Route::post('/getInstitution', 'DropdownController@getInstitution')->name('getInstitution');

});

/* ----------------------- Admin Routes END -------------------------------- */
