<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use App\Http\Controllers\Controller;
use App\Services\Frontend\PageService;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\ArticlesService;
use App\Services\Frontend\RelatedArticlesService;
use App\Services\Frontend\ClientContentSettigsService;

class FreeArticleController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct() {
        //
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
    public function show(String $clientSubdomain, ContentLive $article, RelatedArticlesService $relatedArticlesService, ArticlesService $articlesService)
    {

        //check if the article is free
        if ($articlesService->checkIfArticleIsFree($article))
        {

            SEOMeta::setTitle($article->title);

            $freeArticleMessage = app('clientContentSettigsSingleton')->getFreeArticlesMessage();

            //get the "related" articles
            $freeRelatedArticles = $relatedArticlesService->getFreeRelatedArticles($article);

            return view('frontend.pages.free-articles.show', ['content' => $article, 'relatedArticles' => $freeRelatedArticles, 'freeArticleMessage' => $freeArticleMessage['free_articles_message']]);

        } else {
            abort(404);
        }

    }
}
