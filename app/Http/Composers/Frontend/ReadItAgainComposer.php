<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\ReadItAgainService;

class ReadItAgainComposer
{

    protected $readItAgainService;

    public function __construct(ReadItAgainService $readItAgainService)
    {
        $this->readItAgainService = $readItAgainService;
    }


    public function compose(View $view)
    {

        //gets dahboard related to the "something different" block
        $dashboardData = Auth::guard('web')->user()->getUserDashboardReadItAgainDetails();

        //gets the articles for the block
        $articles = $this->readItAgainService->getAlreadyReadArticlesSummary($dashboardData);

        $displayArticles = (count($articles) == 3) ? 'Y' : 'N';

        $view->with('displayReadItAgainArticles', $displayArticles);

        if ($displayArticles == 'Y')
        {
            //saves to the dashboard the selected articles.
            $this->readItAgainService->saveToDashboard($articles);

            $view->with('readItAgainArticles', $articles);
        }

    }


}
