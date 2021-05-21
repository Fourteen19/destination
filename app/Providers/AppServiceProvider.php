<?php

namespace App\Providers;

use App\Rules\FileExists;
use App\Rules\TagExistsWithType;
use Illuminate\Support\Facades\Schema;
use App\Rules\KeywordTagExistsWithType;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        //creates a singleton class that can keep track of the self assessment for your current user
        //$selfAssessmentSingleton = $this->app->singleton(\App\Services\Frontend\selfAssessmentService::class);
        $selfAssessmentSingleton = $this->app->singleton('selfAssessmentSingleton', function()
        {
            return new \App\Services\Frontend\SelfAssessmentService();
        });

        $this->app->singleton('clientContentSettigsSingleton', function()
        {
            $pageService = new \App\Services\Admin\PageService();
            return new \App\Services\Frontend\ClientContentSettigsService($pageService);
        });


        $this->app->singleton('clientService', \App\Services\Admin\ClientService::class );


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);

        \App\Models\Admin\Admin::observe(\App\Observers\Admin\AdminObserver::class);
        \App\Models\Client::observe(\App\Observers\ClientObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Institution::observe(\App\Observers\InstitutionObserver::class);
        \App\Models\Content::observe(\App\Observers\ContentObserver::class);
        \App\Models\ContentLive::observe(\App\Observers\ContentLiveObserver::class);
        \App\Models\SystemTag::observe(\App\Observers\SystemTagObserver::class);
        \App\Models\SystemKeywordTag::observe(\App\Observers\SystemKeywordTagObserver::class);
        \App\Models\Page::observe(\App\Observers\PageObserver::class);
        \App\Models\RelatedQuestion::observe(\App\Observers\RelatedQuestionObserver::class);
        \App\Models\RelatedVideo::observe(\App\Observers\RelatedVideoObserver::class);
        \App\Models\RelatedLink::observe(\App\Observers\RelatedLinkObserver::class);
        \App\Models\RelatedActivityQuestion::observe(\App\Observers\RelatedActivityQuestionObserver::class);
        \App\Models\Resource::observe(\App\Observers\ResourceObserver::class);



        Validator::extend('tag_exists_with_type', function ($attribute, $value, $parameters, $validator) {
            list($tagType, $tagId) = $parameters;
            return (new TagExistsWithType($tagType, $tagId))->passes($attribute, $value);
        });

        Validator::extend('keyword_tag_exists_with_type', function ($attribute, $value, $parameters, $validator) {
            list($tagType, $tagId, $clientId) = $parameters;
            return (new KeywordTagExistsWithType($tagType, $tagId, $clientId))->passes($attribute, $value);
        });

        Validator::extend('file_exists', function ($attribute, $value, $parameters, $validator) {
            return (new FileExists($value))->passes($attribute, $value);
        });

        /**
         *
         * This is used for tinymce
         * Compiles the current URL and use it to create relative URLs when adding images
         *
         */
        $url = $this->app->request->getHost();
        $protocol = 'http://'; //( ) ? ‘https://’ : ‘http://’;
        $port = $this->app->request->getPort();
        $addressUrl = $protocol.$url;
        if ($port != 80)
        {
            $addressUrl .= ":".$port;
        }

        config()->set('app.url', $addressUrl);


        /************************ */


        $this->app->singleton('currentTerm', function($app) {

            $month = date("m");

            if ($month <= 3){
                $currentTerm = config('global.terms.spring');
            } elseif ( ($month > 3) && ($month < 9) ){
                $currentTerm = config('global.terms.summer');
            } else {
                $currentTerm = config('global.terms.autumn');
            }

            return $currentTerm;

        });


    }
}
