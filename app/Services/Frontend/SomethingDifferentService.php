<?php

namespace App\Services\Frontend;

use App\Models\SystemTag;
use App\Models\ContentLive;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\ArticlesService;
use App\Services\Frontend\DashboardService;
use App\Services\Frontend\SelfAssessmentService;

Class SomethingDifferentService
{

    protected $articlesService;

    protected $selfAssessmentService;

    protected $dashboardService;

    public function __construct(DashboardService $dashboardService, ArticlesService $articlesService, SelfAssessmentService $selfAssessmentService)
    {
        $this->articlesService = $articlesService;

        $this->selfAssessmentService = $selfAssessmentService;

        $this->dashboardService = $dashboardService;

    }



    /**
     * getSomethingDifferentArticlesSummary
     *
     * @return void
     */
    public function getSomethingDifferentArticlesSummary($dashboardData)
    {

        $articles_list = collect([]);

        $excludeFromSearch = [];

        //gets the "something different" details from the dashboard
        $dashboardDataSlots = $dashboardData->get()->first()->toArray();

        //foreach slot, load the article's summary data
        foreach($dashboardDataSlots as $key => $slotArticleId)
        {
            if (!empty($slotArticleId))
            {
                //$articles_list[] = $this->articlesService->loadLiveArticle($slotArticleId);
                $articles_list->push($this->articlesService->loadLiveArticle($slotArticleId));
                $excludeFromSearch[] = $slotArticleId;
            }

        }


         //if the 3 slots have not been filled in, load more
        if (count($articles_list) < 3)
        {

            //$list of tags
            $tags_list = [];


            //get the route tags related to the user assessment
            $assessmentRoutesTags = $this->selfAssessmentService->getAllocatedRouteTags()->toArray();
            $tags_list = array_merge($this->getTags($assessmentRoutesTags, 'route'), $tags_list);



            //get the sector tags not related to the user assessment
            $assessmentSectorsTags = $this->selfAssessmentService->getAllocatedSectorTags()->toArray();
            $tags_list = array_merge($this->getTags($assessmentSectorsTags, 'sector'), $tags_list);



            //get the subject tags not related to the user assessment
            $assessmentSubjectsTags = $this->selfAssessmentService->getAllocatedSubjectTags()->toArray();

            //only keeps subject tagged with a score of 0
            $assessmentSubjectsTagsFiltered = Arr::where($assessmentSubjectsTags, function ($value, $key) {
                return $value['pivot']['assessment_answer'] == 4;
            });

            $tags_list = array_merge($this->getSubjectTags($assessmentSubjectsTagsFiltered, 'subject'), $tags_list);

            //if no tags were found, (probable because all the routes, subjects, sectors have been selected by the user)
            if (count($tags_list) == 0)
            {

                //gets 3 random articles

            }


            //shuffles all the tags
            $tags_list = Arr::shuffle($tags_list);




            //selects randomly 3 articles
            $nb_articles = 0;
            $i = 0;
            while ( ($nb_articles < 3) && ($i < count($tags_list) - 1) )
            {

                $articles = ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                        ->withAnyTags([ $tags_list[$i]['name'] ], $tags_list[$i]['type'])
                                        ->whereNotIn('id', $excludeFromSearch)
                                        ->select('id', 'summary_heading', 'summary_text', 'slug')
                                        ->orderBy(DB::raw('RAND()'))
                                        ->take(1)  //alias of limit
                                        ->whereIn('template_id', [1, 2] )
                                        ->get();

                if (count($articles) > 0){

                    $nb_articles++;

                    $article = $articles->first();

                    //$articles_list[] = $article;
                    $articles_list->push($article);
                }

                $i++;
            }

        }

        //shuffle($articles_list);
//dd($articles_list);

        return $articles_list->take(3);
        //return array_slice($articles_list , 0, 3);

    }



    /**
     * getRandomArticleForCurrentYearAndTermAndSomeType
     * Returns random articles for the year/term
     *
     * @param  mixed $limit
     * @return void
     */
    public function getRandomArticleForCurrentYearAndTerm($limit, $exclude)
    {
        $excludeList = [];
        foreach($exclude as $article)
        {
            $excludeList[] = $article->id;
        }

        $randomArticles = $this->articlesService->getRandomArticleForCurrentYearAndTerm($limit, $excludeList);

        return $randomArticles;

    }



    /**
     * saveToDashboard
     *
     * @param  mixed $articles
     * @return void
     */
    public function saveToDashboard($articles)
    {
        foreach($articles as $key => $article){
            if (!empty($article))
            {
                $this->dashboardService->assignArticleToDashboardSlot("sd_", $key + 1, $article->id);
            }
        }
    }


    public function getTags($assessmentTags, String $type = "")
    {
        $tags_list = [];
        $tags = [];

        //compiles tages into an array
        foreach($assessmentTags as $key => $assessmentTag){
            $tags[] = $assessmentTag['id'];
        }

        //gets the tags not allocated to the user assessement
        $tags = SystemTag::getLiveTagsNotIn($type, $tags)->toArray();

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



}
