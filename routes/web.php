<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Middleware\EnsureEventIsAccessible;
use App\Http\Controllers\Admin\ReportUserDataController;
use App\Http\Controllers\Admin\ReportEventsDataController;
use App\Http\Controllers\Admin\ReportRoutesDataController;
use App\Http\Controllers\Admin\ReportRedFlagDataController;
use App\Http\Controllers\Admin\ReportSectorsDataController;
use App\Http\Controllers\Admin\ReportArticlesDataController;
use App\Http\Controllers\Admin\ReportKeywordsDataController;
use App\Http\Controllers\Admin\ReportSubjectsDataController;
use App\Http\Controllers\Admin\ReportVacanciesDataController;
use App\Http\Controllers\Admin\ReportBespokeUserDataController;
use App\Http\Controllers\Admin\ReportCareerReadinessDataController;
use App\Http\Controllers\Admin\ReportNotLoggedInUserDataController;
use App\Http\Controllers\Admin\ReportWorkExperienceActivitiesDataController;
use App\Http\Controllers\Admin\ReportWorkExperienceActivitiesAnswersDataController;

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


$env = App::environment();
if ($env == "staging"){
    $domain = "staging-mydirections.co.uk";
} elseif ($env == "production"){
    $domain = "mydirections.co.uk";
} elseif ($env == "local"){
    $domain = "platformbrand.com";
}




Route::prefix('/')->middleware('web','frontend')->name('www.')->namespace('FrontEnd')->domain('www.'.$domain)->group(function() {
    Route::get('/', 'WwwHomeController@Index')->name('www.home');
    Route::get('/{page}', 'WwwController@Index')->name('www.page');
});



//Public routes for authentication
Route::prefix('/')->middleware('web','frontend')->name('frontend.')->namespace('FrontEnd\Auth')->domain('{clientSubdomain}.'.$domain)->group(function(){

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

    Route::get('refresh-csrf', function() {
        return response()->json(['token' => request()->session()->token() ]);
    })->name('refresh-csrf');

});




//Public routes with authentication
Route::prefix('/')->middleware('web','auth:web','frontend')->name('frontend.')->namespace('FrontEnd')->domain('{clientSubdomain}.'.$domain)->group(function() {

    Route::get('/welcome', 'WelcomeController@index')->name('welcome');
    Route::get('/get-started', 'GetStartedController@index')->name('get-started');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/search/{searchTerm?}', 'SearchController@index')->name('search'); //->where('searchTerm', '[A-Za-z 0-9,]+')

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
        Route::post('/update-my-preferences/update', 'MyPreferencesController@update')->name('update-my-preferences.update');

        Route::get('/view-my-articles', 'myArticlesController@index')->name('my-articles');
        Route::get('/contact-my-adviser', 'ContactAdviserController@index')->name('contact-my-adviser');
        Route::get('/meet-your-adviser', 'MeetYourAdviserController@index')->name('meet-your-adviser');

    });

    Route::get('/article/{article}', 'ArticleController@show')->name('article');
    Route::get('/activity/{activity}', 'ActivityController@show')->name('activity');
    Route::get('/employer/{employer}', 'EmployerController@show')->name('employer');


    Route::get('/completed-activities', 'ActivityController@completedIndex')->name('completed-activities');
    Route::get('/suggested-activities', 'ActivityController@suggestedIndex')->name('suggested-activities');
    Route::get('/employers', 'EmployerController@index')->name('employers');

    Route::get('work-experience', 'WorkExperienceController@show')->name('work-experience');

    Route::get('my-routes', 'MyRoutesController@show')->name('my-routes');
    Route::get('my-subjects', 'MySubjectsController@show')->name('my-subjects');
    Route::get('my-sectors', 'MySectorsController@show')->name('my-sectors');

    Route::prefix('/cv-builder')->name('cv-builder.')->group(function(){
        Route::get('/intro', 'CvBuilderController@index')->name('index');
        Route::get('/edit', 'CvBuilderController@edit')->name('edit');
    });
});




