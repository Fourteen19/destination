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

        return $keywords;

    }






    private function searchForArticlesWithAllTags($articlesHaystack, $keywords, $type = NULL)
    {

        if (count($keywords) == 0){
            return NULL;
        }

        //search for articles with all the tags
        $articlesWithAllTags = $articlesHaystack->filter(function ($article, $key) use ($keywords, $type) {

if ($type == 'route'){
//    dd($keywords);
}

            //gets all the articles keywords
            $articleKeywords = $article->tagsWithType($type)->pluck('slug')->toArray();
//dd($articleKeywords);
//print $article->id;
//print_r($articleKeywords);
            //compare the keywords typed in and the ones attached to the article
            $result = array_intersect($articleKeywords, $keywords);
//print_r($result);
            //if perfect match, this article has all the keywords tags
            if ( (count($result) == count($articleKeywords)) && (count($result) > 0) )
            {
//                print "ok";
                return $article;
            }
//            print "not ok"; print count($result);
//            print "<br>";
        });

        if ($type == 'route'){
           // dd($articlesWithAllTags);
        }

        return $articlesWithAllTags;

    }





    private function searchForArticlesWithAnyTags($articlesHaystack, $keywords, $type = NULL)
    {

        if (count($keywords) == 0){
            return NULL;
        }

//dd($articlesWithAnyKeyword);

        //search for articles with any of the tags
        $articlesWithAnyKeyword = $articlesHaystack->filter(function ($article, $key) use ($keywords, $type) {

            //gets all the articles keywords
            $articleKeywords = $article->tagsWithType($type)->pluck('slug')->toArray();
//dd($articleKeywords);
//print $article->id;
//print_r($articleKeywords);
            //compare the keywords typed in and the ones attached to the article
            $result = array_intersect($articleKeywords, $keywords);
//print_r($result);
            //if perfect match, this article has all the keywords tags
            if (count($result) > 0){
//                print "ok";print "<br>";
                $article->searchFilterScore = count($result);
                return $article;
            }
//            print "not ok"; print count($result);
//            print "<br>";
        });

        return $articlesWithAnyKeyword->sortBy('searchFilterScore');

    }





    private function processSearch($orginalSearchArticlesString)
    {

        // SELECTING
        //selects all the articles relevant to the year

        $allYearArticle = ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                        ->join('content_articles_live as t', 't.id', '=', 'contents_live.contentable_id')
                        ->select('contents_live.id', 't.title', 't.lead', 'contents_live.slug', 'contents_live.summary_heading', 'contents_live.summary_text')
                        ->with('tags')
                        ->get();
                         // eager loads all the tags for the article


        //extracts keywords from string
        $extractedKeywords = $this->getKeywordsFromSearchString($orginalSearchArticlesString);

        //dd($extractedKeywords);

        $keywords = [];
        foreach($extractedKeywords as $key => $value){
            $keywords[] = $value['slug'];
        }
        //dd($keywords);



        $lowercaseSearchArticlesString = strtolower($orginalSearchArticlesString);
//dd($lowercaseSearchArticlesString);


        //FILTERING
        //Filters all the articles selected

        //only keeps articles with the $lowercaseSearchArticlesString `keyword`
/*        $articlesByKeyword = $allYearArticle->filter(function ($article, $key) use($lowercaseSearchArticlesString) {
            if (in_array($lowercaseSearchArticlesString, $article->tagsWithType('keyword')->pluck('slug', 'id')->toArray() ))
            {
                return $article;
            }
        });
*/

/*
        //search for articles with all the keywords
        $articlesWithAllKeyword = $allYearArticle->filter(function ($article, $key) use ($keywords) {

            //gets all the articles keywords
            $articleKeywords = $article->tagsWithType('keyword')->pluck('slug')->toArray();

            //compare the keywords typed in and the ones attached to the article
            $result = array_intersect($articleKeywords, $keywords);

            //if perfect match, this article has all the keywords tags
            if (count($result) == count($keywords)){
                return $article;
            }

        });
*/
 //       $articlesWithAllKeyword = $this->searchForArticlesWithAllTags($allYearArticle, $keywords, 'keyword');
        //dd($articlesWithAllKeyword);


/*
        //search for articles with any of the keywords
        $articlesWithAnyKeyword = $allYearArticle->filter(function ($article, $key) use ($keywords) {

            //gets all the articles keywords
            $articleKeywords = $article->tagsWithType('keyword')->pluck('slug')->toArray();

            //compare the keywords typed in and the ones attached to the article
            $result = array_intersect($articleKeywords, $keywords);

            //if perfect match, this article has all the keywords tags
            if (count($result) > 0){
                $article->searchFilterScore = count($result);
                return $article;
            }

        });
*/

 //      $articlesWithAnyKeyword = $this->searchForArticlesWithAnyTags($allYearArticle, $keywords, 'keyword');
        //dd($articlesWithAnyKeyword);



        $articlesWithAllKeyword = $this->searchForArticlesWithAllTags($allYearArticle, $keywords, 'keyword');
        //dd($articlesWithAllKeyword);

        $articlesWithAnyKeyword = $this->searchForArticlesWithAnyTags($allYearArticle, $keywords, 'keyword');
        //dd($articlesWithAnyKeyword);

        //merges articles
//        $this->resArticlesByKeyword = $this->resArticlesByKeyword->union($articlesByKeyword);






/*
        //only keeps articles with the $lowercaseSearchArticlesString `route`
        $articlesByRoute = $allYearArticle->filter(function ($article, $key) use($lowercaseSearchArticlesString) {
            if (in_array($lowercaseSearchArticlesString, $article->tagsWithType('route')->pluck('slug', 'id')->toArray() ))
            {
                return $article;
            }
        });
*/

        $articlesWithAllRoutes = $this->searchForArticlesWithAllTags($allYearArticle, $keywords, 'route');
        //dd($articlesWithAllRoutes);
        $articlesWithAnyRoutes = $this->searchForArticlesWithAnyTags($allYearArticle, $keywords, 'route');





/*
        //only keeps articles with the $lowercaseSearchArticlesString `subject`
        $articlesBySubject = $allYearArticle->filter(function ($article, $key) use($lowercaseSearchArticlesString) {
            if (in_array($lowercaseSearchArticlesString, $article->tagsWithType('subject')->pluck('slug', 'id')->toArray() ))
            {
                return $article;
            }
        });
*/
        $articlesWithAllSubjects = $this->searchForArticlesWithAllTags($allYearArticle, $keywords, 'subject');
        $articlesWithAnySubjects = $this->searchForArticlesWithAnyTags($allYearArticle, $keywords, 'subject');



/*
        //only keeps articles with the $lowercaseSearchArticlesString `sector`
        $articlesBySector = $allYearArticle->filter(function ($article, $key) use($lowercaseSearchArticlesString) {
            if (in_array($lowercaseSearchArticlesString, $article->tagsWithType('sector')->pluck('slug', 'id')->toArray() ))
            {
                return $article;
            }
        });
*/
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
