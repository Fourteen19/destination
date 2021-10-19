<?php

namespace App\Services\Frontend;

use App\Models\EventLive;
use Illuminate\Support\Carbon;
use App\Models\EventsTotalStats;
use Illuminate\Support\Facades\DB;
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
                            ->whereDate('date', '>=', Carbon::today()->toDateString())
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

        //if logged in, filter by institution
        if (Auth::guard('web')->check())
        {

            if (Auth::guard('web')->user()->type == 'user')
            {
                $query = $query->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                ->withAnyTags( [ app('currentTerm') ] , 'term')
                                ->Where(function($query) {
                                    $query->where('all_institutions', 'Y')
                                        ->orwhereHas('institutions', function ($query) {
                                                $query->where('institution_id', Auth::guard('web')->user()->institution_id);
                                            });
                                    });

            } else {

                $query = $query->Where(function($query) {
                                    $query->where('all_institutions', 'Y')
                                        ->orwhereHas('institutions', function ($query) {
                                                $query->where('institution_id', Auth::guard('web')->user()->institution_id);
                                            });
                                    });

            }

        //if not logged in, exclude internal events
        } else {

            $query =  $query->IsNotInternal();
        }

        return $query->get();

    }





    public function getBestMatchUpcomingEvents($nb_events, Array $exclude=[], $order='asc')
    {

        $selfAssessmentRouteTags = app('selfAssessmentSingleton')->getAllocatedTags('route');
        $selfAssessmentRouteTagsNames = $selfAssessmentRouteTags->pluck('name')->toArray();

        $selfAssessmentSectorTags = app('selfAssessmentSingleton')->getAllocatedTags('sector');
        $selfAssessmentSectorTagsNames = $selfAssessmentSectorTags->pluck('name')->toArray();

        $selfAssessmentSubjectTags = app('selfAssessmentSingleton')->getCompiledAllocatedSubjectTags();


        $query = EventLive::select('id', 'summary_heading', 'summary_text', 'slug', 'date', 'start_time_hour', 'start_time_min', 'contact_name')
                            ->whereDate('date', '>=', Carbon::today()->toDateString())
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

        //if logged in, filter by institution
        if (Auth::guard('web')->check())
        {

            if (Auth::guard('web')->user()->type == 'user')
            {

                //filters by year
                //filters by term
                //filters by institution
                $query = $query->Where(function($query) {
                                    $query->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                        ->withAnyTags( [ app('currentTerm') ] , 'term')
                                        ->Where(function($query) {
                                            $query->where('all_institutions', 'Y')
                                                ->orwhereHas('institutions', function ($query) {
                                                        $query->where('institution_id', Auth::guard('web')->user()->institution_id);
                                                    });
                                            });
                                    });

                //filters by tags
                $query = $query->Where(function($query) use ($selfAssessmentRouteTagsNames, $selfAssessmentSectorTagsNames, $selfAssessmentSubjectTags) {
                                    $query->withAnyTags( $selfAssessmentRouteTagsNames , 'route');
                                    $query->OrWhere(function($query) use ($selfAssessmentSectorTagsNames) {
                                        $query->withAnyTags( $selfAssessmentSectorTagsNames , 'sector');
                                    });
                                    $query->OrWhere(function($query) use ($selfAssessmentSubjectTags) {
                                        $query->withAnyTags( $selfAssessmentSubjectTags , 'subject');
                                    });
                                });

            } else {

                //filters by year
                //filters by term
                //filters by institution
                $query = $query->Where(function($query) {
                                $query->Where(function($query) {
                                        $query->where('all_institutions', 'Y')
                                            ->orwhereHas('institutions', function ($query) {
                                                    $query->where('institution_id', Auth::guard('web')->user()->institution_id);
                                                });
                                        });
                                });

            }

        }

        return $query->get();

    }



    /**
     * getBestMatchUpcomingEvents
     *
     * @param  mixed $nb_events
     * @return void
     */
    /* public function getBestMatchUpcomingEvents($nb_events)
    {

        //gets the user's institution
        //$userInstitution = Auth::guard('web')->user()->institution()->first();

        //gets events allocated specifically to the user's institution
        //$institutionEvents = $userInstitution->eventsLiveSummaryAndUpcoming($nb_events)->get();

        $institutionEvents = $this->getUpcomingEvents($nb_events, [], $order='asc');

        //initialises the collection of best match events
        $bestMatchEvents = $institutionEvents;

        //nb events found
        $nbBestMatchEvents = count($bestMatchEvents);

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

    } */



    public function getEventsByTagType($tagType, $events, $limit)
    {

        //gets the assessment 'route' tags
        $selfAssessmentTags = app('selfAssessmentSingleton')->getAllocatedTags($tagType);

        //extracts the ids and store in array
        $selfAssessmentTagsNames = $selfAssessmentTags->pluck('name')->toArray();

        $subsetEvents = $events->map(function ($event) {
            return $event->id;
        });

        if (Auth::guard('web')->user()->type == 'user')
        {

            $query = EventLive::select('id', 'summary_heading', 'summary_text', 'slug', 'date', 'start_time_hour', 'start_time_min')
                            ->whereDate('date', '>=', Carbon::today()->toDateString())
                            ->Where(function($query) {
                                $query->where('client_id', NULL)
                                ->orWhere('client_id', Session::get('fe_client')['id']);
                            })
                            ->withAnyTags($selfAssessmentTagsNames, $tagType)
                            ->with('media')
                            ->orderBy('date', 'asc')
                            ->limit($limit);

        } else {

            $query = EventLive::select('id', 'summary_heading', 'summary_text', 'slug', 'date', 'start_time_hour', 'start_time_min')
                            ->whereDate('date', '>=', Carbon::today()->toDateString())
                            ->Where(function($query) {
                                $query->where('client_id', NULL)
                                ->orWhere('client_id', Session::get('fe_client')['id']);
                            })
                            ->with('media')
                            ->orderBy('date', 'asc')
                            ->limit($limit);


        }

        //do not select events already selected
        if (count($subsetEvents) > 0)
        {
            $query = $query->whereNotIN('id', [$subsetEvents->first()]);
        }

        //if logged in, filter by term and school year
        if (Auth::guard('web')->check())
        {
            if (Auth::guard('web')->user()->type == 'user')
            {
                $query =  $query->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                ->withAnyTags( [ app('currentTerm') ] , 'term');

            }

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
        $query = EventLive::select('id', 'summary_heading', 'summary_text', 'slug', 'date', 'start_time_hour', 'start_time_min')
                        ->whereDate('date', '>=', Carbon::today()->toDateString())
                        ->Where(function($query) {
                            $query->where('client_id', NULL)
                            ->orWhere('client_id', Session::get('fe_client')['id']);
                        })
                        ->with('media')
                        ->orderBy('date', 'asc')
                        ->limit($nb_events)
                        ->offset($offset);

        //if logged in, filter by institution
        if (Auth::guard('web')->check())
        {

            if (Auth::guard('web')->user()->type == 'user')
            {

                $query = $query->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                ->withAnyTags( [ app('currentTerm') ] , 'term')
                                ->Where(function($query) {
                                    $query->where('all_institutions', 'Y')
                                        ->orwhereHas('institutions', function ($query) {
                                                $query->where('institution_id', Auth::guard('web')->user()->institution_id);
                                            });
                                    });

            } else {

                $query = $query->Where(function($query) {
                                    $query->where('all_institutions', 'Y')
                                        ->orwhereHas('institutions', function ($query) {
                                                $query->where('institution_id', Auth::guard('web')->user()->institution_id);
                                            });
                                    });


            }

        //if not logged in, exclude internal events
        } else {

            $query =  $query->IsNotInternal();
        }

        return $query->get();

    }






    /**
     * getBestMatchFutureEvents
     *
     * @param  mixed $nb_events
     * @return void
     */
    public function getBestMatchFutureEvents($offset, $nb_events)
    {

        $selfAssessmentRouteTags = app('selfAssessmentSingleton')->getAllocatedTags('route');
        $selfAssessmentRouteTagsNames = $selfAssessmentRouteTags->pluck('name')->toArray();

        $selfAssessmentSectorTags = app('selfAssessmentSingleton')->getAllocatedTags('sector');
        $selfAssessmentSectorTagsNames = $selfAssessmentSectorTags->pluck('name')->toArray();

        $selfAssessmentSubjectTags = app('selfAssessmentSingleton')->getCompiledAllocatedSubjectTags();

        //extracts the ids and store in array


        $query = EventLive::select('id', 'summary_heading', 'summary_text', 'slug', 'date', 'start_time_hour', 'start_time_min')
                        ->whereDate('date', '>=', Carbon::today()->toDateString())
                        ->Where(function($query) {
                            $query->where('client_id', NULL)
                            ->orWhere('client_id', Session::get('fe_client')['id']);
                        })
                        ->with('media')
                        ->orderBy('date', 'asc')
                        ->limit($nb_events)
                        ->offset($offset);

        //if logged in, filter by institution
        if (Auth::guard('web')->check())
        {

            if (Auth::guard('web')->user()->type == 'user')
            {

                $query =  $query->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                ->withAnyTags( [ app('currentTerm') ] , 'term')
                                ->Where(function($query) {
                                    $query->where('all_institutions', 'Y')
                                        ->orwhereHas('institutions', function ($query) {
                                                $query->where('institution_id', Auth::guard('web')->user()->institution_id);
                                            });
                                    });

                //filters by tags
                $query = $query->Where(function($query) use ($selfAssessmentRouteTagsNames, $selfAssessmentSectorTagsNames, $selfAssessmentSubjectTags) {
                    $query->withAnyTags( $selfAssessmentRouteTagsNames , 'route');
                    $query->OrWhere(function($query) use ($selfAssessmentSectorTagsNames) {
                        $query->withAnyTags( $selfAssessmentSectorTagsNames , 'sector');
                    });
                    $query->OrWhere(function($query) use ($selfAssessmentSubjectTags) {
                        $query->withAnyTags( $selfAssessmentSubjectTags , 'subject');
                    });
                });

            } else {

                $query =  $query->Where(function($query) {
                                    $query->where('all_institutions', 'Y')
                                        ->orwhereHas('institutions', function ($query) {
                                                $query->where('institution_id', Auth::guard('web')->user()->institution_id);
                                            });
                                    });


            }

        }

        return $query->get();

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
    public function loadLiveEvent($eventId)
    {

        if (!is_null($eventId))
        {
            //checks if the article is still live
            $event = EventLive::select('id', 'summary_heading', 'summary_text', 'slug', 'date', 'start_time_hour', 'start_time_min')
                        ->where('id', $eventId)
                        ->whereDate('date', '>=', Carbon::today()->toDateString())
                        ->Where(function($query) {
                            $query->where('client_id', NULL)
                            ->orWhere('client_id', Session::get('fe_client')['id']);
                        })
                        ->with('media');



            //if the user is not logged in, only display events that are not "internal"
            if (!Auth::guard('web')->check())
            {
                $event->IsNotInternal();
                //$event = $event->where('is_internal', '=', "N");
            }

            $event = $event->orderBy('date', 'asc')->first();

            return $event;

        }

        return NULL;

    }


    /**
     * incrementViewingCounter
     * incremnets the total stats
     *
     * @param  mixed $id
     * @return void
     */
    public function incrementViewingCounter($id)
    {
        DB::beginTransaction();

        try {

            $updateData = [];
            $keys = [];

            if (Auth::guard('web')->check())
            {

                $year = Auth::guard('web')->user()->school_year;
                $updateData['year_'.$year] = DB::raw('year_'.$year.' + 1');

                $keys['institution_id'] = Auth::guard('web')->user()->institution_id;

            } else {

                $keys['institution_id'] = NULL;

            }

            EventsTotalStats::updateorCreate(
                array_merge([
                'event_id' => $id,
                'client_id' => Session::get('fe_client')['id'],
                'year_id' => app('currentYear'),
                ], $keys),
                array_merge(['total' =>  DB::raw('total + 1')], $updateData)
                );

                DB::commit();

        } catch (\Exception $e) {

            DB::rollback();

        }

    }



    /**
     * userAccessVacancies
     * When a user accesses a vacancy, the folowing actions are processed
     *
     * @param  mixed $id
     * @return void
     */
    public function userAccessEvent($id)
    {
        //if logged in
        if (Auth::guard('web')->check())
        {

            //if user type
            if (Auth::guard('web')->user()->type == 'user')
            {

                $this->incrementViewingCounter($id);

            }

        } else {

            $this->incrementViewingCounter($id);

        }

    }



}
