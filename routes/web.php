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
    Route::get('/events', 'EventController@index')->name('events');
    Route::prefix('/events')->name('events.')->group(function(){
        Route::get('/{event}', 'EventController@show')->name('event');
    });

    Route::get('/vacancies', 'VacancyController@index')->name('vacancies');
    Route::prefix('/vacancies')->name('events.')->group(function(){
        Route::get('/{vacancy}', 'VacancyController@show')->name('vacancy');
    });
});


//Public routes with authentication
Route::prefix('/')->middleware('web','auth:web','frontend')->name('frontend.')->namespace('FrontEnd')->domain('{clientSubdomain}.platformbrand.com')->group(function() {

    //Route::get('/home', 'WelcomeController@index')->name('home');
    Route::get('/welcome', 'WelcomeController@index')->name('welcome');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/search', 'SearchController@index')->name('search');

    Route::prefix('/self-assessment')->name('self-assessment.')->group(function(){

        Route::get('/career-readiness', 'SelfAssessmentCareerReadinessController@edit')->name('career-readiness.edit');
        Route::put('/career-readiness', 'SelfAssessmentCareerReadinessController@update')->name('career-readiness.update');

        Route::get('/subjects', 'SelfAssessmentSubjectsController@edit')->name('subjects.edit');
        Route::put('/subjects', 'SelfAssessmentSubjectsController@update')->name('subjects.update');

        Route::get('/routes', 'SelfAssessmentRoutesController@edit')->name('routes.edit');
        Route::put('/routes', 'SelfAssessmentRoutesController@update')->name('routes.update');

        Route::get('/sectors', 'SelfAssessmentSectorsController@edit')->name('sectors.edit');
        Route::put('/sectors', 'SelfAssessmentSectorsController@update')->name('sectors.update');

        Route::get('/completed', 'SelfAssessmentCompletedController@index')->name('completed');

    });

    Route::get('/my-account', 'myAccountController@index')->name('my-account');

    Route::prefix('/my-account')->name('my-account.')->group(function(){

        Route::get('/update-my-preferences', 'MyPreferencesController@edit')->name('update-my-preferences.edit');
        Route::post('/update-my-preferences', 'MyPreferencesController@update')->name('update-my-preferences.update');

        Route::get('/view-my-articles', 'myArticlesController@index')->name('my-articles');
        Route::get('/contact-my-adviser', 'ContactAdviserController@index')->name('contact-my-adviser');

    });


    /*   Route::get('/', function($account) {

       });
   */
    Route::get('/article/{article}', 'ArticleController@show')->name('article');

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

    Route::resource('vacancies', 'VacancyController', ['except' => ['show']]);

    Route::resource('events', 'EventController', ['except' => ['show']]);

    Route::resource('resources', 'ResourceController', ['except' => ['show']]);

    Route::prefix('/tags')->name('tags.')->group(function(){
        Route::resource('subjects', 'TagsSubjectController', ['except' => ['show']]);
        Route::resource('routes', 'TagsRouteController', ['except' => ['show']]);
        Route::resource('sectors', 'TagsSectorController', ['except' => ['show']]);

        Route::post('routes/reorder', 'TagsRouteController@reorder')->name('routes.reorder');
        Route::post('sectors/reorder', 'TagsSectorController@reorder')->name('sectors.reorder');
        Route::post('subjects/reorder', 'TagsSubjectController@reorder')->name('subjects.reorder');
    });

    //nested route
    Route::resource('clients.institutions', 'ClientInstitutionController', ['except' => ['show']]);
    //Route::resource('clients.institutions.users', 'ClientInstitutionUserController', ['except' => ['show']]);

    Route::get('clients/{client}/client-branding', 'ClientController@editBranding')->name('client-branding.edit');
    Route::post('clients.client-branding', 'ClientController@updateBranding')->name('client-branding.update');

    Route::resource('users', 'UserController', ['except' => ['show']]);
    Route::get('users/{user}/data', 'UserController@userData')->name('users.user-data');

    Route::get('users/import', 'UserController@import')->name('users.import');
    Route::post('users/import', 'UserController@importing')->name('users.importing');

    Route::get('users/export', 'UserController@export')->name('users.export');
    Route::post('users/export', 'UserController@exporting')->name('users.exporting');


    //Content at Global level
    Route::prefix('/global')->name('global.')->group(function(){

        Route::resource('contents', 'ContentController', ['except' => ['show', 'edit', 'update']]);
        Route::post('contents/{content}/make-live', 'ContentController@makeLive')->name('contents.make-live');
        Route::post('contents/{content}/remove-live', 'ContentController@removeLive')->name('contents.remove-live');

        Route::prefix('/contents')->name('contents.')->group(function(){
            Route::resource('articles', 'ContentArticlesController', ['except' => ['show', 'index', 'store', 'update']]);
            Route::resource('accordions', 'ContentAccordionsController', ['except' => ['show', 'index', 'store', 'update']]);
        });

    });
    //

    //Content at Client level
    Route::resource('contents', 'ContentController', ['except' => ['show', 'edit', 'update']]);
    Route::post('contents/{content}/make-live', 'ContentController@makeLive')->name('contents.make-live');
    Route::post('contents/{content}/remove-live', 'ContentController@removeLive')->name('contents.remove-live');

    Route::prefix('/contents')->name('contents.')->group(function(){
        Route::resource('articles', 'ContentArticlesController', ['except' => ['show', 'index', 'store', 'update']]);
        Route::resource('accordions', 'ContentAccordionsController', ['except' => ['show', 'index', 'store', 'update']]);
    });
    ///


    Route::get('global-settings', 'GlobalSettingsController@index')->name('global-settings');

    Route::get('file-manager', 'FileManagerController@index')->name('file-manager');

    Route::get('static-global-content', 'StaticGlobalContentController@edit')->name('static-global-content.edit');
    Route::post('static-global-content', 'StaticGlobalContentController@update')->name('static-global-content.update');

    Route::get('static-client-content', 'StaticClientContentController@edit')->name('static-client-content.edit');
    Route::post('static-global-content', 'StaticClientContentController@update')->name('static-client-content.update');


    Route::resource('pages', 'PageController', ['except' => ['show']]);
    Route::get('public-homepage', 'clientHomepageController@edit')->name('public-homepage.edit');
    Route::post('public-homepage', 'clientHomepageController@update')->name('public-homepage.update');

    Route::resource('client-reporting-tags', 'ClientReportingTagsController', ['except' => ['show']]);

    //ajax routes to load the clients / institutions / users in add/edit admin
    Route::post('getClient', 'DropdownController@getClient')->name('getClient');
    Route::post('/getInstitution', 'DropdownController@getInstitution')->name('getInstitution');

});

/* ----------------------- Admin Routes END -------------------------------- */
