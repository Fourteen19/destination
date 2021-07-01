<?php

namespace App\Services\Frontend;

use App\Models\SystemTag;
use App\Models\ContentLive;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\PageService;
use App\Services\Frontend\ArticlesService;
use App\Services\Frontend\SelfAssessmentService;



Class RelatedArticlesService
{

    protected $articlesService;

    protected $selfAssessmentService;
    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct(ArticlesService $articlesService, SelfAssessmentService $selfAssessmentService) {

        $this->articlesService = $articlesService;

        $this->selfAssessmentService = $selfAssessmentService;
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

        foreach($tagsTypes as $tagsType)
        {

            $articles = $this->getRelatedArticleByTagsType($article, $tagsType);

            $relatedArticles = $relatedArticles->merge($articles);

        }

        return $relatedArticles->shuffle()->take( config('global.articles.nb_related_articles_in_article') );

    }


    /**
     * getOtherRelatedArticles
     * if no related article have been found, we look at the assessment tags and get articles from there
     *
     * @return void
     */
    public function getOtherRelatedArticles($article)
    {

        $relatedArticles = collect([]);

        //$list of tags
        $tags_list = [];
        //get the current self assessment

        //get the route tags related to the user assessment
        $assessmentRoutesTags = $this->selfAssessmentService->getAllocatedRouteTags()->toArray();
        $tags_list = array_merge($this->getTags($assessmentRoutesTags, 'route'), $tags_list);

        //get the sector tags not related to the user assessment
        $assessmentSectorsTags = $this->selfAssessmentService->getAllocatedSectorTags()->toArray();
        $tags_list = array_merge($this->getTags($assessmentSectorsTags, 'sector'), $tags_list);

        //get the subject tags not related to the user assessment
        $assessmentSubjectsTags = $this->selfAssessmentService->getAllocatedSubjectTags();


        /*     NON ORDERED LIST OF USER SUBJECTS
        //only keeps subject tagged with a score of "I like it" OR "50/50"
        $assessmentSubjectsTagsFiltered = Arr::where($assessmentSubjectsTags, function ($value, $key) {
            return $value['pivot']['assessment_answer'] < 3;
        });

        $tags_list = array_merge($this->getSubjectTags($assessmentSubjectsTagsFiltered, 'subject'), $tags_list);

        //shuffles all the tags
        $tags_list = Arr::shuffle($tags_list);

        */




         $assessmentSubjectsTagsFiltered =  $assessmentSubjectsTags->filter(function ($tag, $key) {
            if (Auth::guard('web')->user()->type == "user")
            {
                return $tag->pivot->score > 0;
            } else {
                return True;
            }
        });



        //sort the tags by score
        $assessmentSubjectsTagsFiltered = $assessmentSubjectsTagsFiltered->sortByDesc(function ($tag, $key) {
            if (Auth::guard('web')->user()->type == "user")
            {
                return $tag->pivot->score;
            } else {
                return True;
            }
        })->pluck('name', 'id')->toArray();

        //if a subject was found
        if (count($assessmentSubjectsTagsFiltered) > 0)
        {
            foreach($assessmentSubjectsTagsFiltered as $key => $value){

                $tags_list[] = ['name' => $value, 'type' => 'subject'];
            }

        }


        //gets available temapltes based on the institution work experience flag and the user type
        $templatesAvailable = $this->articlesService->getAvailableTemplatesForUserInstitution();


        //selects randomly 3 articles
        $nb_articles = 0;
        $i = 0;
        while ( ($nb_articles < config('global.articles.nb_related_articles_in_article')) && ($i < count($tags_list) - 1) )
        {

            if (Auth::guard('web')->user()->type == "user")
            {

                $articles = ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                        ->withAnyTags([ $tags_list[$i]['name'] ], $tags_list[$i]['type'])
                                        ->whereNotIn('id', [$article->id])
                                        ->select('id', 'summary_heading', 'summary_text', 'slug')
                                        ->orderBy(DB::raw('RAND()'))
                                        ->take(1)  //alias of limit
                                        ->whereIn('template_id', $templatesAvailable )
                                        ->get();

                if ($tags_list[$i]['name'] == "biology"){


                }

            } elseif (Auth::guard('web')->user()->type == 'admin'){

                $articles = ContentLive::withAnyTags([ $tags_list[$i]['name'] ], $tags_list[$i]['type'])
                                        ->whereNotIn('id', [$article->id])
                                        ->select('id', 'summary_heading', 'summary_text', 'slug')
                                        ->orderBy(DB::raw('RAND()'))
                                        ->take(1)  //alias of limit
                                        ->whereIn('template_id', $templatesAvailable )
                                        ->get();
            }

            if (count($articles) > 0){

                $nb_articles++;

                $article = $articles->first();

                $relatedArticles->push($article);

            }

            $i++;
        }

        return $relatedArticles->shuffle()->take( config('global.articles.nb_related_articles_in_article') )->unique();

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
        return $this->articlesService->getArticlesForCurrentYearAndTermAndSomeType($tags, $type, $exclude=$article->id, $limit=3);

    }


    /**
     * getTags
     * Get the Tags in the list $assessmentTags
     *
     * @param  mixed $assessmentTags
     * @param  mixed $type
     * @return void
     */
    public function getTags($assessmentTags, String $type = "")
    {
        $tags_list = [];
        $tags = [];

        //compiles tages into an array
        foreach($assessmentTags as $key => $assessmentTag){
            $tags[] = $assessmentTag['id'];
        }

        //gets the tags not allocated to the user assessement
        $tags = SystemTag::getLiveTagsIn($type, $tags)->toArray();

        //compiles tags into an array
        foreach($tags as $key => $tag){
            $tags_list[] = ['name' => $tag['name'][app()->getLocale()], 'type' => $type];
        }

        return $tags_list;

    }


    public function getSubjectTags($assessmentTags, String $type = "")
    {
        $tags_list = [];

        //compiles tags into an array
        foreach($assessmentTags as $key => $tag){
            $tags_list[] = ['name' => $tag['name'][app()->getLocale()], 'type' => $type];
        }

        return $tags_list;

    }


    /******************** */

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
