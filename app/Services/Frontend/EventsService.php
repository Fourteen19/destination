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

        return EventLive::select('id', 'summary_heading', 'summary_text', 'date', 'start_time_hour', 'start_time_min')
                            ->with('media')
                            ->orderBy('date', 'desc')
                            ->limit($nb_events)
                            ->get();
//dd($events->first());

/* $e = $events->first();
dd($e); */

                            //return


    }


    /**
     * getFutureEvents
     *
     * @param  mixed $nb_events
     * @return void
     */
    public function getFutureEvents($offset=0, $nb_events)
    {

        return EventLive::select('id', 'summary_heading', 'date', 'start_time_hour', 'start_time_min')
                            ->with('media')
                            ->orderBy('date', 'desc')
                            ->limit($nb_events)
                            ->offset($offset)
                            ->get();



    }

}
