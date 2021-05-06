<?php

namespace App\Services\Frontend;

use App\Models\Content;
use App\Models\SystemTag;
use App\Models\ContentLive;
use App\Models\HomepageSettings;
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

        //is the logged in user is a user
        if (Auth::guard('web')->user()->type == 'user'){

            //Global scope is automatically applied to retrieve global and client related content
            return ContentLive::select('id', 'slug', 'summary_heading', 'summary_text')
                                ->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                ->withAnyTags( [ app('currentTerm') ] , 'term')
                                ->whereNotIn('id', $articlesAlreadyRead)
                                ->with('tags') // eager loads all the tags for the article
                                ->whereIn('template_id', [1, 2] )
                                ->get();

        } else {

            //Global scope is automatically applied to retrieve global and client related content
            return ContentLive::select('id', 'slug', 'summary_heading', 'summary_text')
                                ->withAnyTags( [ app('currentTerm') ] , 'term')
                                ->whereNotIn('id', $articlesAlreadyRead)
                                ->with('tags') // eager loads all the tags for the article
                                ->whereIn('template_id', [1, 2] )
                                ->get();

        }

    }



    /**
     * checkIfArticleIsFree
     * checks if the article is free. ie. alocated to the homepage
     *
     * @param  mixed $article
     * @return void
     */
    public function checkIfArticleIsFree($article)
    {

        $pageService = new PageService();
        $page = $pageService->getHomepageDetails();

        $articlesList = [];
        if ($page->pageable->free_articles_slot1_page_id != NULL)
        {
            $articlesList[] = $page->pageable->free_articles_slot1_page_id;
        }

        if ($page->pageable->free_articles_slot2_page_id != NULL)
        {
            $articlesList[] = $page->pageable->free_articles_slot2_page_id;
        }

        if ($page->pageable->free_articles_slot3_page_id != NULL)
        {
            $articlesList[] = $page->pageable->free_articles_slot3_page_id;
        }
/* print $article->id;
dd($articlesList); */
        if (in_array($article->id, $articlesList))
        {
            return True;
        } else {
            return False;
        }

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
                            ->whereIn('template_id', [1, 2] )
                            ->get();

    }




    /**
     * getReadArticlesNotInDashboard
     * selects LIVE articles that
     * are tagged with the same year as the user
     * are tagged with the same term as the current term
     * have been read
     * eager load the tags() function associated with the articles
     *
     * @return void
     */
    public function getReadArticlesNotInDashboard( $articlesInDashboardSlots){

        $articlesAlreadyRead = $this->getArticlesRead();

        //removees articles from the dashboard from the list of articles already read as we do not want to display them
        $filteredArticles = array_diff($articlesAlreadyRead, $articlesInDashboardSlots);

        //Global scope is automatically applied to retrieve global and client related content
        return ContentLive::select('id', 'slug', 'summary_heading', 'summary_text')
                            ->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                            ->withAnyTags( [ app('currentTerm') ] , 'term')
                            ->whereIn('id', $filteredArticles)
                            ->with('tags') // eager loads all the tags for the article
                            ->whereIn('template_id', [1, 2] )
                            ->get();

    }



    /**
     * getAllReadUnreadArticles
     * selects LIVE articles that
     * have been read or not
     * are tagged with the same year as the user
     * eager load the tags() function associated with the articles
     * The 'term'filter is not used here
     *
     * @return void
     */
    public function getAllReadUnreadArticles(){

        //Global scope is automatically applied to retrieve global and client related content
        return ContentLive::select('id', 'slug', 'summary_heading', 'summary_text')
                            ->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                            ->with('tags') // eager loads all the tags for the article
                            ->whereIn('template_id', [1, 2] )
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
     * loadFeaturedArticles
     * Loads the feature article
     *
     * @return void
     */
    public function loadFeaturedArticles()
    {

        //selects all the client dashboard settings based on client and year
        $hompageSettings = HomepageSettings::where('client_id', '=', Auth::guard('web')->user()->client_id)
                                            ->where('school_year', '=', Auth::guard('web')->user()->school_year)
                                            ->first();

        //return the
        return $hompageSettings->getFeaturedArticle()->get();

    }



    /**
     * getNextToReadArticle
     * loads the next article to read
     * checks the ayears allocated with the article match the year the current user is in
     * if yes, the article
     * if not, return NULL
     *
     * @param  mixed $uuid
     * @return void
     */
    public function getNextToReadArticle($uuid)
    {

        //loads the next article to read
        $nextArticletoRead = $this->loadLiveArticle($uuid);

        //if the next article to read is set
        if ($nextArticletoRead)
        {

            //loads the years allocated to the article
            $nextArticletoReadYears = $nextArticletoRead->tagsWithType('year'); //gets all the years allocated to the related article
            $years = [];
            foreach($nextArticletoReadYears as $key => $value)
            {
                $years[] = $value->name;
            }

            //checks if the current is in the correct year to see the read next article
            if (!in_array(Auth::guard('web')->user()->school_year, $years)){
                $nextArticletoRead = NULL;
            }

        }

        return $nextArticletoRead;

    }




    /**
     * checkIfArticleCanBeReportedOn
     * checks if the 'Do not record on users profile' tag is associated to the article
     *
     * @param  mixed $article
     * @return void
     */
    public function checkIfArticleCanBeReportedOn($article)
    {

        //gets the article tags names in an Array
        $articleTags = $article->tagsWithType('flag')->pluck('name')->toArray();

        //if the 'Do not record on users profile' tag is set, we do not record data about the article
        if (in_array('Do not record on users profile', $articleTags))
        {

            return False;

        } else {

            return True;

        }

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

            if ($this->checkIfArticleCanBeReportedOn($article))
            {

                //updates the score of the current assessment tags
                $this->updateTagsScoreWhenReadingAnArticle($article, $user->getSelfAssessment(NULL) );

            }

        } else {

            $user->articleReadThisYear($article->id, NULL)->updateExistingPivot(
                $article->id, ['nb_read' => DB::raw('nb_read + 1')]
            );

        }

        //clears this article from the 'dashboard'
        $this->clearArticleFromDashboard($article->id, ['dashboard', 'read_it_again', 'something_different']);

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




    public function clearArticleFromDashboard($articleId, Array $type)
    {

        $dashboard = Auth::guard('web')->user()->getUserDashboardDetails();

        if (in_array('dashboard', $type)){

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

        }



        if (in_array('something_different', $type)){

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

        }



        if (in_array('hot_right_now', $type)){

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

        }



        if (in_array('read_it_again', $type)){

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
     * gets the tag associated with an article
     * updates the tags the user and the article have in common
     *
     * UPDATE 08/04/21: allocate the user's self-assessment with all article tags if not allocated yet
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
            $selfAssessmentTags = app('selfAssessmentSingleton')->getAllocatedTags($tagType);

            //extracts the id and store in array
            $selfAssessmentTagsIds = $selfAssessmentTags->pluck('id')->toArray();

            //intersect the arrays to find matching tags between the self assessment and the article
            //commented out 08/04/21
            //We do not want to score the common tags of the self assessment and article anymore,
            //$commonTags = array_intersect($articleTagsIds, $selfAssessmentTagsIds);



            /* if ($tagType == 'subject')
            { */

                //we gather all the articles tags whether the user has chosen them in their self-assessment
                $commonTags = $articleTagsIds;

                //gets the user self assessment
                //$userSelfAssessment = app('selfAssessmentSingleton')->getSelfAssessment();

                //gets the subjects tags
                //$selfAssessmentSubjectTags = $userSelfAssessment->tagsWithType('subject');

                //gets the current self-assessment's subject tags
                //$selfAssessmentSubjectTags = app('selfAssessmentSingleton')->getAllocatedSubjectTags();

                //dd($selfAssessmentSubjectTags);

                foreach($articleTagsIds as $key => $articleTagId)
                {

                    //check if tag belongs in the self assessment
                    $tag = $selfAssessmentTags->firstWhere('id', $articleTagId);

                    //if the tag is not found
                    if (!$tag)
                    {
                        //gets the tag from the DB
                        $subjectTag = SystemTag::find($articleTagId);

                        //allocate the tag to the self assessment
                        app('selfAssessmentSingleton')->getSelfAssessment()->attachTag($subjectTag->name, $tagType);



/*                     } else {
//dd($tag);
                        //check the aggregated score
                        //dd($tag->pivot->score);
 */
                    }



                    //upgrate the self assessment answer based on the score


                }

           /*  } elseif ($tagType == 'route') {

                //we need to allocate the tag to the self-assessment


            }
 */
//app('selfAssessmentSingleton')->getSelfAssessment()->syncTagsWithDefaultScoreWithType([$subjectTag->id], [5], $tagType);

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
//dd($articles);
        //if the self assessment has a `route` tags
        if ($selfAssessmentRouteTags != null)
        {

            //sort the tags by score
            $sortedRouteTags = $selfAssessmentRouteTags->sortBy(function (SystemTag $tag, $key) {
                return $tag->pivot->score;
            })->pluck('name', 'id')->toArray();
//print_r($sortedRouteTags);
            //for each article
            foreach($articles as $key => $item){

                //get the `route` tags (already preloaded in $articles)
                $routesArticleTags = $item->tagsWithType('route')->pluck('name', 'id')->toArray();

                //for each `route` tag
                foreach($routesArticleTags as $routeKey => $routeTag){

                    //compare the article's and the user's routes
                    if (in_array($routeTag, $sortedRouteTags)){
                        //$slotArticles[] = $item->id; remove

                        $slotArticles[] = $item;

                        // line below is how it should be done to rank articles by tags score
                        //$tagArticles[$routeKey][] = $item;

                    }

                }

            }
/*
dd($tagArticles);

            foreach($tagArticles as $tagArticleKey => $tagArticlesValue){

                //return articles with a high priority
                $highPriorityArticles = $this->filterHighPriorityArticles($tagArticlesValue);

                //if there are any high priority articles
                if (count($highPriorityArticles) > 0)
                {
                    //return [$highPriorityArticles, 'high_priority_articles'];
                } else {

                    //filters the array by NEET
                    $neetArticles = $this->filterNeetArticles($tagArticlesValue);
                    if (count($neetArticles) > 0)
                    {
                        return [$neetArticles, 'neet_articles'];
                    }

                }

            }
 */

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

                    //if the user's career readiness matches one the career readiness of the article, then save the article
                    if (in_array($selfAssessmentCareerTag->id, $careerArticle) ) {
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
/*     public function getRelatedArticles($article)
    {

        $tagsTypes = ['subject', 'sector', 'route'];

        $relatedArticles = collect([]);

        foreach($tagsTypes as $tagsType){

            $articles = $this->getRelatedArticleByTagsType($article, $tagsType);

            $relatedArticles = $relatedArticles->merge($articles);
        }

        return $relatedArticles->shuffle()->take(3);

    } */



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
                                ->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                ->withAnyTags( [ app('currentTerm') ] , 'term')
                                ->withAnyTags( $tags , $type)
                                ->where('id', '!=', $exclude)
                                ->whereIn('template_id', [1, 2] )
                                ->get(); // eager loads all the tags for the article

    }




    /**
     * getRandomArticleForCurrentYearAndTerm
     * gets random articles
     *
     * @param  mixed $limit
     * @param  mixed $exclude
     * @return void
     */
    public function getRandomArticleForCurrentYearAndTerm($limit, $exclude)
    {

        return ContentLive::select('id', 'slug', 'summary_heading', 'summary_text')
                        ->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                        ->withAnyTags( [ app('currentTerm') ] , 'term')
                        ->whereIn('template_id', [1, 2] )
                        ->limit($limit)
                        ->whereNotIn('id', $exclude)
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
