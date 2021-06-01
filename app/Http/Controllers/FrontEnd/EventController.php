<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\EventLive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\EventsService;

class EventController extends Controller
{


    protected $EventsService;

    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct(EventsService $EventsService) {

        $this->eventsService = $EventsService;

    }



    /**
     * Show the application events.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $upcominEvents = $this->eventsService->getUpcomingEvents(4);

        $futureEvents = $this->eventsService->getFutureEvents(4, config('global.events.future_events.load_more_number') );

        return view('frontend.pages.events.index', ['upcominEvents' => $upcominEvents,
                                                    'futureEvents' => $futureEvents
                                                    ]);

    }

    /**
     * Show the event.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($clientSubdomain, EventLive $event)
    {

        return view('frontend.pages.events.show', ['event' => $event, ]);

    }


    /**
     * search
     *
     * @param  mixed $clientSubdomain
     * @param  mixed $event
     * @return void
     */
    public function search($clientSubdomain, EventLive $event)
    {

        SEOMeta::setTitle("Search Events");

        return view('frontend.pages.events.search.index');

    }



    /**
     * loadMoreFutureEvents
     * call from JS ajax script to load more events
     *
     * @param  mixed $request
     * @return void
     */
    public function loadMoreFutureEvents(Request $request)
    {

        if ($request->ajax())
        {

            $data = $this->eventsService->getFutureEvents($request->offset, config('global.events.future_events.load_more_number') );

            if(!$data->isEmpty())
            {
                $html = view('frontend.pages.includes.events.future-events', ['futureEvents' => $data  ])->render();

                return response()->json(['view'=>$html, 'nb_events' => count($data)]);

            } else {

                return ['nb_events' => 0];

            }

        } else {
            abort(404);
        }

    }

}
