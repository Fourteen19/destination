<?php

namespace App\Services\Frontend;

use Illuminate\Support\Arr;


Class YouMightLikeArticlesService
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
     * getArticlesYouMightLike
     * get the articles that have not been read
     * filters the articles by route, subject, sector, career readiness
     * gets the global articles
     * merges the articles to to a collection
     *
     * @param  mixed $article
     * @return void
     */
    public function getArticlesYouMightLike($article)
    {

        //get the articles that have not been read
        $articles = $this->articlesService->getAllReadUnreadArticles();

        //filters the articles by route
        $routeArticles = $this->articlesService->getRouteArticles($articles);

        //filters the articles by subject
        $subjectArticles = $this->articlesService->getSubjectArticles($articles);

        //filters the articles by sector
        $sectorArticles = $this->articlesService->getSectorArticles($articles);

        //filters the articles by career readiness
        $careerArticles = $this->articlesService->getCareerArticles($articles);

        //gets the global articles
        $globalArticles = $this->articlesService->getGlobalArticles($articles);

        //merges the articles into 1 array
        //shuffles the articles
        //slices the array to only keep the first 4 articles
        return array_slice( Arr::shuffle( array_merge($routeArticles, $subjectArticles, $sectorArticles, $careerArticles, $globalArticles) ), 0, 4);

    }

}
