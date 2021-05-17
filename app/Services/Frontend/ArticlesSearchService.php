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

            $explodedSearchString = explode(" ", $searchString);

            $query = SystemKeywordTag::where("client_id", Session::get('fe_client')->id)
                                    ->select('name', 'slug')
                                    ->where("live", '=', 'Y')
                                    ->where(function($query) use ($explodedSearchString) {
                                        foreach ($explodedSearchString as $string)
                                        {
                                            if (!empty($string))
                                                $query->orwhere("slug", "LIKE", "%".$string."%");
                                        }
                                    });

            $res = $query->get()->toArray();
//dd($res);
            $keywords = [];
            foreach($res as $key => $value){
                $keywords[] = [
                                'name' => $value['name'][app()->getLocale()],
                                'slug' => $value['slug'][app()->getLocale()]
                            ];
            }

//dd($keywords);


$tempKeywords = [];
            //compare each tag name with the string searched
            foreach($keywords as $key => $value)
            {

                $explodedTagName = explode(" ", strtolower($value['name']));

                //counts the number of common words between the search string and the tag
                $commonWords = array_intersect($explodedTagName, $explodedSearchString);

                //stores the tag in array for matching number of words
                $tempKeywords[ count($commonWords) ][] = $value;

            }

            //sort the array by key ie. the number of common words
            ksort($tempKeywords, SORT_NUMERIC );
            $reversedTempKeywords = array_reverse($tempKeywords);

            //we now have an array of tags sorted by the number of matching words in the name


            //push the tags in $keywords
            $keywords = [];
            foreach($reversedTempKeywords as $key => $value)
            {
                foreach($value as $keyKeyword => $valueKeyword)
                {
                    $keywords[] = $valueKeyword;
                }
            }

//dd($keywords);
            /* $tagsMatchingKeyword = [];
            $tagsContainingKeyword = [];
            $tagsWithKeyword = [];
            foreach($keywords as $key => $value)
            {


                if (strtolower($orginalSearchArticlesString) == strtolower($value['name']))
                {
                    $tagsMatchingKeyword[] = $value;//dd($tagsMatchingKeyword);
                } elseif (str_contains(strtolower($value['name']), strtolower($orginalSearchArticlesString))){
                    $tagsContainingKeyword[] = $value;//dd($tagsContainingKeyword);
                } elseif (str_contains(strtolower($orginalSearchArticlesString), strtolower($value['name']))){
                    $tagsContainingKeyword[] = $value;//dd($tagsContainingKeyword);
                } else {
                    $tagsWithKeyword[] = $value;//dd($tagsWithKeyword);
                }
            }
            //dd(strtolower($orginalSearchArticlesString));
            $keywords = array_merge($tagsMatchingKeyword, $tagsContainingKeyword, $tagsWithKeyword);
//dd($keywords); */
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

/*             $allYearArticle = ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                            ->leftjoin('content_articles_live as t', 't.id', '=', 'contents_live.contentable_id')
                            ->leftjoin('content_accordions_live as t1', 't1.id', '=', 'contents_live.contentable_id')
                            ->select('contents_live.id', 'contents_live.template_id', 'contents_live.title as content_title', 't.lead as article_lead', 't1.lead as accordion_lead', 'contents_live.slug', 'contents_live.summary_heading', 'contents_live.summary_text')
                            ->with('tags'); */

                $allYearArticle = ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                            ->leftjoin('content_articles_live', function ($join) {
                                $join->on('content_articles_live.id', '=', 'contents_live.contentable_id')
                                    ->where('contents_live.template_id', '=', 1);
                                })
                            ->leftjoin('content_accordions_live', function ($join) {
                                $join->on('content_accordions_live.id', '=', 'contents_live.contentable_id')
                                    ->where('contents_live.template_id', '=', 2);
                                })
                            ->select('contents_live.id', 'contents_live.template_id', 'contents_live.title as title',
                             'content_articles_live.lead as lead_article',
                             'content_accordions_live.lead as lead_accordion',
                             'contents_live.slug', 'contents_live.summary_heading', 'contents_live.summary_text')
                            ->with('tags');


