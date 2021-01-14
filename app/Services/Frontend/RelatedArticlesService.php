<?php

namespace App\Services\Frontend;

use App\Services\Frontend\ArticlesService;



Class RelatedArticlesService
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
     * getRelatedArticles
     * Loops through the different tags
     * fetches articles relevant to the one being read
     * merges the articles to to a collection
     *
     * @param  mixed $article
     * @return void
     */
    public function getRelatedArticles($article)
    {

        $tagsTypes = ['subject', 'sector', 'route'];

        $relatedArticles = collect([]);

        foreach($tagsTypes as $tagsType){

            $articles = $this->getRelatedArticleByTagsType($article, $tagsType);

            $relatedArticles = $relatedArticles->merge($articles);
        }

        return $relatedArticles->shuffle()->take(3);

    }







    /**
     * getArticleTags
     * get the tags of the current article
     * get relevant articles by type
     * merge all the articles
     *
     * @param  mixed $article
     * @return void
     */
    public function getRelatedArticleByTagsType($article, $type){

        //get the tags of the current article
        $tags = $article->tagsWithType($type)->pluck('name', 'id')->toArray();

        //get relevant articles by type
        return $this->articlesService->getArticlesForCurrentYearAndTermAndSomeType($tags, $type, $exclude=$article->id);

    }

}
