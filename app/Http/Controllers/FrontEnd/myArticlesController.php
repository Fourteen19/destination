<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\ReadItAgainService;

class myArticlesController extends Controller
{

    protected $readItAgainService;


    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct(ReadItAgainService $readItAgainService) {

        $this->readItAgainService = $readItAgainService;

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

        //gets the list of articles read by the user.
        //joins with the 'content_live_user' table
        //sorts
        $myArticlesForthisYear = $this->readItAgainService->getAlreadyReadArticles();


        return view('frontend.pages.my-account.my-articles', ['myArticles' => $myArticlesForthisYear]);

    }


}
