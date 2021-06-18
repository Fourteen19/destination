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

        //filters the collection to remove NULL values ( NULL values represent articles removed from live)
        $filteredArticlesCollection = $articles->filter(function ($value) { return !is_null($value); });

        //checks if we have 3 articles
        $nbArticlesToGet = 3 - count($filteredArticlesCollection);

        //if not, we need to get some extra articles
        if ($nbArticlesToGet > 0)
        {

            //gets extra articles
            $extraArticles = $this->somethingDifferentService->getRandomArticleForCurrentYearAndTerm( 3 - count($filteredArticlesCollection), $exclude=$filteredArticlesCollection );

            //merges the new articles found with the ones found before
            $filteredArticlesCollection = $filteredArticlesCollection->merge($extraArticles);
        }

        $displayArticles = "Y";

        //saves to the dashboard the selected articles.
        $this->somethingDifferentService->saveToDashboard($filteredArticlesCollection);

        $view->with('somethingDifferentArticles', $filteredArticlesCollection);

        $view->with('displaySomethingDifferentArticles', $displayArticles);

    }


}
