<?php

namespace App\Services\Frontend;

use App\Models\ContentLive;
use App\Models\ArticlesMonthlyStats;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Class HotRightNowService
{

    public function __construct()
    {
        //
    }


    /**
     * getHotRightNowArticles
     *
     * @return void
     */
    public function getHotRightNowArticles()
    {

        if (Auth::guard('web')->check())
        {

            $year = Auth::guard('web')->user()->school_year;


            return ContentLive::withoutGlobalScopes()->
                            select('summary_heading', 'summary_text', 'slug')
                            ->join('articles_monthly_stats', 'articles_monthly_stats.content_id', '=', 'contents_live.id')
                            ->where('contents_live.client_id', '=', Auth::guard('web')->user()->client_id)
                            ->orderBy('year_'.$year, 'Desc')
                            ->limit(4)
                            ->get();

        } else {

            return ContentLive::withoutGlobalScopes()->
                            select('summary_heading', 'summary_text', 'slug')
                            ->join('articles_monthly_stats', 'articles_monthly_stats.content_id', '=', 'contents_live.id')
                            ->where('contents_live.client_id', '=', Session::get('fe_client')->id )
                            ->orderBy('total', 'Desc')
                            ->limit(4)
                            ->get();
        }

    }

}
