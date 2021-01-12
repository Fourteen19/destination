<?php

namespace App\Services\Frontend;

use App\Models\Content;
use App\Models\ContentLive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



Class articlesService
{

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct() {

    }


    /**
     * articleIsRead
     *
     * @param  mixed $article
     * @return void
     */
    public function articleIsRead($article) {

        $this->incrementUserArticleCounter($article->id);

        $this->incrementArticleCounters($article->id);
    }



    /**
     * incrementUserArticleCounter
     * increments the user/article counter
     *
     * @param  mixed $articleId
     * @return void
     */
    private function incrementUserArticleCounter($articleId)
    {
        //increments the article counter for the current user
        Auth::guard('web')->user()->articles()->syncWithoutDetaching([
            $articleId => ['nb_read' => DB::raw('nb_read+1')],
        ]);

    }



    /**
     * incrementArticleCounters
     * increment the article counter
     *
     * @param  mixed $articleId
     * @return void
     */
    private function incrementArticleCounters($articleId)
    {

        $content = Content::find($articleId);
        $content->increment('month_views');
        $content->increment('total_views');
        $content->save();

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
//dd($relatedArticles);
        return $relatedArticles->shuffle()->take(3);

    }


    /**
     * getArticlesForCurrentYearAndTerm
     * selects LIVE articles that
     * are tagged with the same year as the user
     * are tagged with the same term as the current term
     * have been read or not
     * with a list of tags that belong to a Tag type
     * eager load the tags() function associated with the articles
     *
     * @return void
     */
    public function getArticlesForCurrentYearAndTermAndSomeType(Array $tags, String $type, $exclude)
    {

        //Global scope is automatically applied to retrieve global and client related content
        return ContentLive::withAnyTags([ auth()->user()->school_year ], 'year')
                                ->withAnyTags( [ app('currentTerm') ] , 'term')
                                ->withAnyTags( $tags , $type)
                                ->with('tags')
                                ->where('id', '!=', $exclude)
                                ->get(); // eager loads all the tags for the article

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
        $articles = $this->getArticlesForCurrentYearAndTermAndSomeType($tags, $type, $exclude=$article->id);

        return $articles;


/*
        //gets 'route' tags
        $routesTag = $article->tagsWithType('route')->pluck('name', 'id')->toArray();

        //gets 'sector' tags
        $sectorsTag = $article->tagsWithType('sector')->pluck('name', 'id')->toArray();

        //gets 'subject' tags
        $subjectsTag = $article->tagsWithType('subject')->pluck('name', 'id')->toArray();



        //gets articles related to the user filter with 'route' tags
        $routeArticles = $this->getArticlesForCurrentYearAndTermAndSomeType($routesTag, 'route', $exclude=$article->id);

        //gets articles related to the user filter with 'sector' tags
        $sectorArticles = $this->getArticlesForCurrentYearAndTermAndSomeType($sectorsTag, 'sector', $exclude=$article->id);

        //gets articles related to the user filter with 'subject' tags
        $subjectArticles = $this->getArticlesForCurrentYearAndTermAndSomeType($subjectsTag, 'subject', $exclude=$article->id);


        //merge all the articles
        $allArticles = $routeArticles->merge($sectorArticles)->merge($subjectArticles);



        return  $allArticles->shuffle()->take(3);
*/

/*
//        dd($sectors);
       // $matchingRoutesArticlesCollection = ContentLive::withAllTags($routes, 'route')->where('id', '!=', $article->id )->get()->shuffle();
       // $matchingSubjectsArticlesCollection = ContentLive::withAllTags($subjects, 'subject')->where('id', '!=', $article->id )->get()->shuffle();
       // $matchingSectorsArticlesCollection = ContentLive::withAllTags($sectors, 'sector')->where('id', '!=', $article->id )->get()->shuffle();

       $ArticlesBaseCollection = $this->getArticlesForCurrentYearAndTerm();

       $ArticlesBaseCollection->withAllTags($routes, 'route')->get();


       /*
        $matchingRoutesArticlesCollection = ContentLive::withAllTags($routes, 'route')->where('id', '!=', $article->id )->get()->shuffle();

        dd($matchingRoutesArticlesCollection);

        if (!empty($sectors))
        {
            $matchingSubjectsArticlesCollection = ContentLive::withAllTags($subjects, 'subject')->where('id', '!=', $article->id )->get()->shuffle();
        }



        $matchingSectorsArticlesCollection = ContentLive::withAllTags($sectors, 'sector')->where('id', '!=', $article->id )->get()->shuffle();



        dd($matchingSectorsArticlesCollection);
*/
    }



}
