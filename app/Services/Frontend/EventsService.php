<?php

namespace App\Services\Frontend;

use App\Models\EventLive;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\Frontend\ArticlesService;

Class EventsService
{

    protected $articlesService;

    public function __construct(ArticlesService $articlesService)
    {
        $this->articlesService = $articlesService;
    }



    /**
     * getUpcomingEvents
     *
     * @param  mixed $nb_events
     * @return void
     */
    public function getUpcomingEvents($nb_events, Array $exclude=[], $order='asc')
    {

        $query = EventLive::select('id', 'summary_heading', 'summary_text', 'slug', 'date', 'start_time_hour', 'start_time_min', 'contact_name')
                            ->whereDate('date', '>', Carbon::today()->toDateString())
                            ->Where(function($query) {
                                $query->where('client_id', NULL)
                                ->orWhere('client_id', Session::get('fe_client')['id']);
                            })
                            ->with('media')
                            ->orderBy('date', $order)
                            ->limit($nb_events);

        if (count($exclude) > 0)
        {
            $query =  $query->whereNotIn('id', $exclude);
        }

        return $query->get();

    }




    /**
     * getBestMatchUpcomingEvents
     *
     * @param  mixed $nb_events
     * @return void
     */
    public function getBestMatchUpcomingEvents($nb_events)
    {

        //gets the user's institution
        $userInstitution = Auth::guard('web')->user()->institution()->first();

        //gets events allocated specifically to the user's institution
        $institutionEvents = $userInstitution->eventsLiveSummaryAndUpcoming($nb_events)->get();

        //initialises the collection of best match events
        $bestMatchEvents = $institutionEvents;

        //nb events found
        $nbBestMatchEvents = count($bestMatchEvents);
        ;
        if ($nbBestMatchEvents < 4)
        {

            $requiredXtraEvents = 4 - $nbBestMatchEvents;

            $routeEvents = $this->getEventsByTagType("route", $bestMatchEvents, $requiredXtraEvents);

            //nb route events found
            $bestMatchEvents = $bestMatchEvents->merge($routeEvents);

            //nb events found
            $nbBestMatchEvents = count($bestMatchEvents);

            if ($nbBestMatchEvents < 4)
            {

                $requiredXtraEvents = 4 - $nbBestMatchEvents;

                $sectorEvents = $this->getEventsByTagType("sector", $bestMatchEvents, $requiredXtraEvents);

                //nb sector events found
                $bestMatchEvents = $bestMatchEvents->merge($sectorEvents);

                //nb events found
                $nbBestMatchEvents = count($bestMatchEvents);

                if ($nbBestMatchEvents < 4)
                {

                    $requiredXtraEvents = 4 - $nbBestMatchEvents;

                    $subjectEvents = $this->getEventsByTagType("subject", $bestMatchEvents, $requiredXtraEvents);

                    //nb subject events found
                    $bestMatchEvents = $bestMatchEvents->merge($subjectEvents);

                    //nb events found
                    $nbBestMatchEvents = count($bestMatchEvents);

                }

            }

        }

        return $bestMatchEvents;

    }



    public function getEventsByTagType($tagsType, $events, $limit)
    {

        //gets the assessment 'route' tags
        $selfAssessmentTags = app('selfAssessmentSingleton')->getAllocatedTags('route');

        //extracts the ids and store in array
        $selfAssessmentTagsNames = $selfAssessmentTags->pluck('name')->toArray();

        $subsetEvents = $events->map(function ($event) {
            return $event->id;
        });


        $query = EventLive::select('id', 'summary_heading', 'summary_text', 'slug', 'date', 'start_time_hour', 'start_time_min')
                        ->whereDate('date', '>', Carbon::today()->toDateString())
                        ->Where(function($query) {
                            $query->where('client_id', NULL)
                            ->orWhere('client_id', Session::get('fe_client')['id']);
                        })
                        ->withAnyTags($selfAssessmentTagsNames, $tagsType)
                        ->with('media')
                        ->orderBy('date', 'asc')
                        ->limit($limit);

        //do not select events already selected
        if (count($subsetEvents) > 0)
        {
            $query = $query->whereNotIN('id', [$subsetEvents->first()]);
        }

        return $query->get();
    }





    /**
     * getFutureEvents
     *
     * @param  mixed $nb_events
     * @return void
     */
    public function getFutureEvents($offset, $nb_events)
    {
        return EventLive::select('id', 'summary_heading', 'slug', 'date', 'start_time_hour', 'start_time_min')
                        ->whereDate('date', '>', Carbon::today()->toDateString())
                        ->Where(function($query) {
                            $query->where('client_id', NULL)
                            ->orWhere('client_id',  Session::get('fe_client')['id']);
                        })
                        ->with('media')
                        ->orderBy('date', 'asc')
                        ->limit($nb_events)
                        ->offset($offset)
                        ->get();

    }




    /**
     * loadRelatedArticlesToEvent
     *
     * @param  mixed $id
     * @return void
     */
    public function loadRelatedArticlesToEvent($id)
    {

        $event = EventLive::findOrFail($id);

        //collect the route tags
        $eventsRoutes = $event->tagsWithType('route');

        //extracts the ids and store in array
        $eventTagsNames = $eventsRoutes->pluck('name')->toArray();

        //gets related articles
        $routeArticles = $this->articlesService->getArticlesForCurrentYearAndTermAndSomeType($eventTagsNames, 'route', 0, 3);

        //adds the collection
        $relatedArticles = $routeArticles;



        $nbRelatedArticles = count($relatedArticles);

        //if we have less than 3 articles, get some sector articles
        if ($nbRelatedArticles < 3)
        {
            //counts the number of articles required to complete the list of 3
            $nbArticlesRequired = 3 - $nbRelatedArticles;

            //collect the route tags
            $eventsSectors = $event->tagsWithType('sector');

            //extracts the ids and store in array
            $eventTagsNames = $eventsSectors->pluck('name')->toArray();

            //gets related articles
            $sectorArticles = $this->articlesService->getArticlesForCurrentYearAndTermAndSomeType($eventTagsNames, 'sector', 0, $nbArticlesRequired);

            //adds the collection
            $relatedArticles = $relatedArticles->merge($sectorArticles);
        }





        $nbRelatedArticles = count($relatedArticles);

        //if we have less than 3 articles, get some subject articles
        if ($nbRelatedArticles < 3)
        {
            //counts the number of articles required to complete the list of 3
            $nbArticlesRequired = 3 - $nbRelatedArticles;

            //collect the route tags
            $eventsSubjects = $event->tagsWithType('subject');

            //extracts the ids and store in array
            $eventTagsNames = $eventsSubjects->pluck('name')->toArray();

            //gets related articles
            $subjectArticles = $this->articlesService->getArticlesForCurrentYearAndTermAndSomeType($eventTagsNames, 'subject', 0, 3);

            //adds the collection
            $relatedArticles = $relatedArticles->merge($subjectArticles);

        }

        if ($relatedArticles)
        {
            return $relatedArticles->shuffle();
        } else {
            return collect([]);
        }

    }



   /**
     * loadLiveArticle
     * Loads an article summary data
     *
     * @param  mixed $articleId
     * @return void
     */
    public function loadLiveEvent($eventId = NULL)
    {

        if (!is_null($eventId))
        {

            //checks if the article is still live
            return EventLive::select('id', 'summary_heading', 'slug', 'date', 'start_time_hour', 'start_time_min')
                        ->where('id', $eventId)
                        ->whereDate('date', '>=', Carbon::today()->toDateString())
                        ->Where(function($query) {
                            $query->where('client_id', NULL)
                            ->orWhere('client_id',  Session::get('fe_client')['id']);
                        })
                        ->with('media')
                        ->orderBy('date', 'asc')
                        ->first();

        }

        return NULL;

    }
}
