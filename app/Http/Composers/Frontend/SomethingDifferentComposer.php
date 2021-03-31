<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\SomethingDifferentService;

class SomethingDifferentComposer
{

    protected $readItAgainService;

    public function __construct(SomethingDifferentService $somethingDifferentService)
    {
        $this->somethingDifferentService = $somethingDifferentService;
    }


    public function compose(View $view)
    {

        //gets dahboard related to the "something different" block
        $dashboardData = Auth::guard('web')->user()->getUserDashboardSomethingDifferentDetails();

        //gets the articles for the block
        $articles = $this->somethingDifferentService->getSomethingDifferentArticlesSummary($dashboardData);

        //check if we have enough articles to display the block
        $displayArticles = (count($articles) == 3) ? 'Y' : 'N';

        //if yes
        if ($displayArticles == 'Y')
        {

            //saves to the dashboard the selected articles.
            $this->somethingDifferentService->saveToDashboard($articles);

            $view->with('somethingDifferentArticles', $articles);
        }

        $view->with('displaySomethingDifferentArticles', $displayArticles);


    }


}
