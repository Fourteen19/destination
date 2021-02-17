<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use App\Http\Controllers\Controller;
use App\Services\Frontend\ArticlesService;

class FreeArticleController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct() {


    }


    /**
     * show
     *
     * @param  mixed $clientSubdomain
     * @param  mixed $article
     * @param  mixed $relatedArticlesService
     * @param  mixed $youMightLikeArticlesService
     * @return void
     */
    public function show(String $clientSubdomain, ContentLive $article)
    {

        return view('frontend.pages.free-articles.show', ['content' => $article]);

    }
}
