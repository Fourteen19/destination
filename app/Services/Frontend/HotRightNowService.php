<?php

namespace App\Services\Frontend;

use App\Models\ContentLive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\Frontend\DashboardService;

Class HotRightNowService
{

    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }


    /**
     * getHotRightNowArticles
     *
     * @return void
     */
    public function getHotRightNowArticles($dashboardData)
    {

        if (Auth::guard('web')->check())
        {

            $articles_list = [];

            //gets the "Hot Right Now" details from the dashboard
            $dashboardDataSlots = $dashboardData->get()->first()->toArray();

            //foreach slot, load the article's summary data
            foreach($dashboardDataSlots as $key => $slotArticleId)
            {
                if (!empty($slot))
                {
                    $articles_list[] = $this->articlesService->loadLiveArticle($slotArticleId);
                }

            }

            //if the 3 slots have not been filled in, load more
            if (count($articles_list) < 4)
            {

                $year = Auth::guard('web')->user()->school_year;

                return ContentLive::withoutGlobalScopes()->
                                select('contents_live.id', 'summary_heading', 'summary_text', 'slug')
                                ->join('articles_monthly_stats', 'articles_monthly_stats.content_id', '=', 'contents_live.id')
                                ->withAnyTags( [ app('currentTerm') ] , 'term')
                                ->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                ->where('contents_live.client_id', '=', Auth::guard('web')->user()->client_id)
                                ->orWhere('contents_live.client_id', '=', NULL)
                                ->orderBy('year_'.$year, 'Desc')
                                ->limit(4)
                                ->get();

            }

        } else {

            return ContentLive::withoutGlobalScopes()->
                            select('contents_live.id', 'summary_heading', 'summary_text', 'slug')
                            ->join('articles_monthly_stats', 'articles_monthly_stats.content_id', '=', 'contents_live.id')
                            ->where('contents_live.client_id', '=', Session::get('fe_client')->id )
                            ->orWhere('contents_live.client_id', '=', NULL)
                            ->orderBy('total', 'Desc')
                            ->limit(4)
                            ->get();
        }

    }


    /**
     * saveToDashboard
     *
     * @param  mixed $articles
     * @return void
     */
    public function saveToDashboard($articles)
    {

        foreach($articles as $key => $article){
            if (!empty($article))
            {
                $this->dashboardService->assignArticleToDashboardSlot("hrn_", $key + 1, $article->id);
            }

        }
    }

}