//Public routes without authentication
Route::prefix('/')->middleware('web','frontend')->name('frontend.')->namespace('FrontEnd')->domain('{clientSubdomain}.'.$domain)->group(function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index');
    Route::get('/terms-and-condition', 'TermsController@index')->name('terms');
    Route::get('/privacy-policy', 'PrivacyController@index')->name('privacy');
    Route::get('/cookie-policy', 'CookiesController@index')->name('cookies');
    Route::get('/temp-info', 'InfoController@index')->name('temp-info');

    Route::get('/events', 'EventController@index')->name('events');
    Route::get('/events-search', 'EventController@search')->name('events-search');
    Route::get('/events-best-match', 'EventController@indexBestMatch')->name('events-best-match');
    Route::post('/loadMoreFutureEvents', 'EventController@loadMoreFutureEvents')->name('loadMoreFutureEvents');
    Route::prefix('/events')->name('events.')->group(function(){
        Route::get('/{event}', 'EventController@show')->name('event')->middleware(EnsureEventIsAccessible::class);
    });

    Route::get('/vacancies', 'VacancyController@index')->name('vacancies');
    Route::get('/vacancy/{vacancy}', 'VacancyController@show')->name('vacancy');
    Route::post('/loadMoreVacancies', 'VacancyController@loadMoreVacancies')->name('loadMoreVacancies');
    Route::get('/find-a-job', 'VacancyController@search')->name('find-a-job');

    Route::get('/companies', 'CompanyController@index')->name('companies');
    Route::get('/company/{company}', 'CompanyController@show')->name('company');


    Route::get('/free-article/{article}', 'FreeArticleController@show')->name('free-article');
    Route::get('{page}', 'PageController@show')->name('page');
});


/* ----------------------- Public Routes END -------------------------------- */





/* ----------------------- Admin Routes START -------------------------------- */



