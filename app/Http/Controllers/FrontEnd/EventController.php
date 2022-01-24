<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\EventLive;
use Illuminate\Http\Request;
use App\Events\ClientEventHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\PageService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Session;
use App\Services\Frontend\EventsService;
use App\Services\Frontend\ArticlesService;
use App\Services\Frontend\HomepageService;
use App\Services\Frontend\ClientContentSettingsService;

class EventController extends Controller
{

    protected $clientContentSettingsService;
    protected $pageService;
    protected $articlesService;
    protected $eventsService;

    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct(ClientContentSettingsService $clientContentSettingsService,
                                PageService $pageService,
                                ArticlesService $articlesService,
                                EventsService $eventsService) {

        $this->clientContentSettingsService = $clientContentSettingsService;
        $this->pageService = $pageService;
        $this->articlesService = $articlesService;
        $this->eventsService = $eventsService;
    }



    /**
     * Show the application events.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $upcominEvents = $this->eventsService->getUpcomingEvents(4, [], 'asc');

        //get events after the first 4 loaded in the upcoming section
        $futureEvents = $this->eventsService->getFutureEvents(4, config('global.events.future_events.load_more_number') );

        return view('frontend.pages.events.index', ['type' => 'all_events',
                                                    'upcominEvents' => (empty($upcominEvents)) ? [] : $upcominEvents,
                                                    'futureEvents' => (empty($futureEvents)) ? [] : $futureEvents
                                                    ]);

    }



     /**
     * Show the application events.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexBestMatch()
    {

        $upcominEvents = $this->eventsService->getBestMatchUpcomingEvents(4);

        //get events from 0
        //$futureEvents = $this->eventsService->getFutureEvents(0, config('global.events.future_events.load_more_number') );
        $futureEvents = $this->eventsService->getBestMatchFutureEvents(4, config('global.events.future_events.load_more_number') );

        return view('frontend.pages.events.index', ['type' => 'best_match',
                                                    'upcominEvents' => (empty($upcominEvents)) ? [] : $upcominEvents,
                                                    'futureEvents' => (empty($futureEvents)) ? [] : $futureEvents
                                                    ]);

    }




    /**
     * Show the event.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($clientSubdomain, EventLive $event)
    {

        SEOMeta::setTitle($event->title);

        $homepageService = new HomepageService($this->clientContentSettingsService, $this->pageService, $this->articlesService, $this->eventsService);

        $logAccess = False;

        //if not logged in
        if (!Auth::guard('web')->check())
        {
            $freeArticles = $homepageService->loadFreeArticles()['free_articles_slots'];

            $clientId = Session::get('fe_client')['id'];
            $logAccess = True;

        } else {
            $freeArticles = $this->eventsService->loadRelatedArticlesToEvent($event->id);

            if (Auth::guard('web')->user()->type == 'user')
            {
                $clientId = Auth::guard('web')->user()->client_id;
                $logAccess = True;

            }
        }


        if ($logAccess)
        {
            //fires an event to log the access
            event(new ClientEventHistory( $event, $clientId ));
        }

        $this->eventsService->userAccessEvent($event->id);

        return view('frontend.pages.events.show', ['event' => $event,
                                                   'other_events' => $this->eventsService->getUpcomingEvents(2, [$event->id], 'asc'),
                                                   'relatedArticlesBlockType' => 'Related',
                                                   'relatedArticles' => collect($freeArticles),
                                                    ]);

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
