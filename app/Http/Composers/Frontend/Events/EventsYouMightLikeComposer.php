<?php

namespace App\Http\Composers\Frontend\Events;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\EventsService;

class EventsYouMightLikeComposer
{

    protected $eventsService;

    public function __construct(EventsService $eventsService)
    {
        $this->eventsService = $eventsService;
    }


    public function compose(View $view)
    {

        $staticClientData = "";

        $latestEvents = $this->eventsService->getUpcomingEvents(2, [], 'desc');

        //if less than 2 events, display a message
        if (count($latestEvents) < 2)
        {
            $staticClientData = app('clientContentSettigsSingleton')->getNoEventsDetails();
        }


        $view->with('latestEvents', $latestEvents);
        $view->with('staticClientData', $staticClientData);

    }


}