/*
Route::get('test_notification', function () {
    $admin = App\Models\Admin\Admin::find(1);

    return (new App\Notifications\adminPasswordResetNotification('00000'))->toMail($admin);
});
*/
Route::prefix('/admin/')->name('admin.')->namespace('Admin\Auth')->domain('www.'.$domain)->group(function(){

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

Route::prefix('/admin/')->middleware('web','auth:admin','admin')->name('admin.')->namespace('Admin')->domain('www.'.$domain)->group(function(){

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('edit-my-profile', 'EditMyProfileController@edit')->name('edit-my-profile.edit');
    Route::patch('edit-my-profile', 'EditMyProfileController@update')->name('edit-my-profile.update');

    Route::resource('roles', 'RoleController', ['except' => ['show']]);

    Route::resource('admins', 'AdminController', ['except' => ['show']]);

    Route::resource('clients', 'ClientController', ['except' => ['show']]);

    Route::resource('employers', 'EmployerController', ['except' => ['show']]);
    Route::resource('vacancies', 'VacancyController', ['except' => ['show']]);
    Route::resource('passed-vacancies', 'PassedVacancyController', ['except' => ['show', 'create', 'edit', 'store', 'update']]);
    Route::post('vacancies/{vacancy}/make-live', 'VacancyController@makeLive')->name('vacancies.make-live');
    Route::post('vacancies/{vacancy}/remove-live', 'VacancyController@removeLive')->name('vacancies.remove-live');

    Route::prefix('/vacancies')->name('vacancies.')->group(function(){
        Route::resource('roles', 'VacancyRoleController', ['except' => ['show']]);
        Route::resource('regions', 'VacancyRegionController', ['except' => ['show']]);
    });

    Route::resource('events', 'EventController', ['except' => ['show']]);
    Route::resource('passed-events', 'PassedEventController', ['except' => ['show', 'create', 'edit', 'store', 'update']]);
    Route::post('events/{event}/make-live', 'EventController@makeLive')->name('events.make-live');
    Route::post('events/{event}/remove-live', 'EventController@removeLive')->name('events.remove-live');

    Route::resource('resources', 'ResourceController', ['except' => ['show']]);

    Route::resource('my-institutions', 'MyInstitutionsController', ['except' => ['show', 'delete', 'create', 'store']]);

    Route::prefix('/tags')->name('tags.')->group(function(){
        Route::resource('subjects', 'TagsSubjectController', ['except' => ['show']]);
        Route::resource('routes', 'TagsRouteController', ['except' => ['show']]);
        Route::resource('sectors', 'TagsSectorController', ['except' => ['show']]);

        Route::post('routes/reorder', 'TagsRouteController@reorder')->name('routes.reorder');
        Route::post('sectors/reorder', 'TagsSectorController@reorder')->name('sectors.reorder');
        Route::post('subjects/reorder', 'TagsSubjectController@reorder')->name('subjects.reorder');

        Route::post('routes/{route}/make-live', 'TagsRouteController@makeLive')->name('routes.make-live');
        Route::post('routes/{route}/remove-live', 'TagsRouteController@removeLive')->name('routes.remove-live');
        Route::post('sectors/{sector}/make-live', 'TagsSectorController@makeLive')->name('sectors.make-live');
        Route::post('sectors/{sector}/remove-live', 'TagsSectorController@removeLive')->name('sectors.remove-live');
        Route::post('subjects/{subject}/make-live', 'TagsSubjectController@makeLive')->name('subjects.make-live');
        Route::post('subjects/{subject}/remove-live', 'TagsSubjectController@removeLive')->name('subjects.remove-live');
    });

    Route::resource('keywords', 'TagsKeywordController', ['except' => ['show']]);
    Route::post('keywords/{keyword}/make-live', 'TagsKeywordController@makeLive')->name('keywords.make-live');
    Route::post('keywords/{keyword}/remove-live', 'TagsKeywordController@removeLive')->name('keywords.remove-live');

    //nested route
    Route::resource('clients.institutions', 'ClientInstitutionController', ['except' => ['show']]);
    Route::patch('clients/{client}/institutions/{institution}/suspend', 'ClientInstitutionController@suspend')->name('clients.institutions.suspend');
    Route::patch('clients/{client}/institutions/{institution}/unsuspend', 'ClientInstitutionController@unsuspend')->name('clients.institutions.unsuspend');

    Route::get('clients/{client}/institutions/{institution}/advisers', 'ClientInstitutionAdviserController@edit')->name('clients.institutions.advisers.edit');
    Route::patch('clients/{client}/institutions/{institution}/advisers', 'ClientInstitutionAdviserController@update')->name('clients.institutions.advisers.update');

    Route::get('clients/{client}/settings', 'ClientController@editSettings')->name('client-settings.edit');
    Route::post('clients/{client}/settings', 'ClientController@updateSettings')->name('client-settings.update');
    Route::patch('clients/{client}/suspend', 'ClientController@suspend')->name('client.suspend');
    Route::patch('clients/{client}/unsuspend', 'ClientController@unsuspend')->name('client.unsuspend');

    Route::resource('users', 'UserController', ['except' => ['show']]);
    Route::get('users/{user}/data', 'UserController@userData')->name('users.user-data');

    Route::get('users/import', 'UserController@import')->name('users.import');
    Route::post('users/import', 'UserController@importing')->name('users.importing');

    Route::get('users/export', 'UserController@export')->name('users.export');
    Route::post('users/export', 'UserController@exporting')->name('users.exporting');

    Route::get('users/batch-transfer', 'UserController@batchTransfer')->name('users.batch-transfer');
    Route::get('users/batch-delete', 'UserController@batchDelete')->name('users.batch-delete');

    //Content at Global level
    Route::prefix('/global')->name('global.')->group(function(){

        Route::resource('contents', 'ContentController', ['except' => ['show', 'edit', 'update']]);
        Route::post('contents/{content}/make-live', 'ContentController@makeLive')->name('contents.make-live');
        Route::post('contents/{content}/remove-live', 'ContentController@removeLive')->name('contents.remove-live');

        Route::prefix('/contents')->name('contents.')->group(function(){
            Route::resource('articles', 'ContentArticlesController', ['except' => ['show', 'index', 'store', 'update']]);
            Route::resource('accordions', 'ContentAccordionsController', ['except' => ['show', 'index', 'store', 'update']]);
            Route::resource('activities', 'ContentActivitiesController', ['except' => ['show', 'index', 'store', 'update']]);
            Route::resource('employers', 'ContentEmployersController', ['except' => ['show', 'index', 'store', 'update']]);
        });

    });

    Route::get('bespoke-report', [ReportBespokeUserDataController::Class, 'index'])->name('bespoke-report');

    Route::get('reports', [ReportController::Class, 'index'])->name('reports');
    Route::prefix('reports')->name('reports.')->group(function(){
        Route::get('user-data', [ReportUserDataController::Class, 'index'])->name('user-data');
        Route::get('not-logged-in', [ReportNotLoggedInUserDataController::Class, 'index'])->name('not-logged-in');
        Route::get('articles', [ReportArticlesDataController::Class, 'index'])->name('articles');
        Route::get('career-readiness', [ReportCareerReadinessDataController::Class, 'index'])->name('career-readiness');
        Route::get('sectors', [ReportSectorsDataController::Class, 'index'])->name('sectors');
        Route::get('subjects', [ReportSubjectsDataController::Class, 'index'])->name('subjects');
        Route::get('routes', [ReportRoutesDataController::Class, 'index'])->name('routes');
        Route::get('keywords', [ReportKeywordsDataController::Class, 'index'])->name('keywords');
        Route::get('red-flag', [ReportRedFlagDataController::Class, 'index'])->name('red-flag');
        Route::get('vacancies', [ReportVacanciesDataController::Class, 'index'])->name('vacancies');
        Route::get('events', [ReportEventsDataController::Class, 'index'])->name('events');
        Route::get('work-experience-activities', [ReportWorkExperienceActivitiesDataController::Class, 'index'])->name('work-experience-activities');
        Route::get('work-experience-activities-answers', [ReportWorkExperienceActivitiesAnswersDataController::Class, 'index'])->name('work-experience-activities-answers');
    });

    //Content at Client level
    Route::resource('contents', 'ContentController', ['except' => ['show', 'edit', 'update']]);
    Route::post('contents/{content}/make-live', 'ContentController@makeLive')->name('contents.make-live');
    Route::post('contents/{content}/remove-live', 'ContentController@removeLive')->name('contents.remove-live');

    Route::prefix('/contents')->name('contents.')->group(function(){
        Route::resource('articles', 'ContentArticlesController', ['except' => ['show', 'index', 'store', 'update']]);
        Route::resource('accordions', 'ContentAccordionsController', ['except' => ['show', 'index', 'store', 'update']]);
        Route::resource('activities', 'ContentActivitiesController', ['except' => ['show', 'index', 'store', 'update']]);
        Route::resource('employers', 'ContentEmployersController', ['except' => ['show', 'index', 'store', 'update']]);
    });
    ///


    //Pages
    Route::resource('pages', 'PageController', ['except' => ['show', 'edit', 'update', 'create', 'store']]);
    Route::post('pages/{page}/make-live', 'PageController@makeLive')->name('pages.make-live');
    Route::post('pages/{page}/remove-live', 'PageController@removeLive')->name('pages.remove-live');
    Route::post('pages/reorder', 'PageController@reorder')->name('pages.reorder');

    Route::prefix('/pages')->name('pages.')->group(function(){
        Route::resource('standard', 'PageStandardController', ['except' => ['show', 'index', 'store', 'update', 'destroy']]);
        //Route::resource('SomeTemplateName', 'PageTemplateNameControllerController', ['except' => ['show', 'index', 'store', 'update']]);
    });

    Route::get('global-settings', 'GlobalSettingsController@index')->name('global-settings');

    Route::get('file-manager', 'FileManagerController@index')->name('file-manager');

    Route::get('static-global-content', 'StaticGlobalContentController@edit')->name('static-global-content.edit');
    Route::post('static-global-content', 'StaticGlobalContentController@update')->name('static-global-content.update');

    Route::get('static-client-content', 'StaticClientContentController@edit')->name('static-client-content.edit');

    Route::get('homepage-settings', 'HomepageSettingsController@index')->name('homepage-settings.edit');

    Route::get('public-homepage', 'ClientHomepageController@edit')->name('public-homepage.edit');

    Route::resource('client-reporting-tags', 'ClientReportingTagsController', ['except' => ['show']]);

    //ajax routes to load the clients / institutions / users in add/edit admin
    Route::post('getClient', 'DropdownController@getClient')->name('getClient');
    Route::post('/getInstitution', 'DropdownController@getInstitution')->name('getInstitution');


});

/* ----------------------- Admin Routes END -------------------------------- */
