<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use App\Http\Controllers\Controller;
use App\Services\Frontend\ArticlesService;
use App\Services\Frontend\RelatedArticlesService;
use App\Services\Frontend\YouMightLikeArticlesService;

class ArticleController extends Controller
{

    protected $articlesService;

    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct(ArticlesService $articlesService) {

        $this->articlesService = $articlesService;

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
    public function show(String $clientSubdomain, ContentLive $article, RelatedArticlesService $relatedArticlesService, YouMightLikeArticlesService $youMightLikeArticlesService)
    {

        //an article is read - update pivit table, update counters
        $this->articlesService->aUserResadsAnArticle(NULL, $article);

        //determins the feedback form needs to be displayed
        $displayFeedbackForm = $this->articlesService->checkIfDisplayFeedbackForm($article);

        //get the "related" articles
        $relatedArticles = $relatedArticlesService->getRelatedArticles($article);

        //get the "you might like" articles
        $articlesYouMightLike = $youMightLikeArticlesService->getArticlesYouMightLike($article);

        return view('frontend.pages.articles.show', ['content' => $article,
                                                    'relatedArticles' => $relatedArticles,
                                                    'articlesYouMightLike' => $articlesYouMightLike,
                                                    'displayFeedbackForm' => $displayFeedbackForm
                                                    ]);

    }
}
