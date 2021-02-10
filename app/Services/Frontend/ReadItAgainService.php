<?php

namespace App\Services\Frontend;

use App\Models\ContentLive;
use Illuminate\Support\Facades\Auth;

Class ReadItAgainService
{

    public function __construct()
    {
        //
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
     *
     * @return void
     */
    public function getAlreadyReadArticlesSummary()
    {

        return ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                        ->join('content_live_user', 'content_live_user.content_live_id', '=', 'contents_live.id')
                                        ->where('content_live_user.user_id', '=', Auth::guard('web')->user()->id)
                                        ->orderBy('content_live_user.updated_at', 'DESC')
                                        ->select('summary_heading', 'summary_text', 'slug')
                                        ->limit(3)
                                        ->get();

    }

}
