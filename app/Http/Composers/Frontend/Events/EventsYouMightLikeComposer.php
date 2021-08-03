<?php

namespace App\Http\Composers\Frontend\Events;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\EventsService;
use App\Services\Frontend\HomepageService;

class EventsYouMightLikeComposer
{

    protected $eventsService;
    protected $homepageService;

    public function __construct(EventsService $eventsService, HomepageService $homepageService)
    {
        $this->eventsService = $eventsService;
        $this->homepageService = $homepageService;

    }


    public function compose(View $view)
    {

        $staticClientData = "";

        //if not logged in
        if (!Auth::guard('web')->check())
        {

            $events = $this->homepageService->getFeaturedEvents();

            //filter the events array to remove all empty values
            $events = array_filter($events);

        //if logged in
        } else {

            $events = $this->eventsService->getUpcomingEvents(2, [], 'asc');

        }



        //if less than 2 events, display a message
        if (count($events) < 2)
        {
            $staticClientData = app('clientContentSettigsSingleton')->getNoEventsDetails();
        }


        $view->with('latestEvents', $events);
        $view->with('staticClientData', $staticClientData);

    }


}
