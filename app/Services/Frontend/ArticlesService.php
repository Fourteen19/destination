<?php

namespace App\Services\Frontend;

use App\Models\Content;
use App\Models\SystemTag;
use App\Models\ContentLive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



Class ArticlesService
{


    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct() {
        ///
    }


    /**
     * Gets all the articles read by a user for the current year
     *
     * @return void
     */
    public function getArticlesRead($user = NULL){

        if ($user == NULL){
            $user = auth()->user();
        }

        return $user->articlesReadThisYear()->get()->pluck('id')->toArray();

    }

    /**
     * getUnreadArticles
     * selects LIVE articles that
     * are tagged with the same year as the user
     * are tagged with the same term as the current term
     * have not been read
     * eager load the tags() function associated with the articles
     *
     * @return void
     */
    public function getUnreadArticles(){

        $articlesAlreadyRead = $this->getArticlesRead();

        //Global scope is automatically applied to retrieve global and client related content
        return ContentLive::select('id', 'slug', 'summary_heading', 'summary_text')
                            ->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                            ->withAnyTags( [ app('currentTerm') ] , 'term')
                            ->whereNotIn('id', $articlesAlreadyRead)
                            ->with('tags') // eager loads all the tags for the article
                            ->get();

    }



    /**
     * getReadArticles
     * selects LIVE articles that
     * are tagged with the same year as the user
     * are tagged with the same term as the current term
     * have been read
     * eager load the tags() function associated with the articles
     *
     * @return void
     */
    public function getReadArticles(){

        $articlesAlreadyRead = $this->getArticlesRead();

        //Global scope is automatically applied to retrieve global and client related content
        return ContentLive::select('id', 'slug', 'summary_heading', 'summary_text')
                            ->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                            ->withAnyTags( [ app('currentTerm') ] , 'term')
                            ->whereIn('id', $articlesAlreadyRead)
                            ->with('tags') // eager loads all the tags for the article
                            ->get();

    }


    /**
     * getAllReadUnreadArticles
     * selects LIVE articles that
     * have been read or not
     * are tagged with the same year as the user
     * eager load the tags() function associated with the articles
     *
     * @return void
     */
    public function getAllReadUnreadArticles(){

        //Global scope is automatically applied to retrieve global and client related content
        return ContentLive::select('id', 'slug', 'summary_heading', 'summary_text')
                            ->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                            ->with('tags') // eager loads all the tags for the article
                            ->get();

    }




    /**
     * loadLiveArticle
     * Loads an article summary data
     *
     * @param  mixed $articleId
     * @return void
     */
    public function loadLiveArticle($articleId = NULL)
    {

        if (!is_null($articleId))
        {
            //checks if the article is still live
            return ContentLive::select('id', 'slug', 'summary_heading', 'summary_text')->where('id', '=', $articleId)->get()->first();
        }

        return NULL;

    }



    /**
     * aUserReadsAnArticle
     * checks if the record exists in the pivot table
     *
     * @param  mixed $user
     * @param  mixed $articleId
     * @return void
     */
    public function aUserReadsAnArticle($user = NULL, $article){

        if ($user === NULL)
        {
            $user = Auth::guard('web')->user();
        }


        //if the user has not read the article for that year
        if (!$user->articleReadThisYear($article->id, NULL)->exists()){

            //creates the pivot record
            $user->articles()->attach($article->id, ['school_year' => Auth::guard('web')->user()->school_year]);

            //updates the score of the current assessment tags
            $this->updateTagsScoreWhenReadingAnArticle($article, $user->getSelfAssessment(NULL) );

        } else {

            $user->articleReadThisYear($article->id, NULL)->updateExistingPivot(
                $article->id, ['nb_read' => DB::raw('nb_read + 1')]
            );

        }

        $this->clearArticleFromDashboard($article->id);

        //increments the article counters (monthly & total)
        $this->incrementArticleCounters($article);

    }





        /**
     * incrementArticleCounters
     * increment the article counters
     *
     * @param  mixed $articleId
     * @return void
     */
    private function incrementArticleCounters($article)
    {

        $content = Content::find($article->id);

        $year = Auth::guard('web')->user()->school_year;

        $content->articlesMonthlyStats()->updateorCreate(
            ['content_id' => $article->id,
            'client_id' => Auth::guard('web')->user()->client_id
            ],
            ['year_'.$year =>  DB::raw('year_'.$year.' + 1'),
             'total' =>  DB::raw('total + 1')
            ]
        );

        $content->articlesTotalStats()->updateorCreate(
            ['content_id' => $article->id,
             'client_id' => Auth::guard('web')->user()->client_id
            ],
            ['year_'.$year =>  DB::raw('year_'.$year.' + 1')]
        );
    }




    public function clearArticleFromDashboard($articleId)
    {

        $dashboard = Auth::guard('web')->user()->getUserDashboardDetails();

        if ($dashboard->slot_1 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(1, '');
        } elseif ($dashboard->slot_2 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(2, '');
        } elseif ($dashboard->slot_3 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(3, '');
        } elseif ($dashboard->slot_4 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(4, '');
        } elseif ($dashboard->slot_5 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(5, '');
        } elseif ($dashboard->slot_6 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(6, '');
        }


        if ($dashboard->sd_slot_1 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(1, 'sd_');
        } elseif ($dashboard->sd_slot_2 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(2, 'sd_');
        } elseif ($dashboard->sd_slot_3 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(3, 'sd_');
        }


        if ($dashboard->hrn_slot_1 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(1, 'hrn_');
        } elseif ($dashboard->hrn_slot_2 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(2, 'hrn_');
        } elseif ($dashboard->hrn_slot_3 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(3, 'hrn_');
        } elseif ($dashboard->hrn_slot_4 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(4, 'hrn_');
        }


        if ($dashboard->ria_slot_1 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(1, 'ria_');
        } elseif ($dashboard->ria_slot_2 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(2, 'ria_');
        } elseif ($dashboard->ria_slot_3 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(3, 'ria_');
        }

    }



    /**
     * checkIfDisplayFeedbackForm
     *
     * @param  mixed $article
     * @return void
     */
    public function checkIfDisplayFeedbackForm($article)
    {

        //gets the article and its relation
        $article = Auth::guard('web')->user()->articleReadThisYear($article->id)->first();

        //if the feedback has already been submitted
        if (!is_null($article->pivot->user_feedback))
        {
            return False; //do not display the form
        }

        return True; //do display the form

    }



    /**
     * updateArticleInteractionFeedbackReceivedByUser
     * Update feedback received by a user while interacting with an article to an article
     *
     * @param  mixed $articleId
     * @param  mixed $relevant
     * @return void
     */
    public function updateArticleInteractionFeedbackReceivedByUser($articleId, Array $data = [])
    {

        Auth::guard('web')->user()->articleReadThisYear($articleId, NULL)->updateExistingPivot(
            $articleId, $data
        );

    }




    /**
     * updateArticleTagsScore
     * updates the tags scores based on the articles tags
     *
     * @param  mixed $article
     * @return void
     */
    public function updateTagsScoreWhenReadingAnArticle($article, $selfAssessment){

        //gets the tags we need to update
        $userAssessmentTagsToUpdate = $this->getArticleAndAssessmentTags($article);

        //if there are tags to update
        if (count($userAssessmentTagsToUpdate) > 0)
        {

            //upgrades the tags score. +2
            app('selfAssessmentSingleton')->updateTagsScore($userAssessmentTagsToUpdate, $selfAssessment->id, 2);

        }

    }




    /**
     * getArticleAndAssessmentTags
     *
     * @param  mixed $article
     * @return void
     */
    public function getArticleAndAssessmentTags($article)
    {

        $tagsType = ['subject', 'route', 'sector'];

        $userAssessmentTagsToUpdate = [];

        //foreach tags type
        foreach($tagsType as $tagType)
        {

            //gets the article $tagType tags
            $articleTagsIds = $this->getTagsFromArticle($article, $tagType);

            //gets the assessment $tagType tags
            $selfAssessmentTagsIds = app('selfAssessmentSingleton')->getAllocatedTags($tagType);

            //extracts the id and store in array
            $selfAssessmentTagsIds = $selfAssessmentTagsIds->pluck('id')->toArray();


            //intersect the arrays to find matching tags
            $commonTags = array_intersect($articleTagsIds, $selfAssessmentTagsIds);

            //merge the tags
            $userAssessmentTagsToUpdate = array_merge($userAssessmentTagsToUpdate, $commonTags);

            //make Ids unique
            $userAssessmentTagsToUpdate = array_unique($userAssessmentTagsToUpdate);

        }

        return $userAssessmentTagsToUpdate;

    }




    /**
     * getTagsFromArticle
     * gets tags for an article
     *
     * @param  mixed $article
     * @param  mixed $tagType
     * @return void
     */
    public function getTagsFromArticle($article, $tagType)
    {

        //gets the tags associated to an article
        $articleTags = $article->tagsWithType($tagType);

        //stores in an array the tags IDs related to an article
        $articleTagsIds = [];
        foreach($articleTags as $articleTag)
        {
            $articleTagsIds[] = $articleTag['id'];
        }

        return $articleTagsIds;
    }










    /**
     * filterHighPriorityArticlesFromCollection
     * filters an array of articles and only keep the ones with the "High Priority" tag
     *
     * @param  mixed $articles
     * @return void
     */
    public function filterHighPriorityArticles($articles)
    {

        //selects only high priority articles
        $highPriorityArticles = [];

        //for each article
        foreach($articles as $key => $value)
        {
            //gets the tags
            $tags = $value->tagsWithType('flag');
            foreach ($tags as $key => $tag)
            {
                //if the "High Priority" tag is allocated to the article
                if ($tag->name == config('global.tag_names.high_priority'))
                {
                    $highPriorityArticles[] = $value;
                }
            }

        }

        return $highPriorityArticles;

    }





    /**
     * filterNeetArticles
     * filters an array of articles and only keep the ones with a NEET tag matching the user's
     *
     * @param  mixed $articles
     * @return void
     */
    public function filterNeetArticles($articles)
    {

        //selects only NEET articles
        $neetArticles = [];

        //gets users NEET tags
        $userNeetTags = Auth::guard('web')->user()->tagsWithType('neet')->pluck('name', 'id')->toArray();

        //if the user has a NEET tag
        if (!empty($userNeetTags))
        {

            //for each article
            foreach($articles as $key => $item){

                //get the `NEET` tags (already preloaded in $articles)
                $neetArticleTags = $item->tagsWithType('neet')->pluck('name', 'id')->toArray();

                if (!empty($neetArticle))
                {
                    $res = array_intersect($userNeetTags, $neetArticleTags);
                    if (count($res) > 0){
                        $neetArticles[] = $item;
                    }
                }

            }

        }

        return $neetArticles;

    }




    /**
     * getNeetArticles
     * filters neet articles
     *
     * @param  mixed $articles
     * @return void
     */
/*    public function getNeetArticles($articles)
    {

        $slotArticles = [];

        //gets users NEET tags
        $userNeetTags = Auth::guard('web')->user()->tagsWithType('neet')->pluck('name', 'id')->toArray();

        //if the user has a NNET tag
        if (!empty($userNeetTags))
        {

            //for each article
            foreach($articles as $key => $item){

                //get the `NEET` tags (already preloaded in $articles)
                $neetArticle = $item->tagsWithType('neet')->pluck('name', 'id')->toArray();

                if (!empty($neetArticle))
                {
                    $res = array_intersect( $userNeetTags, $neetArticle);
                    if (count($res) > 0){
                        $slotArticles[] = $item;
                    }
                }

            }

        }

        //filters the array by High priority
        $highPriorityArticles = $this->filterHighPriorityArticles($slotArticles);
        if (count($highPriorityArticles) > 0)
        {
            return $highPriorityArticles;
        }


        return $slotArticles;
    }
*/


    /**
     * getRouteArticles
     * gets articles with similar routes as the current user
     *
     * Using unread or read articles (depending on the case)
     * Select articles by Route with highest score
     *
     * @param  mixed $articles
     * @return void
     */
    public function getRouteArticles($articles)
    {
        //gets allocated LIVE `route` tags for the current assessment
        //$selfAssessmentRouteTags = $this->selfAssessmentService->getAllocatedRouteTags();
        $selfAssessmentRouteTags = app('selfAssessmentSingleton')->getAllocatedRouteTags();

        $slotArticles = [];

        //if the self assessment has a `route` tags
        if ($selfAssessmentRouteTags != null)
        {

            //sort the tags by score
            $sortedRouteTags = $selfAssessmentRouteTags->sortBy(function (SystemTag $tag, $key) {
                return $tag->pivot->score;
            })->pluck('name', 'id')->toArray();

            //for each article
            foreach($articles as $key => $item){

                //get the `route` tags (already preloaded in $articles)
                $routesArticleTags = $item->tagsWithType('route')->pluck('name', 'id')->toArray();

                //for each `route` tag
                foreach($routesArticleTags as $routeKey => $routeTag){

                    //compare the article's and the user's routes
                    if (in_array($routeTag, $sortedRouteTags)){
                        //$slotArticles[] = $item->id;
                        $slotArticles[] = $item;
                    }

                }

            }



            //filters the array by High priority
            $highPriorityArticles = $this->filterHighPriorityArticles($slotArticles);
            if (count($highPriorityArticles) > 0)
            {
                return [$highPriorityArticles, 'high_priority_articles'];
            } else {

                //filters the array by NEET
                $neetArticles = $this->filterNeetArticles($slotArticles);
                if (count($neetArticles) > 0)
                {
                    return [$neetArticles, 'neet_articles'];
                }

            }

            return [$slotArticles, 'articles'];

        } else {

            return [$slotArticles, 'articles'];

        }

    }



    /**
     * getSectorArticles
     * Using unread or read articles (depending on the case)
     * Select articles by Sector with highest score
     *
     * @param  mixed $articles
     * @return void
     */
    public function getSectorArticles($articles)
    {

        //gets allocated LIVE `sector` tags for the current assessment
        //$selfAssessmentSectorTags = $this->selfAssessmentService->getAllocatedSectorTags();
        $selfAssessmentSectorTags = app('selfAssessmentSingleton')->getAllocatedSectorTags();

        $slotArticles = [];

        //if the self assessment has a `sector` tags
        if ($selfAssessmentSectorTags != null)
        {

            //sort the tags by score
            $sortedSectorTags = $selfAssessmentSectorTags->sortBy(function ($tag, $key) {
                return $tag->pivot->score;
            })->pluck('name', 'id')->toArray();


            //for each article
            foreach($articles as $key => $item){

                //get the `sector` tags (already preloaded in $articles)
                $sectorsArticle = $item->tagsWithType('sector')->pluck('name', 'id')->toArray();

                //for each `sector` tag
                foreach($sectorsArticle as $sectorKey => $sector){

                    if (in_array($sector, $sortedSectorTags)){
                        //$slotArticles[] = $item->id;
                        $slotArticles[] = $item;
                    }

                }

            }

            //filters the array by High priority
            $highPriorityArticles = $this->filterHighPriorityArticles($slotArticles);
            if (count($highPriorityArticles) > 0)
            {
                return [$highPriorityArticles, 'high_priority_articles'];
            } else {

                //filters the array by NEET
                $neetArticles = $this->filterNeetArticles($slotArticles);
                if (count($neetArticles) > 0)
                {
                    return [$neetArticles, 'neet_articles'];
                }

            }

            return [$slotArticles, 'articles'];

        } else {

            return [$slotArticles, 'articles'];

        }

    }




    /**
     * getSubjectArticles
     * Using unread or read articles (depending on the case)
     * Select articles by subject with highest score
     *
     * @param  mixed $articles
     * @return void
     */
    public function getSubjectArticles($articles)
    {

        //gets allocated LIVE `subject` tags for the current assessment
        //$selfAssessmentSubjectTags = $this->selfAssessmentService->getAllocatedSubjectTags();
        $selfAssessmentSubjectTags = app('selfAssessmentSingleton')->getAllocatedSubjectTags();

        $slotArticles = [];

        //if the self assessment has a `subject` tags
        if ($selfAssessmentSubjectTags != null)
        {

            //only keeps `subject` tagged with score > 0
            $sortedSubjectTags = $selfAssessmentSubjectTags->filter(function ($tag, $key) {
                return $tag->pivot->score > 0;
            });

            //sort the tags by score
            $sortedSubjectTags = $sortedSubjectTags->sortBy(function ($tag, $key) {
                return $tag->pivot->score;
            })->pluck('name', 'id')->toArray();

            //for each article
            foreach($articles as $key => $item){

                //get the `subject` tags (already preloaded in $articles)
                $subjectsArticle = $item->tagsWithType('subject')->pluck('name', 'id')->toArray();

                //for each `subject` tag
                foreach($subjectsArticle as $sectorKey => $sector){

                    if (in_array($sector, $sortedSubjectTags)){
                        //$slotArticles[$sector][] = $item->id;
                        $slotArticles[$sector][] = $item;
                    }

                }

            }

            //loops through array of subjects and search for the first one with articles
            foreach($slotArticles as $key => $value){

                if (!empty($value)){
                    $slotArticles = $value;
                    break(1);
                }

            }


            //filters the array by High priority
            $highPriorityArticles = $this->filterHighPriorityArticles($slotArticles);
            if (count($highPriorityArticles) > 0)
            {
                return [$highPriorityArticles, 'high_priority_articles'];
            } else {

                //filters the array by NEET
                $neetArticles = $this->filterNeetArticles($slotArticles);
                if (count($neetArticles) > 0)
                {
                    return [$neetArticles, 'neet_articles'];
                }

            }

            return [$slotArticles, 'articles'];

        } else {

            return [$slotArticles, 'articles'];

        }

    }



    /**
     * getCareerArticles
     *
     * @param  mixed $articles
     * @return void
     */
    public function getCareerArticles($articles)
    {

        //gets career tag
        $selfAssessmentCareerTag = app('selfAssessmentSingleton')->getCareerReadinessTags()->first();

        //contains articles we can show the user
        $slotArticles = [];

        //if the self assessment has a `career_readiness` tags
        if ($selfAssessmentCareerTag != null)
        {

            //for each article
            foreach($articles as $key => $item){

                //get the career readiness tags associated to the article
                $careerArticle = $item->tagsWithType('career_readiness')->pluck('id')->toArray();

                if (!empty($careerArticle))
                {

                    //if identical, then save the article Id
                    if ($careerArticle[0] == $selfAssessmentCareerTag->id) {
                        //$slotArticles[] = $item->id;
                        $slotArticles[] = $item;
                    }

                }

            }


            //filters the array by High priority
            $highPriorityArticles = $this->filterHighPriorityArticles($slotArticles);
            if (count($highPriorityArticles) > 0)
            {
                return [$highPriorityArticles, 'high_priority_articles'];
            } else {

                //filters the array by NEET
                $neetArticles = $this->filterNeetArticles($slotArticles);
                if (count($neetArticles) > 0)
                {
                    return [$neetArticles, 'neet_articles'];
                }

            }

            return [$slotArticles, 'articles'];

        } else {

            return [$slotArticles, 'articles'];

        }

    }




    /**
     * Select articles that are Global (applicable to all terms and years and un tagged)
     *
     * @param  mixed $articles
     * @return void
     */
    public function getGlobalArticles($articles)
    {

        $slotArticles = [];

        //for each article
        foreach($articles as $key => $item){

            $yearArticle = $item->tagsWithType('year')->pluck('name', 'id')->toArray();
            $termArticle = $item->tagsWithType('term')->pluck('name', 'id')->toArray();
            $subjectArticle = $item->tagsWithType('subject')->pluck('name', 'id')->toArray();
            $routeArticle = $item->tagsWithType('route')->pluck('name', 'id')->toArray();
            $sectorArticle = $item->tagsWithType('sector')->pluck('name', 'id')->toArray();
            $careerArticle = $item->tagsWithType('career_readiness')->pluck('name', 'id')->toArray();

            //if the user's year is in the articles tag
            // AND if the current term is in the articles
            // AND if no other tag has baan allocated to the current article
            if ( (in_array(auth()->user()->school_year, $yearArticle)) && (in_array( app('currentTerm'), $termArticle)) &&  (count($subjectArticle) == 0) && (count($routeArticle) == 0) && (count($sectorArticle) == 0) && (count($careerArticle) == 0)){
                //$slotArticles[] = $item->id;
                $slotArticles[] = $item;
            }


            //filters the array by High priority
            $highPriorityArticles = $this->filterHighPriorityArticles($slotArticles);
            if (count($highPriorityArticles) > 0)
            {
                return [$highPriorityArticles, 'high_priority_articles'];
            } else {

                //filters the array by NEET
                $neetArticles = $this->filterNeetArticles($slotArticles);
                if (count($neetArticles) > 0)
                {
                    return [$neetArticles, 'neet_articles'];
                }

            }

            return [$slotArticles, 'articles'];

        }

        return [$slotArticles, 'articles'];

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
        return ContentLive::select('id', 'slug', 'summary_heading', 'summary_text')
                                ->withAnyTags([ auth()->user()->school_year ], 'year')
                                ->withAnyTags( [ app('currentTerm') ] , 'term')
                                ->withAnyTags( $tags , $type)
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
        return $this->getArticlesForCurrentYearAndTermAndSomeType($tags, $type, $exclude=$article->id);


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
