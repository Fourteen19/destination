<?php

namespace App\Services\Frontend;

use App\Models\User;
use App\Models\SystemTag;
use App\Models\ContentLive;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Class contentArticlesPanelService
{

    //contains the ID of articles displayed in the panel
    //this is used to prevent duplication
    protected $articlePanel;

    //contains global articles
//    protected $globalArticles;

    //contains articles related to the year
//    protected $yearArticles;

    //protected $selfAssessmentService;

    protected $unreadArticles;

    protected $allArticles;

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    //public function __construct(selfAssessmentService $selfAssessmentService) {
    public function __construct() {

        $this->selfAssessmentService = app('selfAssessmentSingleton');

        //dd( $this->selfAssessmentService );

        ///$this->articlePanel = [];

        //keeps track of the articles allocated to the slots
        $this->articlePanelSlots = [];

        //contains the unread articles
        $this->unreadArticles = [];

        //contains the unread/read articles not filtered by term. Used in case we do not find any article to display in dashboard
        $this->allArticles = [];
    }



    public function init()
    {

        //get all unread articles
        if (empty( $this->unreadArticles ))
        {
            $this->unreadArticles = $this->getUnreadArticles();
        }

    }


    /**
     * getAllArticles
     * selects all the articles related to a year
     *
     * @return void
     */
    public function getAllArticles()
    {

        //get all unread articles
        if (empty( $this->allArticles ))
        {
            $this->allArticles = $this->getAllReadUnreadArticles();
        }

    }

    /**
     * Get all the live route Tags
     *
     * @return void
     */
/*    public function getLiveRouteTags()
    {

        return $this->routeTags = SystemTag::withLive('Y')->withType('route')->get('name')->toArray();

    }
*/


    /**
     * Gets all the articles read by a user
     *
     * @return void
     */
    public function getArticlesRead($user = NULL){

        if ($user == NULL){
            $user = auth()->user();
        }

        return $user->articles()->get()->pluck('id')->toArray();

    }



/*  alg 1
    public function getUnreadRouteArticles(Array $articlesAlreadyRead, Int $year)
    {

        //////////////////
        //gets the route tags associated to the current user
        ////////////////

        //gets allocated LIVE `route` tags for the current assessment
        $selfAssessmentRouteTags = $this->selfAssessmentService->getAllocatedRouteTags();

        if ($selfAssessmentRouteTags != null)
        {

            //sort the tags by score
            $sortedRouteTags = $selfAssessmentRouteTags->sortBy(function ($tag, $key) {
                return $tag->pivot->score + $tag->pivot->total_score;
            });


            //for each `route` tag
            foreach($sortedRouteTags as $key => $tag){

                //gets the live articles for the route
                $liveArticles = ContentLive::withAnyTags([$tag->name], 'route')->withAnyTags([ $year ], 'year')->get();

                //filters articles that have not been read
                $notReadArticlesForTag = $liveArticles->filter(function ($article, $articlekey) use ($articlesAlreadyRead) {
                    return (!in_array($article->id, $articlesAlreadyRead));
                });

            }

            return $notReadArticlesForTag;

        } else {

            return null;

        }

    }



    public function getUnreadCareerArticles(Array $articlesAlreadyRead, Int $year)
    {

        //gets career tag
        $selfAssessmentCareerTag = $this->selfAssessmentService->getCareerReadinessTags();

        if ($selfAssessmentCareerTag != null)
        {

            //gets the live articles for the `career` tag. We use first() as there can only be 1 `career` tag allocated to a user
            $careerLiveArticles = ContentLive::withAnyTags([$selfAssessmentCareerTag->first()->name], 'career_readiness')->withAnyTags([ $year ], 'year')->get();

            //filters articles that have not been read
            $notReadArticlesForTag = $careerLiveArticles->filter(function ($article, $articlekey) use ($articlesAlreadyRead) {
                return (!in_array($article->id, $articlesAlreadyRead));
            });

            return $notReadArticlesForTag;

        }

        return null;

    }

*/


    //alg 2
    /**
     * getRouteArticles
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

        }

        return $slotArticles;


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
        return ContentLive::withAnyTags([ auth()->user()->school_year ], 'year')
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
        return ContentLive::withAnyTags([ auth()->user()->school_year ], 'year')
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
        return ContentLive::withAnyTags([ auth()->user()->school_year ], 'year')
                                                ->with('tags') // eager loads all the tags for the article
                                                ->get();

    }


    /**
     * filterSlot1Article
     * filter articles for slot 1
     *
     * @param  mixed $articles
     * @return void
     */
    public function filterSlot1Article($articles)
    {

        $article = null;

        $routeArticles = $this->getRouteArticles($articles);

        $careerArticles = $this->getCareerArticles($articles);

        $selectedArticles = array_merge($routeArticles, $careerArticles);

        if (count($selectedArticles) > 0){
            $article = Arr::random($selectedArticles);
        } else {

            $sectorArticles = $this->getSectorArticles($articles);

            if (count($sectorArticles) > 0){
                $article = Arr::random($sectorArticles);

            } else {

                $subjectArticles = $this->getSubjectArticles($articles);

                if (count($subjectArticles) > 0){
                    $article = Arr::random($subjectArticles);

                } else {

                    $globalArticles = $this->getGlobalArticles($articles);

                    if (count($globalArticles) > 0){
                        $article = Arr::random($globalArticles);

                    }

                }

            }

        }

        return $article;

    }





    public function getSlot1Article()
    {

        //////////////////
        //gets the user articles already read, converts the collection to an array of IDs
        ////////////////
/*
        $articlesAlreadyRead = $this->getArticlesRead();
//dd($articlesAlreadyRead);


        $notReadArticles = collect([]);

        //gets the unread articles for `Route` Tags filtered by user's current year
        $notReadRouteArticles = $this->getUnreadRouteArticles($articlesAlreadyRead, auth()->user()->school_year);
//dd($notReadRouteArticles);

        //append to list
        $notReadArticles = $notReadArticles->merge($notReadRouteArticles);
//dd($notReadArticles);

        $notReadCareerArticles = $this->getUnreadCareerArticles($articlesAlreadyRead, auth()->user()->school_year);

        //append to list
        $notReadArticles = $notReadArticles->merge($notReadCareerArticles);
//        dd($notReadArticles);
*/

        //RIck algorithm
       // $articlesAlreadyRead = $this->getArticlesRead();
//dd(app('currentTerm'));


////        $LiveGlobalArticles = ContentLive::withAnyTags([ 'global' ], 'flag')->get();
//dd($LiveGlobalArticles);

////        $unreadLiveGlobalArticles = $LiveGlobalArticles->whereNotIn('id', $articlesAlreadyRead);
//dd($unreadLiveGlobalArticles);   ->withAnyTags([ "Automn-Winter" ], 'term')



/////        $selfAssessmentRouteTags = $this->selfAssessmentService->getAllocatedRouteTags();
//        dd($selfAssessmentRouteTags);

/*
        $unreadLiveArticles = ContentLive::withAnyTags([ auth()->user()->school_year ], 'year')
                                        ->withAnyTags( [ app('currentTerm') ] , 'term')
                                        ->whereNotIn('id', $articlesAlreadyRead)
                                        ->with('tags') //preloads all the tags for the article
                                        ->get();

 */



        $this->init();

        //filters and try to find an article
        $slot1Article = $this->filterSlot1Article( $this->unreadArticles );
//dd($this->unreadArticles);
        //if no article found
        if (!$slot1Article){

            //get all articles already read
            $readArticles = $this->getReadArticles();

            //filters and try to find an article from the already read articles
            $slot1Article = $this->filterSlot1Article($readArticles);

            //if no article found
            if (!$slot1Article) {

                //use the forst unread article from the collection
                //$slot1Article = $this->unreadArticles->first();

                $this->getAllArticles();

                //removes from all articles
                //$this->allArticles = $this->removesFromAllArticles( $this->articlePanelSlots[5] );

                //filters and try to find an article
                $slot1Article = $this->filterSlot1Article( $this->allArticles );

            }
        }

        $this->articlePanelSlots[1] = $slot1Article->id;

        return $slot1Article;

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

        $careerArticles = $this->getCareerArticles($articles);

        if (count($careerArticles) > 0){
            $article = Arr::random($careerArticles);

        } else {

            $routeArticles = $this->getRouteArticles($articles);

            if (count($routeArticles) > 0){
                $article = Arr::random($routeArticles);

            } else {

                $sectorArticles = $this->getSectorArticles($articles);

                if (count($sectorArticles) > 0){
                    $article = Arr::random($sectorArticles);

                } else {

                    $subjectArticles = $this->getSubjectArticles($articles);

                    if (count($subjectArticles) > 0){
                        $article = Arr::random($subjectArticles);

                    } else {

                        $globalArticles = $this->getGlobalArticles($articles);

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
    public function removesFromUnreadArticles($id)
    {

        return $this->unreadArticles->filter(function ($article, $key) use ($id){
            return $article->id != $id;
        });

    }


    /**
     * removesFromAllArticles
     * removes an article from the unread article collection
     *
     * @param  mixed $id
     * @return void
     */
    public function removesFromAllArticles($id)
    {

        return $this->allArticles->filter(function ($article, $key) use ($id){
            return $article->id != $id;
        });

    }


    public function getSlot2Article()
    {
        $this->init();

        //removes from unread articles
        $this->unreadArticles = $this->removesFromUnreadArticles( $this->articlePanelSlots[1] );

        //filters and try to find an article
        $slot2Article = $this->filterSlot2Article( $this->unreadArticles );

        //if no article found
        if (!$slot2Article){

            //get all articles read
            $readArticles = $this->getReadArticles();

            //filters and try to find an article from the already read articles
            $slot2Article = $this->filterSlot2Article($readArticles);

            //if no article found
            if (!$slot2Article) {

                $this->getAllArticles();

                //removes from all articles
                $this->allArticles = $this->removesFromAllArticles( $this->articlePanelSlots[1] );

                //filters and try to find an article
                $slot2Article = $this->filterSlot2Article( $this->allArticles );

            }

        }

        $this->articlePanelSlots[2] = $slot2Article->id;

        return $slot2Article;

    }





    /**
     * getSlot3Article
     *
     * @return void
     */
    public function getSlot3Article()
    {
        $this->init();

        //removes from unread articles
        $this->unreadArticles = $this->removesFromUnreadArticles( $this->articlePanelSlots[2] );

        //filters and try to find an article
        $slot3Article = $this->filterSlot3Article( $this->unreadArticles );

        //if no article found
        if (!$slot3Article){

            //get all articles read
            $readArticles = $this->getReadArticles();

            //filters and try to find an article from the already read articles
            $slot3Article = $this->filterSlot3Article($readArticles);

            //if no article found
            if (!$slot3Article) {

                $this->getAllArticles();

                //removes from all articles
                $this->allArticles = $this->removesFromAllArticles( $this->articlePanelSlots[2] );

                //filters and try to find an article
                $slot3Article = $this->filterSlot3Article( $this->allArticles );

            }

        }

        if ($slot3Article->id){
            $this->articlePanelSlots[3] = $slot3Article->id;
        }

        return $slot3Article;

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

        $sectorArticles = $this->getSectorArticles($articles);

        if (count($sectorArticles) > 0){
            $article = Arr::random($sectorArticles);

        } else {

            $subjectArticles = $this->getSubjectArticles($articles);

            if (count($subjectArticles) > 0){
                $article = Arr::random($subjectArticles);

            } else {

                $careerArticles = $this->getCareerArticles($articles);

                if (count($careerArticles) > 0){
                    $article = Arr::random($careerArticles);

                } else {

                    $routeArticles = $this->getRouteArticles($articles);

                    if (count($routeArticles) > 0){
                        $article = Arr::random($routeArticles);

                    } else {

                        $globalArticles = $this->getGlobalArticles($articles);

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
    public function getSlot4Article()
    {
        $this->init();

        //removes from unread articles
        $this->unreadArticles = $this->removesFromUnreadArticles( $this->articlePanelSlots[3] );

        //filters and try to find an article
        $slot4Article = $this->filterSlot4Article( $this->unreadArticles );
//dd($slot4Article);
        //if no article found
        if (!$slot4Article){

            //get all articles read
            $readArticles = $this->getReadArticles();

            //filters and try to find an article from the already read articles
            $slot4Article = $this->filterSlot4Article($readArticles);

            //if no article found
            if (!$slot4Article) {

                $this->getAllArticles();

                //removes from all articles
                $this->allArticles = $this->removesFromAllArticles( $this->articlePanelSlots[3] );

                //filters and try to find an article
                $slot4Article = $this->filterSlot4Article( $this->allArticles );

            }

        }

        $this->articlePanelSlots[4] = $slot4Article->id;

        return $slot4Article;

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

        $subjectArticles = $this->getSubjectArticles($articles);

        $sectorArticles = $this->getSectorArticles($articles);

        $selectedArticles = array_merge($subjectArticles, $sectorArticles);

        if (count($selectedArticles) > 0){
            $article = Arr::random($selectedArticles);

        } else {

            $routeArticles = $this->getRouteArticles($articles);

            if (count($routeArticles) > 0){
                $article = Arr::random($routeArticles);

            } else {

                $careerArticles = $this->getCareerArticles($articles);

                if (count($careerArticles) > 0){
                    $article = Arr::random($careerArticles);

                } else {

                    if (1==1){

                        //filter by term??

                    } else {

                        $globalArticles = $this->getGlobalArticles($articles);

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
     * getSlot5Article
     *
     * @return void
     */
    public function getSlot5Article()
    {
        $this->init();

        //removes from unread articles
        $this->unreadArticles = $this->removesFromUnreadArticles( $this->articlePanelSlots[4] );

        //filters and try to find an article
        $slot5Article = $this->filterSlot5Article( $this->unreadArticles );

        //if no article found
        if (!$slot5Article){

            //get all articles read
            $readArticles = $this->getReadArticles();

            //filters and try to find an article from the already read articles
            $slot5Article = $this->filterSlot5Article($readArticles);

            //if no article found
            if (!$slot5Article) {

                $this->getAllArticles();

                //removes from all articles
                $this->allArticles = $this->removesFromAllArticles( $this->articlePanelSlots[4] );

                //filters and try to find an article
                $slot5Article = $this->filterSlot5Article( $this->allArticles );


            }

        }

        $this->articlePanelSlots[5] = $slot5Article->id;

        return $slot5Article;

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

        $subjectArticles = $this->getSubjectArticles($articles);

        $sectorArticles = $this->getSectorArticles($articles);

        $selectedArticles = array_merge($subjectArticles, $sectorArticles);

        if (count($selectedArticles) > 0){
            $article = Arr::random($selectedArticles);

        } else {

            $careerArticles = $this->getCareerArticles($articles);

            if (count($careerArticles) > 0){
                $article = Arr::random($careerArticles);

            } else {

                $routeArticles = $this->getRouteArticles($articles);

                if (count($routeArticles) > 0){
                    $article = Arr::random($routeArticles);

                } else {

                    if (1==0){

                        //filter by term??

                    } else {

                        $globalArticles = $this->getGlobalArticles($articles);

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
     * getSlot6Article
     *
     * @return void
     */
    public function getSlot6Article()
    {
        $this->init();

        //removes from unread articles
        $this->unreadArticles = $this->removesFromUnreadArticles( $this->articlePanelSlots[5] );

        //filters and try to find an article
        $slot6Article = $this->filterSlot6Article( $this->unreadArticles );
//dd($slot6Article);
        //if no article found
        if (!$slot6Article){

            //get all articles read
            $readArticles = $this->getReadArticles();

            //filters and try to find an article from the already read articles
            $slot6Article = $this->filterSlot6Article($readArticles);

            //if no article found
            if (!$slot6Article) {

                //use the forst unread article from the collection
                //$slot6Article = $this->unreadArticles->first();

                $this->getAllArticles();

                //removes from all articles
                $this->allArticles = $this->removesFromAllArticles( $this->articlePanelSlots[5] );

                //filters and try to find an article
                $slot6Article = $this->filterSlot6Article( $this->allArticles );


            }

        }

        $this->articlePanelSlots[5] = $slot6Article->id;

        return $slot6Article;

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

        $subjectArticles = $this->getSubjectArticles($articles);

        $sectorArticles = $this->getSectorArticles($articles);

        $selectedArticles = array_merge($subjectArticles, $sectorArticles);

        if (count($selectedArticles) > 0){
            $article = Arr::random($selectedArticles);

        } else {

            if (1==0){

                //filter by term??
            } else {

                $careerArticles = $this->getCareerArticles($articles);

                if (count($careerArticles) > 0){
                    $article = Arr::random($careerArticles);

                } else {

                    $routeArticles = $this->getRouteArticles($articles);

                    if (count($routeArticles) > 0){
                        $article = Arr::random($routeArticles);

                    } else {

                        $globalArticles = $this->getGlobalArticles($articles);

                        if (count($globalArticles) > 0){
                            $article = Arr::random($globalArticles);

                        }

                    }

                }

            }

        }

        return $article;

    }


}
