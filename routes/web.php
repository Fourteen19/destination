<?php

use App\Models\Content;
use App\Models\ContentArticle;
use \Illuminate\Support\Facades\Auth;
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


/* ----------------------- Public Routes START -------------------------------- */

//Route::get('/home', 'HomeController@index')->name('home');
//Auth::routes();


/*
Route::get('/test', function() {

 //   $article = App\Models\ContentArticle::create(['title' => 'article 2']);
 //   $article->content()->create(['title' => 'title content', 'uuid' => '222']);

    $article = Content::find(3);


    dd($article->contentable);

});
*/

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
    Route::get('/temp-terms', 'TermsController@index')->name('temp-terms');
    Route::get('/temp-info', 'InfoController@index')->name('temp-info');
});


//Public routes with authentication
Route::prefix('/')->middleware('web','auth:web','frontend')->name('frontend.')->namespace('FrontEnd')->domain('{clientSubdomain}.platformbrand.com')->group(function() {

    //Route::get('/home', 'WelcomeController@index')->name('home');
    Route::get('/welcome', 'WelcomeController@index')->name('welcome');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::prefix('/self-assessment')->name('self-assessment.')->group(function(){

        Route::get('/terms', 'SelfAssessmentTermsController@edit')->name('terms.edit');
        Route::post('/terms', 'SelfAssessmentTermsController@update')->name('terms.update');

        Route::get('/subjects', 'SelfAssessmentSubjectsController@edit')->name('subjects.edit');
        Route::post('/subjects', 'SelfAssessmentSubjectsController@update')->name('subjects.update');
    });

    Route::get('/events', 'EventController@index')->name('events');
    Route::prefix('/events')->name('events.')->group(function(){
        Route::get('/{event}', 'EventController@show')->name('event');
    });

    Route::get('/vacancies', 'VacancyController@index')->name('vacancies');
    Route::prefix('/vacancies')->name('events.')->group(function(){
        Route::get('/{vacancy}', 'VacancyController@show')->name('vacancy');
    });
    /*   Route::get('/', function($account) {

       });
   */
    Route::get('/content/{content}/{slug}', 'ContentController@show')->name('content');

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

    Route::resource('contents', 'ContentController', ['except' => ['show', 'edit', 'update']]);
    Route::post('contents/{content}/make-live', 'ContentController@makeLive')->name('contents.make-live');
    Route::post('contents/{content}/remove-live', 'ContentController@removeLive')->name('contents.remove-live');

    Route::prefix('/contents')->name('contents.')->group(function(){
        Route::resource('articles', 'ContentArticlesController', ['except' => ['show', 'index']]);
        Route::resource('accordions', 'ContentAccordionsController', ['except' => ['show', 'index']]);
    });

    Route::prefix('/tags')->name('tags.')->group(function(){
        Route::resource('subjects', 'TagsSubjectController', ['except' => ['show']]);
    });


    //ajax routes to load the clients / institutions / users in add/edit admin
    Route::post('getClient', 'DropdownController@getClient')->name('getClient');
    Route::post('/getInstitution', 'DropdownController@getInstitution')->name('getInstitution');

});

/* ----------------------- Admin Routes END -------------------------------- */
