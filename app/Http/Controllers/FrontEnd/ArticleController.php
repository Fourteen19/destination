<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
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

        SEOMeta::setTitle($article->title);

        //an article is read - update pivit table, update counters
        $this->articlesService->aUserReadsAnArticle(NULL, $article);

        //determins the feedback form needs to be displayed
        $displayFeedbackForm = $this->articlesService->checkIfDisplayFeedbackForm($article);

        //get the "related" articles
        $relatedArticles = $relatedArticlesService->getRelatedArticles($article);
        $relatedArticlesBlockType = "Related";

        //if no article found
        if (count($relatedArticles) == 0)
        {
            //we look for articles related to the assessment
            $relatedArticlesBlockType = "Other";
            $relatedArticles = $relatedArticlesService->getOtherRelatedArticles($article);
        }

        //get the "Other pages you might like" articles
        $articlesYouMightLike = $youMightLikeArticlesService->getArticlesYouMightLike($article);


        //gets the next article to read
        $nextArticletoRead = $this->articlesService->getNextToReadArticle($article->read_next_article_id);



        //gets the feature article, if set
        $featuredArticles = $this->articlesService->loadFeaturedArticles();

        return view('frontend.pages.articles.show', ['content' => $article,
                                                    'nextArticletoRead' => $nextArticletoRead,
                                                    'relatedArticlesBlockType' => $relatedArticlesBlockType,
                                                    'relatedArticles' => $relatedArticles,
                                                    'articlesYouMightLike' => $articlesYouMightLike,
                                                    'displayFeedbackForm' => $displayFeedbackForm,
                                                    'featuredArticles' => $featuredArticles,
                                                    ]);

    }

}
