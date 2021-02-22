<?php

namespace App\Providers;


//use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
//use Illuminate\Pagination\LengthAwarePaginator;
/*
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\AdminRepositoryInterface;
use App\Repositories\Eloquent\AdminRepository;
use App\Repositories\EloquentRepositoryInterface;
*/

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
            return new \App\Services\Frontend\selfAssessmentService();
        });

        $this->app->singleton('clientContentSettigsSingleton', function()
        {
            return new \App\Services\Frontend\clientContentSettigsService();
        });

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
