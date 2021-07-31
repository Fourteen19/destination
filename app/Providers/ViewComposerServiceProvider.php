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
        $this->composeFrontendViews();

    }



    /**
     * composeAdvisorDetails
     * compose the adviser details in footer & my account
     *
     * @return void
     */
    private function composeFrontendViews()
    {

        //articles
        view()->composer(['frontend.pages.includes.footer', 'frontend.pages.includes.account-menu', 'frontend.pages.my-account.contact-my-adviser'], '\App\Http\Composers\Frontend\AdvisorDetailsComposer@compose');
        view()->composer(['frontend.pages.includes.footer'], '\App\Http\Composers\Frontend\FooterDetailsComposer@compose');
        view()->composer(['frontend.layouts.master'], '\App\Http\Composers\Frontend\ChatAppComposer@compose');
        view()->composer(['frontend.pages.includes.hot-right-now'], '\App\Http\Composers\Frontend\HotRightNowComposer@compose');
        view()->composer(['frontend.pages.includes.read-it-again'], '\App\Http\Composers\Frontend\ReadItAgainComposer@compose');
        view()->composer(['frontend.pages.includes.something-different'], '\App\Http\Composers\Frontend\SomethingDifferentComposer@compose');
        view()->composer(['frontend.pages.includes.header-fixed-links', 'frontend.pages.includes.footer-fixed-links'], '\App\Http\Composers\Frontend\FixedLinksComposer@compose');

        //activities
        view()->composer(['frontend.pages.includes.activities.suggested-activities'], '\App\Http\Composers\Frontend\Activities\SuggestedActivitiesComposer@compose');
        view()->composer(['frontend.pages.includes.activities.completed-activities'], '\App\Http\Composers\Frontend\Activities\CompletedActivitiesComposer@compose');

        //employers
        view()->composer(['frontend.pages.includes.employers.featured-employers'], '\App\Http\Composers\Frontend\Employers\FeaturedEmployersComposer@compose');

        // "Upcoming Event" if not logged in
        view()->composer(['frontend.pages.home', 'frontend.pages.dashboard'], '\App\Http\Composers\Frontend\Events\EventsYouMightLikeComposer@compose');

        //vacancies
        view()->composer(['frontend.pages.includes.vacancies.latest-vacancies'], '\App\Http\Composers\Frontend\Vacancies\LatestVacanciesComposer@compose');
    }

}
