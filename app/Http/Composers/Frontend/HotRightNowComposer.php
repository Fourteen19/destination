<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\HotRightNowService;

class HotRightNowComposer
{

    protected $hotRightNowService;

    public function __construct(HotRightNowService $hotRightNowService)
    {
        $this->hotRightNowService = $hotRightNowService;
    }


    public function compose(View $view)
    {

        if (Auth::guard('web')->check())
        {
            //gets dahboard related to the "something different" block
            $dashboardData = Auth::guard('web')->user()->getUserDashboardHotRightNowDetails();
        } else {
            $dashboardData = [];
        }

        //gets the articles for the block
        $articles = $this->hotRightNowService->getHotRightNowArticles($dashboardData);

        $displayHotRightNowArticles = (count($articles) == 4) ? 'Y' : 'N';

        $view->with('displayHotRightNowArticles', $displayHotRightNowArticles);

        if ($displayHotRightNowArticles == 'Y')
        {

            //saves to the dashboard the selected articles.
            $this->hotRightNowService->saveToDashboard($articles);

            $view->with('hotRightNowArticles', $articles);
        }

    }


}
