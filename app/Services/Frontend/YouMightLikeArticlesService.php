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

        //get the all the articles read / unread
        $articles = $this->articlesService->getAllReadUnreadArticles();

        //filters the articles by route
        list($routeArticles, $routeArticlesType) = $this->articlesService->getRouteArticles($articles);

        //filters the articles by subject
        list($subjectArticles, $subjectArticlesType) = $this->articlesService->getSubjectArticles($articles);

        //filters the articles by sector
        list($sectorArticles, $sectorArticlesType) = $this->articlesService->getSectorArticles($articles);

        //filters the articles by career readiness
        list($careerArticles, $careerArticlesType) = $this->articlesService->getCareerArticles($articles);

        //gets the global articles
        list($globalArticles, $globalArticlesType) = $this->articlesService->getGlobalArticles($articles);

        //merges the articles into 1 collection
        $articlesCollection = array_merge($routeArticles, $subjectArticles, $sectorArticles, $careerArticles, $globalArticles);

        //removes duplicates
        //shuffles the articles
        //slices the collection to only keep the first 4 articles
        //returns collection
        return collect($articlesCollection)->unique()->shuffle()->slice(0, 4);

    }

}
