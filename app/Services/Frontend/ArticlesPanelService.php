<?php

namespace App\Services\Frontend;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\ArticlesService;

Class ArticlesPanelService
{

    //contains the ID of articles displayed in the panel
    //this is used to prevent duplication
    protected $articlePanel;

    protected $unreadArticles;

    protected $allArticles;

    protected $articlesService;

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct(ArticlesService $articlesService) {

        $this->selfAssessmentService = app('selfAssessmentSingleton');

        $this->articlesService = $articlesService;

        //keeps track of the articles allocated to the slots
        $this->articlePanelSlots = [];

        //contains the unread articles
        $this->unreadArticles = [];

        //contains the unread/read articles not filtered by term. Used in case we do not find any article to display in dashboard
        $this->allArticles = [];
    }



    /**
     * init
     * get all unread live articles
     *
     * @return void
     */
    public function init()
    {

        if (empty( $this->unreadArticles ))
        {
            $this->unreadArticles = $this->articlesService->getUnreadArticles();
        }

    }


    /**
     * getAllArticles
     * selects all the live articles related to a year
     * read or not
     * @return void
     */
    public function getAllArticles()
    {

        if (empty( $this->allArticles ))
        {
            //selects all unread articles
            //NULL parameter indicates we select all unread articles
            $this->allArticles = $this->articlesService->getAllReadUnreadArticles(NULL);
        }

    }




    /**
     * Gets all the articles read by a user
     *
     * @return void
     */
/*    public function getArticlesRead($user = NULL){

        if ($user == NULL){
            $user = auth()->user();
        }

        return $user->articles()->get()->pluck('id')->toArray();

    }
*/



    /**
     * getRouteArticles
     * Using unread or read articles (depending on the case)
     * Select articles by Route with highest score
     *
     * @param  mixed $articles
     * @return void
     */
    /*public function getRouteArticles($articles)
    {
        //gets allocated LIVE `route` tags for the current assessment
        //$selfAssessmentRouteTags = $this->selfAssessmentService->getAllocatedRouteTags();
        $selfAssessmentRouteTags = app('selfAssessmentSingleton')->getAllocatedRouteTags();

        //if the self assessment has a `route` tags
        if ($selfAssessmentRouteTags != null)
        {

            //sort the tags by score
            $sortedRouteTags = $selfAssessmentRouteTags->sortBy(function (SystemTag $tag, $key) {
                return $tag->pivot->score;
            })->pluck('name', 'id')->toArray();

            $slotArticles = [];

            //for each article
            foreach($articles as $key => $item){

                //get the `route` tags (already preloaded in $articles)
                $routesArticle = $item->tagsWithType('route')->pluck('name', 'id')->toArray();

                //for each `route` tag
                foreach($routesArticle as $routeKey => $route){

                    //compare the article's and the user's routes
                    if (in_array($route, $sortedRouteTags)){
                        //$slotArticles[] = $item->id;
                        $slotArticles[] = $item;
                    }

                }

            }

            return $slotArticles;

        } else {

            return [];

        }

    }
*/


    /**
     * getSectorArticles
     * Using unread or read articles (depending on the case)
     * Select articles by Sector with highest score
     *
     * @param  mixed $articles
     * @return void
     */
/*    public function getSectorArticles($articles)
    {

        //gets allocated LIVE `sector` tags for the current assessment
        //$selfAssessmentSectorTags = $this->selfAssessmentService->getAllocatedSectorTags();
        $selfAssessmentSectorTags = app('selfAssessmentSingleton')->getAllocatedSectorTags();

        //if the self assessment has a `sector` tags
        if ($selfAssessmentSectorTags != null)
        {

            //sort the tags by score
            $sortedSectorTags = $selfAssessmentSectorTags->sortBy(function ($tag, $key) {
                return $tag->pivot->score;
            })->pluck('name', 'id')->toArray();


            $slotArticles = [];

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

            return $slotArticles;

        } else {

            return [];

        }

    }
*/



    /**
     * getSubjectArticles
     * Using unread or read articles (depending on the case)
     * Select articles by subject with highest score
     *
     * @param  mixed $articles
     * @return void
     */
/*    public function getSubjectArticles($articles)
    {

        //gets allocated LIVE `subject` tags for the current assessment
        //$selfAssessmentSubjectTags = $this->selfAssessmentService->getAllocatedSubjectTags();
        $selfAssessmentSubjectTags = app('selfAssessmentSingleton')->getAllocatedSubjectTags();

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



            $slotArticles = [];

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

            return $slotArticles;

        } else {

            return [];

        }

    }
*/



    /**
     * Select articles that are Global (applicable to all terms and years and un tagged)
     *
     * @param  mixed $articles
     * @return void
     */
/*    public function getGlobalArticles($articles)
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

        }

        return $slotArticles;

    }
*/



    /**
     * getCareerArticles
     *
     * @param  mixed $articles
     * @return void
     */
/*    public function getCareerArticles($articles)
    {

        //gets career tag
        //$selfAssessmentCareerTag = $this->selfAssessmentService->getCareerReadinessTags()->first();
        $selfAssessmentCareerTag = app('selfAssessmentSingleton')->getCareerReadinessTags()->first();

        //if the self assessment has a `career_readiness` tags
        if ($selfAssessmentCareerTag != null)
        {
            //contains articles we can show the user
            $slotArticles = [];

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

            return $slotArticles;

        } else {

            return [];

        }

    }
*/

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
/*    public function getUnreadArticles(){

        $articlesAlreadyRead = $this->getArticlesRead();

        //Global scope is automatically applied to retrieve global and client related content
        return ContentLive::withAnyTags([ auth()->user()->school_year ], 'year')
                                                ->withAnyTags( [ app('currentTerm') ] , 'term')
                                                ->whereNotIn('id', $articlesAlreadyRead)
                                                ->with('tags') // eager loads all the tags for the article
                                                ->get();

    }
*/


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
/*    public function getReadArticles(){

        $articlesAlreadyRead = $this->getArticlesRead();

        //Global scope is automatically applied to retrieve global and client related content
        return ContentLive::withAnyTags([ auth()->user()->school_year ], 'year')
                                                ->withAnyTags( [ app('currentTerm') ] , 'term')
                                                ->whereIn('id', $articlesAlreadyRead)
                                                ->with('tags') // eager loads all the tags for the article
                                                ->get();

    }
*/

    /**
     * getAllReadUnreadArticles
     * selects LIVE articles that
     * have been read or not
     * are tagged with the same year as the user
     * eager load the tags() function associated with the articles
     *
     * @return void
     */
/*    public function getAllReadUnreadArticles(){

        //Global scope is automatically applied to retrieve global and client related content
        return ContentLive::withAnyTags([ auth()->user()->school_year ], 'year')
                                                ->with('tags') // eager loads all the tags for the article
                                                ->get();

    }
*/

    /**
     * filterSlot1Article
     * filter articles for slot 1
     *
     * @param  mixed $articles
     * @return void
     */
    public function filterSlot1Article($articles, $type)
    {
//print 0;
        $article = null;
        //if($type=="read"){dd($articles);}
        list($routeArticles, $routeArticlesType) = $this->articlesService->getRouteArticles($articles);

        list($careerArticles, $careerArticlesType) = $this->articlesService->getCareerArticles($articles);

        //selects which group of articles to display
        if ($routeArticlesType == "high_priority_articles"){
            //if($type=="read"){dd("a");}
            $selectedArticles = $routeArticles;
        } elseif ($careerArticlesType == "high_priority_articles"){
            //if($type=="read"){dd("b");}
            $selectedArticles = $careerArticles;
        } elseif ($routeArticlesType == "neet_articles"){
            //if($type=="read"){dd("c");}
            $selectedArticles = $routeArticles;
        } else if ($careerArticlesType == "neet_articles"){
            //if($type=="read"){dd("d");}
            $selectedArticles = $careerArticles;
        } else {
            $selectedArticles = array_merge($routeArticles, $careerArticles);
            /* if($type=="read"){
                //dd("e");
                //dd($selectedArticles);
            } */
        }


        if (count($selectedArticles) > 0){
            //print 1;//if($type=="read"){dd($selectedArticles);}
            $article = Arr::random($selectedArticles);
        } else {
//dd(1);
            list($sectorArticles, $sectorArticlesType) = $this->articlesService->getSectorArticles($articles);

            if (count($sectorArticles) > 0){
                //print 2;
                $article = Arr::random($sectorArticles);

            } else {
//dd(2);
                list($subjectArticles, $subjectArticlesType) = $this->articlesService->getSubjectArticles($articles);

                if (count($subjectArticles) > 0){
                    //print 3;
                    $article = Arr::random($subjectArticles);

                } else {
//dd(3);
                    list($globalArticles, $globalArticlesType) = $this->articlesService->getGlobalArticles($articles);

                    if (count($globalArticles) > 0){
                        //print 4;
                        $article = Arr::random($globalArticles);

                    }

                }

            }

        }
        //if($type=="read"){dd($article);}
        return $article;

    }









    /**
     * getSlot1Article
     * This function gets the article to display in slot 1
     * if the `articleId` parameter is passed, we go and select that article
     *
     * @param  mixed $articleId
     * @return void
     */
    public function getSlot1Article($articleId = NULL)
    {

        //if we need a specific article from the dashboard table
        $slot1Article = $this->articlesService->loadLiveArticle($articleId);

        //if the article is not live anymore / can not be found in the live table
        if (!$slot1Article)
        {

            $this->init();
//dd($this->unreadArticles);
            //filters and try to find an article
            $slot1Article = $this->filterSlot1Article( $this->unreadArticles, 'unread' );
//dd($slot1Article);

            //if no article found
            if (!$slot1Article) {

                //gets already read articles that are not in the dashboard
                $readArticles = $this->articlesService->getReadArticlesNotInDashboard($this->articlePanelSlots);
//print_r($readArticles);
//dd($readArticles);
                //filters and try to find an article from the already read articles
                $slot1Article = $this->filterSlot1Article($readArticles, 'read' );
//dd($slot1Article);


                //if no article found
                if (!$slot1Article) {

                    //use the first unread article from the collection
                    //$slot1Article = $this->unreadArticles->first();

                    $this->getAllArticles();

                    //removes from all articles
                    //$this->allArticles = $this->removesFromAllArticles( $this->articlePanelSlots[5] );

                    //filters and try to find an article
                    $slot1Article = $this->filterSlot1Article( $this->allArticles, 'all' );
//dd(1);
                    //if no article found
/*                     if (!$slot1Article) {

                        //picks  a random article from all the articles
                        $slot1Article = $this->getRandomArticle( $this->allArticles );

                    } */
                }
            }

        }

        //if an article has been found
        if ($slot1Article) {

            $this->articlePanelSlots[1] = $slot1Article->id;

            //if the articleId parameter was NULL
            //if there is no article set in the DB for slot 1
            if ($articleId == NULL)
            {
                $this->assignArticleToDashboardSlot("", 1, $slot1Article->id);
            }

            return $slot1Article;

        } else {

            $this->articlePanelSlots[1] = NULL;

            return NULL;

        }

    }



    public function getRandomArticle($articles){
        //dd($articles);
    }


    /**
     * assignArticleToDashboardSlot
     * Assigns an article to a dasboard slot
     *
     * @param  mixed $slotId
     * @param  mixed $articleId
     * @return void
     */
    public function assignArticleToDashboardSlot(String $slotPrefix = "", Int $slotId, Int $articleId)
    {
        //if the user is logged in
        if (Auth::guard('web')->check())
        {
            Auth::guard('web')->user()->dashboard()->update([$slotPrefix.'slot_'.$slotId => $articleId]);
        }
    }






    /**
     * filterSlot2Article
     * filter articles for slot 2
     *
     * @param  mixed $articles
     * @return void
     */
    public function filterSlot2Article($articles)
    {

        $article = null;

        list($careerArticles, $carrerArticlesType) = $this->articlesService->getCareerArticles($articles);

        if (count($careerArticles) > 0){
            $article = Arr::random($careerArticles);

        } else {

            list($routeArticles, $routeArticlesType) = $this->articlesService->getRouteArticles($articles);

            if (count($routeArticles) > 0){
                $article = Arr::random($routeArticles);

            } else {

                list($sectorArticles, $sectorArticlesType) = $this->articlesService->getSectorArticles($articles);

                if (count($sectorArticles) > 0){
                    $article = Arr::random($sectorArticles);

                } else {

                    list($subjectArticles, $subjectArticlesType) = $this->articlesService->getSubjectArticles($articles);

                    if (count($subjectArticles) > 0){
                        $article = Arr::random($subjectArticles);

                    } else {

                        list($globalArticles, $globalArticlesType) = $this->articlesService->getGlobalArticles($articles);

                        if (count($globalArticles) > 0){
                            $article = Arr::random($globalArticles);

                        }

                    }

                }
            }

        }

        return $article;

    }




    /**
     * removesFromUnreadArticles
     * removes an article from the unread article collection
     *
     * @param  mixed $id
     * @return void
     */
    public function removesFromUnreadArticles($ids)
    {

        return $this->unreadArticles->filter(function ($article, $key) use ($ids){
            //return $article->id != $id;
            return !in_array($article->id, $ids);
        });

    }


    /**
     * removesFromAllArticles
     * removes an article from the unread article collection
     *
     * @param  mixed $id
     * @return void
     */
    public function removesFromAllArticles($ids)
    {

        return $this->allArticles->filter(function ($article, $key) use ($ids){
            //return $article->id != $id;
            return !in_array($article->id, $ids);
        });

    }


    public function getSlot2Article($articleId = NULL)
    {

        //if we need a specific article from the dashboard table
        $slot2Article = $this->articlesService->loadLiveArticle($articleId);

        //if the article is not live anymore / can not be found i the live table
        if (!$slot2Article)
        {

            $this->init();

            //removes from unread articles
            $this->unreadArticles = $this->removesFromUnreadArticles( $this->articlePanelSlots );

            //filters and try to find an article
            $slot2Article = $this->filterSlot2Article( $this->unreadArticles );

            //if no article found
            if (!$slot2Article){

                //get all articles read
                //$readArticles = $this->articlesService->getReadArticles();
                $readArticles = $this->articlesService->getReadArticlesNotInDashboard($this->articlePanelSlots);

                //filters and try to find an article from the already read articles
                $slot2Article = $this->filterSlot2Article($readArticles);

                //if no article found
                if (!$slot2Article) {

                    $this->getAllArticles();

                    //removes from all articles
                    $this->allArticles = $this->removesFromAllArticles( $this->articlePanelSlots );

                    //filters and try to find an article
                    $slot2Article = $this->filterSlot2Article( $this->allArticles );

                }

            }

        }

        if ($slot2Article) {

            $this->articlePanelSlots[2] = $slot2Article->id;

            //if the articleId parameter was NULL
            //if there is no article set in the DB for slot 2
            if ($articleId == NULL)
            {
                $this->assignArticleToDashboardSlot("", 2, $slot2Article->id);
            }

            return $slot2Article;

        } else {

            $this->articlePanelSlots[2] = NULL;

            return NULL;

        }

    }





    /**
     * getSlot3Article
     *
     * @return void
     */
    public function getSlot3Article($articleId = NULL)
    {

        //if we need a specific article from the dashboard table
        $slot3Article = $this->articlesService->loadLiveArticle($articleId);

        //if the article is not live anymore / can not be found i the live table
        if (!$slot3Article)
        {

            $this->init();

            //removes from unread articles
            $this->unreadArticles = $this->removesFromUnreadArticles( $this->articlePanelSlots );

            //filters and try to find an article
            $slot3Article = $this->filterSlot3Article( $this->unreadArticles );

            //if no article found
            if (!$slot3Article){

                //get all articles read
                //$readArticles = $this->articlesService->getReadArticles();
                $readArticles = $this->articlesService->getReadArticlesNotInDashboard($this->articlePanelSlots);

                //filters and try to find an article from the already read articles
                $slot3Article = $this->filterSlot3Article($readArticles);

                //if no article found
                if (!$slot3Article) {

                    $this->getAllArticles();

                    //removes from all articles
                    $this->allArticles = $this->removesFromAllArticles( $this->articlePanelSlots );

                    //filters and try to find an article
                    $slot3Article = $this->filterSlot3Article( $this->allArticles );

                }

            }

        }


        if ($slot3Article) {

            $this->articlePanelSlots[3] = $slot3Article->id;

            //if the articleId parameter was NULL
            //if there is no article set in the DB for slot 1
            if ($articleId == NULL)
            {
                $this->assignArticleToDashboardSlot("", 3, $slot3Article->id);
            }

            return $slot3Article;

        } else {

            $this->articlePanelSlots[3] = NULL;

            return NULL;

        }

    }


    /**
     * filterSlot3Article
     * filter articles for slot 3
     *
     * @param  mixed $articles
     * @return void
     */
    public function filterSlot3Article($articles)
    {

        $article = null;

        //filter by term ?? it is already filtered by term

        list($sectorArticles, $sectorArticlesType) = $this->articlesService->getSectorArticles($articles);

        if (count($sectorArticles) > 0){
            $article = Arr::random($sectorArticles);

        } else {

            list($subjectArticles, $subjectArticlesType) = $this->articlesService->getSubjectArticles($articles);

            if (count($subjectArticles) > 0){
                $article = Arr::random($subjectArticles);

            } else {

                list($careerArticles, $careerArticlesType) = $this->articlesService->getCareerArticles($articles);

                if (count($careerArticles) > 0){
                    $article = Arr::random($careerArticles);

                } else {

                    list($routeArticles, $routeArticlesType) = $this->articlesService->getRouteArticles($articles);

                    if (count($routeArticles) > 0){
                        $article = Arr::random($routeArticles);

                    } else {

                        list($globalArticles, $globalArticlesType) = $this->articlesService->getGlobalArticles($articles);

                        if (count($globalArticles) > 0){
                            $article = Arr::random($globalArticles);

                        }

                    }

                }
            }

        }

        return $article;

    }




    /**
     * getSlot4Article
     *
     * @return void
     */
    public function getSlot4Article($articleId = NULL)
    {

        //if we need a specific article from the dashboard table
        $slot4Article = $this->articlesService->loadLiveArticle($articleId);

        //if the article is not live anymore / can not be found i the live table
        if (!$slot4Article)
        {

            $this->init();

            //removes from unread articles
            $this->unreadArticles = $this->removesFromUnreadArticles( $this->articlePanelSlots );

            //filters and try to find an article
            $slot4Article = $this->filterSlot4Article( $this->unreadArticles );

            //if no article found
            if (!$slot4Article){

                //get all articles read
                //$readArticles = $this->articlesService->getReadArticles();
                $readArticles = $this->articlesService->getReadArticlesNotInDashboard($this->articlePanelSlots);

                //filters and try to find an article from the already read articles
                $slot4Article = $this->filterSlot4Article($readArticles);

                //if no article found
                if (!$slot4Article) {

                    $this->getAllArticles();

                    //removes from all articles
                    $this->allArticles = $this->removesFromAllArticles( $this->articlePanelSlots );

                    //filters and try to find an article
                    $slot4Article = $this->filterSlot4Article( $this->allArticles );

                }

            }

        }


        if ($slot4Article) {

            $this->articlePanelSlots[4] = $slot4Article->id;

            //if the articleId parameter was NULL
            //if there is no article set in the DB for slot 1
            if ($articleId == NULL)
            {
                $this->assignArticleToDashboardSlot("", 4, $slot4Article->id);
            }

            return $slot4Article;

        } else {

            $this->articlePanelSlots[4] = NULL;

            return NULL;

        }

    }


    /**
     * filterSlot4Article
     * filter articles for slot 4
     *
     * @param  mixed $articles
     * @return void
     */
    public function filterSlot4Article($articles)
    {

        $article = null;
/*
        list($subjectArticles, $subjectArticlesType) = $this->articlesService->getSubjectArticles($articles);

        list($sectorArticles, $sectorArticlesType) = $this->articlesService->getSectorArticles($articles);

        $selectedArticles = array_merge($subjectArticles, $sectorArticles);

        if (count($selectedArticles) > 0){
            $article = Arr::random($selectedArticles);

        } else {

            list($routeArticles, $routeArticlesType) = $this->articlesService->getRouteArticles($articles);

            if (count($routeArticles) > 0){
                $article = Arr::random($routeArticles);

            } else {

                list($careerArticles, $careerArticlesType) = $this->articlesService->getCareerArticles($articles);

                if (count($careerArticles) > 0){
                    $article = Arr::random($careerArticles);

                } else {

                    list($globalArticles, $globalArticlesType) = $this->articlesService->getGlobalArticles($articles);

                    if (count($globalArticles) > 0){
                        $article = Arr::random($globalArticles);

                    }

                }

            }

        }
*/


        list($routeArticles, $routeArticlesType) = $this->articlesService->getRouteArticles($articles);

        if (count($routeArticles) > 0){
            $article = Arr::random($routeArticles);
            return $article;
        }

        return NULL;

    }




    /**
     * getSlot5Article
     *
     * @return void
     */
    public function getSlot5Article($articleId = NULL)
    {

        //if we need a specific article from the dashboard table
        $slot5Article = $this->articlesService->loadLiveArticle($articleId);

        //if the article is not live anymore / can not be found i the live table
        if (!$slot5Article)
        {

            $this->init();

            //removes from unread articles
            $this->unreadArticles = $this->removesFromUnreadArticles( $this->articlePanelSlots );

            //filters and try to find an article
            $slot5Article = $this->filterSlot5Article( $this->unreadArticles );

            //if no article found
            if (!$slot5Article){

                //get all articles read
                //$readArticles = $this->articlesService->getReadArticles();
                $readArticles = $this->articlesService->getReadArticlesNotInDashboard($this->articlePanelSlots);

                //filters and try to find an article from the already read articles
                $slot5Article = $this->filterSlot5Article($readArticles);

                //if no article found
                if (!$slot5Article) {

                    $this->getAllArticles();

                    //removes from all articles
                    $this->allArticles = $this->removesFromAllArticles( $this->articlePanelSlots );

                    //filters and try to find an article
                    $slot5Article = $this->filterSlot5Article( $this->allArticles );

                }

            }

        }


        if ($slot5Article) {

            $this->articlePanelSlots[5] = $slot5Article->id;

            //if the articleId parameter was NULL
            //if there is no article set in the DB for slot 1
            if ($articleId == NULL)
            {
                $this->assignArticleToDashboardSlot("", 5, $slot5Article->id);
            }

            return $slot5Article;

        } else {

            $this->articlePanelSlots[5] = NULL;

            return NULL;

        }

    }


    /**
     * filterSlot5Article
     * filter articles for slot 5
     *
     * @param  mixed $articles
     * @return void
     */
    public function filterSlot5Article($articles)
    {

        $article = null;



        /* list($subjectArticles, $subjectArticlesType) = $this->articlesService->getSubjectArticles($articles);

        list($sectorArticles, $sectorArticlesType) = $this->articlesService->getSectorArticles($articles);

        //selects which group of articles to display
        if ($subjectArticles == "high_priority_articles"){
            $selectedArticles = $subjectArticles;
        } elseif ($sectorArticles == "high_priority_articles"){
            $selectedArticles = $sectorArticles;
        } elseif ($subjectArticles == "neet_articles"){
            $selectedArticles = $subjectArticles;
        } else if ($sectorArticles == "neet_articles"){
            $selectedArticles = $sectorArticles;
        } else {
            $selectedArticles = array_merge($subjectArticles, $sectorArticles);
        }

        if (count($selectedArticles) > 0){
            $article = Arr::random($selectedArticles);

        } else {

            list($careerArticles, $careerArticlesType) = $this->articlesService->getCareerArticles($articles);

            if (count($careerArticles) > 0){
                $article = Arr::random($careerArticles);

            } else {

                list($routeArticles, $routeArticlesType) = $this->articlesService->getRouteArticles($articles);

                if (count($routeArticles) > 0){
                    $article = Arr::random($routeArticles);

                } else {

                    list($globalArticles, $globalArticlesType) = $this->articlesService->getGlobalArticles($articles);

                    if (count($globalArticles) > 0){
                        $article = Arr::random($globalArticles);

                    }

                }

            }

        } */

        list($sectorArticles, $sectorArticlesType) = $this->articlesService->getSectorArticles($articles);

        if (count($sectorArticles) > 0){
            $article = Arr::random($sectorArticles);
            return $article;
        }

        return NULL;

    }







    /**
     * getSlot6Article
     *
     * @return void
     */
    public function getSlot6Article($articleId = NULL)
    {

        //if we need a specific article from the dashboard table
        $slot6Article = $this->articlesService->loadLiveArticle($articleId);

        //if the article is not live anymore / can not be found i the live table
        if (!$slot6Article)
        {

            $this->init();

            //removes from unread articles
            $this->unreadArticles = $this->removesFromUnreadArticles( $this->articlePanelSlots );

            //filters and try to find an article
            $slot6Article = $this->filterSlot6Article( $this->unreadArticles );

            //if no article found
            if (!$slot6Article){

                //get all articles read
                //$readArticles = $this->articlesService->getReadArticles();
                $readArticles = $this->articlesService->getReadArticlesNotInDashboard($this->articlePanelSlots);

                //filters and try to find an article from the already read articles
                $slot6Article = $this->filterSlot6Article($readArticles);

                //if no article found
                if (!$slot6Article) {

                    //use the forst unread article from the collection
                    //$slot6Article = $this->unreadArticles->first();

                    $this->getAllArticles();

                    //removes from all articles
                    $this->allArticles = $this->removesFromAllArticles( $this->articlePanelSlots );

                    //filters and try to find an article
                    $slot6Article = $this->filterSlot6Article( $this->allArticles );


                }

            }

        }


        if ($slot6Article) {

            $this->articlePanelSlots[5] = $slot6Article->id;

            //if the articleId parameter was NULL
            //if there is no article set in the DB for slot 1
            if ($articleId == NULL)
            {
                $this->assignArticleToDashboardSlot("", 6, $slot6Article->id);
            }

            return $slot6Article;

        } else {

            $this->articlePanelSlots[5] = NULL;

            return NULL;

        }

    }


    /**
     * filterSlot6Article
     * filter articles for slot 6
     *
     * @param  mixed $articles
     * @return void
     */
    public function filterSlot6Article($articles)
    {

        $article = null;

        /* list($subjectArticles, $subjectArticlesType) = $this->articlesService->getSubjectArticles($articles);

        list($sectorArticles, $sectorArticlesType) = $this->articlesService->getSectorArticles($articles);

        //selects which group of articles to display
        if ($subjectArticles == "high_priority_articles"){
            $selectedArticles = $subjectArticles;
        } elseif ($sectorArticles == "high_priority_articles"){
            $selectedArticles = $sectorArticles;
        } elseif ($subjectArticles == "neet_articles"){
            $selectedArticles = $subjectArticles;
        } else if ($sectorArticles == "neet_articles"){
            $selectedArticles = $sectorArticles;
        } else {
            $selectedArticles = array_merge($subjectArticles, $sectorArticles);
        }

        if (count($selectedArticles) > 0){
            $article = Arr::random($selectedArticles);

        } else {

            list($careerArticles, $careerArticlesType) = $this->articlesService->getCareerArticles($articles);

            if (count($careerArticles) > 0){
                $article = Arr::random($careerArticles);

            } else {

                list($routeArticles, $routeArticlesType) = $this->articlesService->getRouteArticles($articles);

                if (count($routeArticles) > 0){
                    $article = Arr::random($routeArticles);

                } else {

                    list($globalArticles, $globalArticlesType) = $this->articlesService->getGlobalArticles($articles);

                    if (count($globalArticles) > 0){
                        $article = Arr::random($globalArticles);

                    }

                }

            }

        } */


        list($ubjectArticles, $subjetArticlesType) = $this->articlesService->getSubjectArticles($articles);

        if (count($ubjectArticles) > 0){
            $article = Arr::random($ubjectArticles);
            return $article;
        }

        return NULL;

    }


}
