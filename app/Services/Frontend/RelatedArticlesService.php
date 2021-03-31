<?php

namespace App\Services\Frontend;

use App\Models\ContentLive;
use App\Services\Frontend\PageService;
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




    public function getFreeRelatedArticles($article)
    {

        $pageService = new PageService();
        $page = $pageService->getHomepageDetails();

        $articlesList = [];
        if ( ($page->pageable->free_articles_slot1_page_id != $article->id) && ($page->pageable->free_articles_slot1_page_id != NULL) )
        {
            $articlesList[] = $page->pageable->free_articles_slot1_page_id;
        }

        if ( ($page->pageable->free_articles_slot2_page_id != $article->id) && ($page->pageable->free_articles_slot2_page_id != NULL) )
        {
            $articlesList[] = $page->pageable->free_articles_slot2_page_id;
        }

        if ( ($page->pageable->free_articles_slot3_page_id != $article->id) && ($page->pageable->free_articles_slot3_page_id != NULL) )
        {
            $articlesList[] = $page->pageable->free_articles_slot3_page_id;
        }


        if (count($articlesList) > 0)
        {
            return ContentLive::whereIn('id', $articlesList)->get();
        } else {
            return collect([]);
        }

    }

}
