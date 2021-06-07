<?php

namespace App\Services\Frontend;

use App\Models\EventLive;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Class EventsService
{

    public function __construct()
    {
        //
    }




    /**
     * getUpcomingEvents
     *
     * @param  mixed $nb_events
     * @return void
     */
    public function getUpcomingEvents($nb_events)
    {
        return EventLive::select('id', 'summary_heading', 'summary_text', 'slug', 'date', 'start_time_hour', 'start_time_min')
                            ->where('client_id', NULL)
                            ->orWhere('client_id', Session::get('fe_client')->id)
                            ->with('media')
                            ->orderBy('date', 'desc')
                            ->limit($nb_events)
                            ->get();

    }




    /**
     * getUpcomingEvents
     *
     * @param  mixed $nb_events
     * @return void
     */
    public function getBestMatchUpcomingEvents($nb_events)
    {

        //gets the user's institution
        $userInstitution = Auth::guard('web')->user()->institution()->first();

        //gets events allocated specifically to the user's institution
        $institutionEvents = $userInstitution->eventsLiveSummary($nb_events)->get();

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

        return EventLive::select('id', 'summary_heading', 'summary_text', 'slug', 'date', 'start_time_hour', 'start_time_min')
                        ->where('client_id', NULL)
                        ->orWhere('client_id', Session::get('fe_client')->id)
                        ->withAnyTags($selfAssessmentTagsNames, $tagsType)
                        ->whereNotIN('id', [$subsetEvents])
                        ->with('media')
                        ->orderBy('date', 'desc')
                        ->limit($limit)
                        ->get();

    }





    /**
     * getFutureEvents
     *
     * @param  mixed $nb_events
     * @return void
     */
    public function getFutureEvents($offset=0, $nb_events)
    {
        return EventLive::select('id', 'summary_heading', 'slug', 'date', 'start_time_hour', 'start_time_min')
                        ->where('client_id', NULL)
                        ->orWhere('client_id', Session::get('fe_client')->id)
                        ->with('media')
                        ->orderBy('date', 'desc')
                        ->limit($nb_events)
                        ->offset($offset)
                        ->get();

    }

}
