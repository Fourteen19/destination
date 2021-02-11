<?php

namespace App\Services\Frontend;

use App\Models\ContentLive;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\ArticlesService;

Class ReadItAgainService
{

    protected $articlesService;

    protected $dashboardService;

    public function __construct(DashboardService $dashboardService, ArticlesService $articlesService)
    {
        $this->articlesService = $articlesService;

        $this->dashboardService = $dashboardService;
    }


    /**
     * getAlreadyReadArticles
     * Used to retrieve title and link of articles already read for the year
     *
     * @return void
     */
    public function getAlreadyReadArticles()
    {

        return ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                        ->join('content_live_user', 'content_live_user.content_live_id', '=', 'contents_live.id')
                                        ->where('content_live_user.user_id', '=', Auth::guard('web')->user()->id)
                                        ->orderBy('content_live_user.updated_at', 'DESC')
                                        ->select('id', 'title', 'slug')
                                        ->get();

    }


    /**
     * getAlreadyReadArticlesSummary
     * Used to retrieve Summary data of articles already read
     * Used in Dashboard "Read It Again" block
     *
     * @return void
     */
    public function getAlreadyReadArticlesSummary($dashboardData)
    {

        $articles_list = [];

        //gets the "something different" details from the dashboard
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
        if (count($articles_list) < 3)
        {

            $articles_list = ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                            ->join('content_live_user', 'content_live_user.content_live_id', '=', 'contents_live.id')
                                            ->where('content_live_user.user_id', '=', Auth::guard('web')->user()->id)
                                            ->select('id', 'summary_heading', 'summary_text', 'slug')
                                            ->orderBy('content_live_user.updated_at', 'DESC')
                                            ->limit(3)
                                            ->get();
        }

        return $articles_list;

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
                $this->dashboardService->assignArticleToDashboardSlot("ria_", $key + 1, $article->id);
            }
        }
    }

}