//dd($allYearArticle->get());
/*
                            ->join('content_articles_live as t', 't.id', '=', 'contents_live.contentable_id')
                            ->leftjoin('content_accordions_live as t1', 't1.id', '=', 'contents_live.contentable_id')
                            ->select('contents_live.id', 'contents_live.template_id', 'contents_live.title as content_title', 't.lead as article_lead', 't1.lead as accordion_lead', 'contents_live.slug', 'contents_live.summary_heading', 'contents_live.summary_text')
                            ->with('tags');
 */


                            //->get();
                            // eager loads all the tags for the article

            //if the user's institution has the "work experience" section enabled
            if (Auth::guard('web')->user()->institution->work_experience == 'Y')
            {

                /* $allYearArticle = $allYearArticle->addSelect('t2.lead')
                                                 ->leftjoin('content_employers_live as t2', 't2.id', '=', 'contents_live.contentable_id')
                                                 ->whereIn('template_id', [1, 2, 4])
                                                 ->get(); */

                $allYearArticle = $allYearArticle->addSelect('content_employers_live.lead as lead_employer')
                                                  ->leftjoin('content_employers_live', function ($join) {
                                                        $join->on('content_employers_live.id', '=', 'contents_live.contentable_id')
                                                            ->where('contents_live.template_id', '=', 4);
                                                        })
                                                        ->get();

            } else {

                $allYearArticle = $allYearArticle->whereIn('template_id', [1, 2])
                                                 ->get();

            }


        //if the logged in user is an admin,  we ignore the year as we want to be able to access all articles
        } elseif (Auth::guard('web')->user()->type == 'admin'){

            /* $allYearArticle = ContentLive::leftjoin('content_articles_live as t', 't.id', '=', 'contents_live.contentable_id')
                            ->leftjoin('content_accordions_live as t1', 't1.id', '=', 'contents_live.contentable_id')
                            ->leftjoin('content_employers_live as t2', 't2.id', '=', 'contents_live.contentable_id')
                            ->select('contents_live.id', 't.title', 't.lead', 't1.title', 't1.lead', 'contents_live.slug', 'contents_live.summary_heading', 'contents_live.summary_text')
                            ->with('tags');
                            //->get(); */

            $allYearArticle = ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                            ->leftjoin('content_articles_live', function ($join) {
                                $join->on('content_articles_live.id', '=', 'contents_live.contentable_id')
                                    ->where('contents_live.template_id', '=', 1);
                                })
                            ->leftjoin('content_accordions_live', function ($join) {
                                $join->on('content_accordions_live.id', '=', 'contents_live.contentable_id')
                                    ->where('contents_live.template_id', '=', 2);
                                })
                            ->select('contents_live.id', 'contents_live.template_id', 'contents_live.title as content_title',
                             'contents_live.slug', 'contents_live.summary_heading', 'contents_live.summary_text')
                            ->with('tags');

            //if the user's institution has the "work experience" section enabled
            if (Auth::guard('web')->user()->institution->work_experience == 'Y')
            {

                /* $allYearArticle = $allYearArticle->addSelect('t2.title', 't2.lead')
                                                 ->leftjoin('content_employers_live as t2', 't2.id', '=', 'contents_live.contentable_id')
                                                 ->whereIn('template_id', [1, 2, 4])
                                                 ->get(); */

                $allYearArticle = $allYearArticle->leftjoin('content_employers_live', function ($join) {
                                                    $join->on('content_employers_live.id', '=', 'contents_live.contentable_id')
                                                        ->where('contents_live.template_id', '=', 4);
                                                    })
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




//dd($lowercaseSearchArticlesString);
        //only keeps articles with matching title
        $articlesWithExactTitle = $allYearArticle->filter(function ($article, $key) use($lowercaseSearchArticlesString) {
//            dd($article);
            if ($lowercaseSearchArticlesString == strtolower($article->summary_heading))
            {
                return $article;
            }
        });
        //dd($articlesWithExactTitle);



        //used to count number of times a word appear in an article (title, lead, ..)
        $explodedSearchString = explode(" ",  remove_common_words( strtolower($orginalSearchArticlesString) ) );


        $articlesContainsInTitleTmp = $allYearArticle->filter(function ($article, $key) use ($explodedSearchString) {

            // print $article->summary_heading;
            //explodes the summary heading
            $explodedTitle = explode(" ", strtolower($article->summary_heading));
// print_r($explodedTitle);
// print_r($explodedSearchString);
            //intersetcs the arrays
            $commonWords = array_intersect($explodedTitle, $explodedSearchString);
// print "=>".count($commonWords);
            //counts the number of common words and stores it for future sorting
            $article->containsInTitle = count($commonWords);

            //return the article
            if (count($commonWords) > 0)
            {
                return $article;
            }
        });

        //sort by number of occurences
        $articlesContainsInTitle = $articlesContainsInTitleTmp->sortByDesc('containsInTitle');
//dd($articlesContainsInTitle);





        //only keeps articles with search string contained in the lead paragraph
        $articlesContainsInLeadTmp = $allYearArticle->filter(function ($article, $key) use ($explodedSearchString) {
            // if (str_contains(strtolower($article->lead), $lowercaseSearchArticlesString))
            // {
            //     return $article;
            // }

            //explodes the summary heading
            $explodedTitle = explode(" ", strtolower($article->lead));

            //intersetcs the arrays
            $commonWords = array_intersect($explodedTitle, $explodedSearchString);

            //counts the number of common words and stores it for future sorting
            $article->containsInLead = count($commonWords);

            //return the article
            if (count($commonWords) > 0)
            {
                return $article;
            }
        });
        //dd($articlesContainsInLead);

        //sort by number of occurences
        $articlesContainsInLead = $articlesContainsInLeadTmp->sortByDesc('containsInLead');





/*
        //only keeps articles with search string contained in the summary text
        $articlesContainsSummaryTmp = $allYearArticle->filter(function ($article, $key) use($explodedSearchString) {
            // if ( (str_contains(strtolower($article->summary_heading), $lowercaseSearchArticlesString)) || (str_contains(strtolower($article->summary_text), $lowercaseSearchArticlesString)) )
            // {
            //     return $article;
            // }

            //explodes the summary heading
            $explodedSummaryText = explode(" ", $article->summary_text);

            //intersetcs the arrays
            $commonWords = array_intersect($explodedSummaryText, $explodedSearchString);

            //counts the number of common words and stores it for future sorting
            $article->containsInSummaryText = count($commonWords);

            //return the article
            if (count($commonWords) > 0)
            {
                return $article;
            }


        });
        //dd($articlesContainsInSummary);

        //sort by number of occurences
        $articlesContainsInSummary = $articlesContainsSummaryTmp->sortByDesc('containsSummaryText');


 */
        //RANKING
        //Compiles the collection to return

        $result = collect([]);

        //adds the articles with the exact title
        $result = $result->union($articlesWithExactTitle);

        //adds the articles containing search string in title
        $result = $result->union($articlesContainsInTitle);

        //adds the articles containing search string in lead para
        $result = $result->union($articlesContainsInLead);

        //adds the articles containing search string in summary
        // $result = $result->union($articlesContainsInSummary);

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

        //$result = $result->reverse();

        return $result;

    }

}
