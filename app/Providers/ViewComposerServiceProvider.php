<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * https://laracasts.com/series/laravel-5-fundamentals/episodes/25
     *
     * @return void
     */
    public function boot()
    {
        $this->composeAdvisorDetails();

    }



    /**
     * composeAdvisorDetails
     * compose the adviser details in footer & my account
     *
     * @return void
     */
    private function composeAdvisorDetails()
    {

        view()->composer('frontend.pages.includes.footer', '\App\Http\Composers\Frontend\AdvisorDetailsComposer@compose');

    }

}
