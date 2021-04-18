<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\SomethingDifferentService;

class SomethingDifferentComposer
{

    protected $somethingDifferentService;

    public function __construct(SomethingDifferentService $somethingDifferentService)
    {
        $this->somethingDifferentService = $somethingDifferentService;
    }


    public function compose(View $view)
    {

        //gets dashborad articles attached to the "something different" block
        $dashboardData = Auth::guard('web')->user()->getUserDashboardSomethingDifferentDetails();

        //gets the articles for the block
        $articles = $this->somethingDifferentService->getSomethingDifferentArticlesSummary($dashboardData);

        //check if we have enough articles to display the block
        //$displayArticles = (count($articles) == 3) ? 'Y' : 'N';

        //checks if we have 3 articles
        $nbArticlesToGet = 3 - count($articles);

        //if not, we need to get some extra articles
        if ($nbArticlesToGet > 0)
        {
            $extraArticles = $this->somethingDifferentService->getRandomArticleForCurrentYearAndTerm( 3 - count($articles), $exclude=$articles );

            //merges the new articles found with the ones found before
            $articles = $articles->merge($extraArticles);
        }

        $displayArticles = "Y";


      /*   //if yes
        if ($displayArticles == 'Y')
        { */

            //saves to the dashboard the selected articles.
            $this->somethingDifferentService->saveToDashboard($articles);

            $view->with('somethingDifferentArticles', $articles);
        /* } */

        $view->with('displaySomethingDifferentArticles', $displayArticles);


    }


}
