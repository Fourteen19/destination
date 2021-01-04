<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use App\Http\Controllers\Controller;
use App\Services\Frontend\articlesService;

class ArticleController extends Controller
{

    protected $articlesService;

    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct(articlesService $articlesService) {

        $this->articlesService = $articlesService;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(String $clientSubdomain, ContentLive $article)
    {

        //an article is read - update pivot table
        $this->articlesService->articleIsRead($article);


        return view('frontend.pages.articles.show', ['content' => $article]);

    }
}
