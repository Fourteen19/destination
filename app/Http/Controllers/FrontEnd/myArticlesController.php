<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\SystemTag;
use App\Models\ContentLive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Frontend\SelfAssessmentRoutes;

class myArticlesController extends Controller
{
    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct() {

    }




    /**
     * index
     * Display the articles read by a user for the year they are in
     * an article with the same year tag as the user's current year will be displayed
     *
     * @return void
     */
    public function index()
    {
        //gets the list of articles read by the user.  array of IDs
        $myArticles = Auth::guard('web')->user()->articles()->select('id')->get()->pluck('id')->toArray();

        //filters LIVE articles
        //Keeps only the ones seen by the current user
        //  and the ones tagged with the year of the current user
        $myArticlesForthisYear = ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')->WhereIn('id', $myArticles)->get();

        return view('frontend.pages.my-account.my-articles', ['myArticles' => $myArticlesForthisYear]);

    }


}
