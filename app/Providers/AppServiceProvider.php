<?php

namespace App\Providers;

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

        //$this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        //$this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
//dd($this->app->request);




        Validator::extend('tag_exists_with_type', function ($attribute, $value, $parameters, $validator) {
            list($tagType, $tagId) = $parameters;
            return (new TagExistsWithType($tagType, $tagId))->passes($attribute, $value);
        });

        Validator::extend('keyword_tag_exists_with_type', function ($attribute, $value, $parameters, $validator) {
            list($tagType, $tagId, $clientId) = $parameters;
            return (new KeywordTagExistsWithType($tagType, $tagId, $clientId))->passes($attribute, $value);
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

            $automnWinterTerm = "Automn-Winter";
            $springTerm = "Spring";
            $summerTerm = "Summer";

            if ($month <= 3){
                $currentTerm = $springTerm;
            } elseif ( ($month > 3) && ($month < 9) ){
                $currentTerm = $summerTerm;
            } else {
                $currentTerm = $automnWinterTerm;
            }

            return $currentTerm;

        });


    }
}
