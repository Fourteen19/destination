<?php

namespace App\Services\Frontend;

use App\Models\ContentLive;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;

Class ArticlesSearchService
{

    public $resArticlesByKeyword;
    public $resArticlesByRoute;
    public $resArticlesBySector;
    public $resArticlesWithExactTitle;
    public $resArticlesContainsInTitle;
    public $resArticlesContainsInLead;
    public $resArticlesContainsInSummary;



    public function __construct()
    {
        //
    }



    /**
     * getMyArticlesWithKeyword
     * Search articles using a keyword
     *
     * @param  mixed $searchArticlesString
     * @return void
     */
    public function getMyArticlesWithKeyword($searchArticlesString)
    {

        //dd("the keyword is:".$searchArticlesString);

        return $this->processSearch($searchArticlesString);

    }

    /**
     * getMyArticlesWithString
     * Search articles using an unfiltered string
     *
     * @param  mixed $searchArticlesString
     * @return void
     */
    public function getMyArticlesWithString($searchArticlesString)
    {

        return $this->processSearch($searchArticlesString);

    }



    /**
     * getKeywordsFromSearchString
     *
     * @param  mixed $orginalSearchArticlesString
     * @return void
     */
    public function getKeywordsFromSearchString($orginalSearchArticlesString){

        $searchString = remove_common_words( strtolower($orginalSearchArticlesString) );

        //After removing the common words, check if we have any word left
        if (!empty($searchString))
        {

            $searchString = explode(" ", $searchString);

            $query = SystemKeywordTag::where("client_id", Session::get('fe_client')->id)
                                    ->select('name', 'slug')
                                    ->where("live", '=', 'Y')
                                    ->where(function($query) use ($searchString) {
                                        foreach ($searchString as $string)
                                        {
                                            if (!empty($string))
                                                $query->orwhere("slug", "LIKE", "%".$string."%");
                                        }
                                    });

            $res = $query->get()->toArray();

            $keywords = [];
            foreach($res as $key => $value){
                $keywords[] = [
                                'name' => $value['name'][app()->getLocale()],
                                'slug' => $value['slug'][app()->getLocale()]
                            ];
            }

        } else {

            $keywords = [];

        }

        return $keywords;

    }






    private function searchForArticlesWithAllTags($articlesHaystack, $keywords, $type = NULL)
    {

        if (count($keywords) == 0){
            return NULL;
        }

        //search for articles with all the tags
        $articlesWithAllTags = $articlesHaystack->filter(function ($article, $key) use ($keywords, $type) {


            //gets all the articles keywords
            $articleKeywords = $article->tagsWithType($type)->pluck('slug')->toArray();

            //compare the keywords typed in and the ones attached to the article
            $result = array_intersect($articleKeywords, $keywords);

            //if perfect match, this article has all the keywords tags
            if ( (count($result) == count($articleKeywords)) && (count($result) > 0) )
            {
                return $article;
            }

        });

        return $articlesWithAllTags;

    }





    private function searchForArticlesWithAnyTags($articlesHaystack, $keywords, $type = NULL)
    {

        if (count($keywords) == 0){
            return NULL;
        }



        //search for articles with any of the tags
        $articlesWithAnyKeyword = $articlesHaystack->filter(function ($article, $key) use ($keywords, $type) {

            //gets all the articles keywords
            $articleKeywords = $article->tagsWithType($type)->pluck('slug')->toArray();

            //compare the keywords typed in and the ones attached to the article
            $result = array_intersect($articleKeywords, $keywords);

            //if perfect match, this article has all the keywords tags
            if (count($result) > 0){

                $article->searchFilterScore = count($result);
                return $article;
            }

        });

        return $articlesWithAnyKeyword->sortBy('searchFilterScore');

    }



    /**
     * attachKeywordToUser
     * Attach keyword to the list of keywords used by a user in searches
     *
     * @param  mixed $keyword
     * @return void
     */
    public function attachKeywordToUser($keyword)
    {

        //fetches the tag by name
        $tag = SystemKeywordTag::matching($keyword)->where('type', 'keyword')->select('id', 'uuid', 'name')->first();

        if ($tag)
        {

            //if the tag has not been attached to the user yet
            if (!Auth::guard('web')->user()->searchedKeywords()->where('system_keyword_tag_id', '=', $tag->id)->exists() )
            {

                //if the tag exists
                if ($tag)
                {
                    //attaches the keyword tag against the current user
                    Auth::guard('web')->user()->searchedKeywords()->attach($tag->id);
                }

            }

        }

    }



    private function processSearch($orginalSearchArticlesString)
    {

        // SELECTING
        //selects all the articles relevant to the year

        //if the logged in user is a user
        if (Auth::guard('web')->user()->type == 'user'){

            $allYearArticle = ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                            ->leftjoin('content_articles_live as t', 't.id', '=', 'contents_live.contentable_id')
                            ->leftjoin('content_accordions_live as t1', 't1.id', '=', 'contents_live.contentable_id')
                            ->select('contents_live.id', 'contents_live.template_id', 't.title', 't.lead', 't1.title', 't1.lead', 't2.title', 't2.lead', 'contents_live.slug', 'contents_live.summary_heading', 'contents_live.summary_text')
                            ->with('tags');
                            //->get();
                            // eager loads all the tags for the article

            //if the user's institution has the "work experience" section enabled
            if (Auth::guard('web')->user()->institution->work_experience == 'Y')
            {

                $allYearArticle = $allYearArticle->leftjoin('content_employers_live as t2', 't2.id', '=', 'contents_live.contentable_id')
                                                 ->whereIn('template_id', [1, 2, 4])
                                                 ->get();

            } else {

                $allYearArticle = $allYearArticle->whereIn('template_id', [1, 2])
                                                 ->get();

            }


        //if the logged in user is an admin,  we ignore the year as we want to be able to access all articles
        } elseif (Auth::guard('web')->user()->type == 'admin'){

            $allYearArticle = ContentLive::leftjoin('content_articles_live as t', 't.id', '=', 'contents_live.contentable_id')
                            ->leftjoin('content_accordions_live as t1', 't1.id', '=', 'contents_live.contentable_id')
                            ->leftjoin('content_employers_live as t2', 't2.id', '=', 'contents_live.contentable_id')
                            ->select('contents_live.id', 't.title', 't.lead', 't1.title', 't1.lead', 't2.title', 't2.lead', 'contents_live.slug', 'contents_live.summary_heading', 'contents_live.summary_text')
                            ->with('tags');
                            //->get();

            //if the user's institution has the "work experience" section enabled
            if (Auth::guard('web')->user()->institution->work_experience == 'Y')
            {

                $allYearArticle = $allYearArticle->leftjoin('content_employers_live as t2', 't2.id', '=', 'contents_live.contentable_id')
                                                    ->whereIn('template_id', [1, 2, 4])
                                                    ->get();

            } else {

                $allYearArticle = $allYearArticle->whereIn('template_id', [1, 2])
                                                 ->get();

            }

        } else {
            abort(404);
        }


        //extracts keywords from string
        $extractedKeywords = $this->getKeywordsFromSearchString($orginalSearchArticlesString);

        //dd($extractedKeywords);

        $keywords = [];
        if (count($extractedKeywords) >0)
        {
            foreach($extractedKeywords as $key => $value){
                $keywords[] = $value['slug'];
            }
        }
        //dd($keywords);



        $lowercaseSearchArticlesString = strtolower($orginalSearchArticlesString);
        //dd($lowercaseSearchArticlesString);



        $articlesWithAllKeyword = $this->searchForArticlesWithAllTags($allYearArticle, $keywords, 'keyword');
        //dd($articlesWithAllKeyword);

        $articlesWithAnyKeyword = $this->searchForArticlesWithAnyTags($allYearArticle, $keywords, 'keyword');
        //dd($articlesWithAnyKeyword);






        $articlesWithAllRoutes = $this->searchForArticlesWithAllTags($allYearArticle, $keywords, 'route');
        //dd($articlesWithAllRoutes);
        $articlesWithAnyRoutes = $this->searchForArticlesWithAnyTags($allYearArticle, $keywords, 'route');






        $articlesWithAllSubjects = $this->searchForArticlesWithAllTags($allYearArticle, $keywords, 'subject');
        $articlesWithAnySubjects = $this->searchForArticlesWithAnyTags($allYearArticle, $keywords, 'subject');




        $articlesWithAllSectors = $this->searchForArticlesWithAllTags($allYearArticle, $keywords, 'sector');
        $articlesWithAnySectors = $this->searchForArticlesWithAnyTags($allYearArticle, $keywords, 'sector');





        //only keeps articles with matching title
        $articlesWithExactTitle = $allYearArticle->filter(function ($article, $key) use($lowercaseSearchArticlesString) {
            if ($lowercaseSearchArticlesString == strtolower($article->title))
            {
                return $article;
            }
        });
        //dd($articlesWithExactTitle);



        //only keeps articles with search string contained in title
        $articlesContainsInTitle = $allYearArticle->filter(function ($article, $key) use($lowercaseSearchArticlesString) {
            if (str_contains(strtolower($article->title), $lowercaseSearchArticlesString))
            {
                return $article;
            }
        });
        //dd($articlesContainsInTitle);


        //only keeps articles with search string contained in the lead paragraph
        $articlesContainsInLead = $allYearArticle->filter(function ($article, $key) use($lowercaseSearchArticlesString) {
            if (str_contains(strtolower($article->lead), $lowercaseSearchArticlesString))
            {
                return $article;
            }
        });
        //dd($articlesContainsInLead);


        //only keeps articles with search string contained in the summary text
        $articlesContainsInSummary = $allYearArticle->filter(function ($article, $key) use($lowercaseSearchArticlesString) {
            if ( (str_contains(strtolower($article->summary_heading), $lowercaseSearchArticlesString)) || (str_contains(strtolower($article->summary_text), $lowercaseSearchArticlesString)) )
            {
                return $article;
            }
        });
        //dd($articlesContainsInSummary);




        //RANKING
        //Compiles the collection to return

        $result = collect([]);

        //adds the articles with the exact title
        $result = $result->union($articlesWithExactTitle);

        //adds the articles with the keyword
        $result = $result->union($articlesWithAllKeyword);
        $result = $result->union($articlesWithAnyKeyword);

        //adds the articles with the tags
        $result = $result->union($articlesWithAllRoutes);
        $result = $result->union($articlesWithAllSubjects);
        $result = $result->union($articlesWithAllSectors);
        $result = $result->union($articlesWithAnyRoutes);
        $result = $result->union($articlesWithAnySubjects);
        $result = $result->union($articlesWithAnySectors);

        //adds the articles containing search string in title
        $result = $result->union($articlesContainsInTitle);

        //adds the articles containing search string in lead para
        $result = $result->union($articlesContainsInLead);

        //adds the articles containing search string in summary
        $result = $result->union($articlesContainsInSummary);


        return $result;

    }

}
