<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\ArticlesService;
use App\Services\Frontend\EmployersService;
use App\Services\Frontend\RelatedArticlesService;
use App\Services\Frontend\YouMightLikeArticlesService;

class ArticleController extends Controller
{

    protected $articlesService;
    protected $employersService;

    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct(ArticlesService $articlesService, EmployersService $employersService) {

        $this->articlesService = $articlesService;
        $this->employersService = $employersService;


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

        //an article is read - update pivot table, update counters
        $this->articlesService->aUserReadsAnArticle(NULL, $article);

        //if NOT employer article
        if ($article->template_id != 4)
        {

            //determins the feedback form needs to be displayed
            $displayFeedbackForm = $this->articlesService->checkIfDisplayFeedbackForm($article);

            //get the "related" articles
            $relatedArticles = $relatedArticlesService->getRelatedArticles($article);
            $relatedArticlesBlockType = "Related";

            //if no article found
           /*  if (count($relatedArticles) == 0)
            { */
                //we look for articles related to the assessment
                $relatedArticlesBlockType = "Other";

                $relatedArticles = $relatedArticlesService->getOtherRelatedArticles($article);
            /* } */

            //get the "Other pages you might like" articles
            $articlesYouMightLike = $youMightLikeArticlesService->getArticlesYouMightLike($article);

            //gets the next article to read
            $nextArticletoRead = $this->articlesService->getNextToReadArticle($article->read_next_article_id);

            //gets the feature article, if set
            $featuredArticles = $this->articlesService->loadFeaturedArticles();

        } else {

            //gets the current employer sectors
            $employerSectors = $article->tagsWithType('sector')->pluck('name')->toArray();

            //returns an employer with similar sector tags
            $relatedEmployer = $this->employersService->getRelatedEmployer($article->id, $employerSectors);

            //returns an article with similar sector tags
            $relatedArticle = $this->employersService->getRelatedArticle($employerSectors);
            //dd($article->employer->first());
            $employer = $article->employer->first();
            if ($employer)
            {
                $employerVacancy = $employer->vacanciesLive->take(1)->first();
            } else {
                $employerVacancy = NULL;
            }

            return view('frontend.pages.employers.show', ['content' => $article,
                                                          'relatedEmployer' => (isset($relatedEmployer)) ? $relatedEmployer : NULL, //only for employer template
                                                          'relatedArticle' => (isset($relatedArticle)) ? $relatedArticle : NULL, //only for employer template
                                                          'vacancy' => (!empty($employerVacancy)) ? $employerVacancy : NULL,
            ]);

        }


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
