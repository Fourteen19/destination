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
