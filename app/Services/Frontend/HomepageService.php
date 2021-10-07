<?php

namespace App\Services\Frontend;

use App\Services\Frontend\EventsService;
use App\Services\Frontend\PageService;
use App\Services\Frontend\ArticlesService;
use App\Services\Frontend\ClientContentSettigsService;

Class HomepageService
{

    protected $clientContentSettigsService;
    protected $pageService;
    protected $articlesService;


    protected $page;

    public function __construct(ClientContentSettigsService $clientContentSettigsService,
                                PageService $pageService,
                                ArticlesService $articlesService) {

        $this->clientContentSettigsService = $clientContentSettigsService;
        $this->pageService = $pageService;
        $this->articlesService = $articlesService;

        $this->page = $this->pageService->getHomepageDetails();

    }



    public function loadLoginBoxdata()
    {
        return $this->clientContentSettigsService->getLoginBoxDetails();
    }




    public function loadBannerData()
    {

        $bannerImage = $this->page->getFirstMediaUrl('banner');
        $bannerTitle = $this->page->pageable->banner_title;
        $bannerText = $this->page->pageable->banner_text;
        $bannerLink1Text = $this->page->pageable->banner_link1_text;
        $bannerLink1Page = $this->pageService->getLiveSummaryPageById($this->page->pageable->banner_link1_page_id);
        $bannerLink2Text = $this->page->pageable->banner_link2_text;
        $bannerLink2Page = $this->pageService->getLiveSummaryPageById($this->page->pageable->banner_link2_page_id);

        return [
            'banner_image' => $bannerImage,
            'banner_title' => $bannerTitle,
            'banner_text' => $bannerText,
            'banner_link1_text' => $bannerLink1Text,
            'banner_link1_page' => $bannerLink1Page,
            'banner_link2_text' => $bannerLink2Text,
            'banner_link2_page' => $bannerLink2Page,

        ];

    }




    public function loadFreeArticles()
    {

        $freeArticlesBlockHeading = $this->page->pageable->free_articles_block_heading;
        $freeArticlesBlockText = $this->page->pageable->free_articles_block_text;
        $freeArticlesSlot1Page = $this->articlesService->loadLiveArticle($this->page->pageable->free_articles_slot1_page_id);
        $freeArticlesSlot2Page = $this->articlesService->loadLiveArticle($this->page->pageable->free_articles_slot2_page_id);
        $freeArticlesSlot3Page = $this->articlesService->loadLiveArticle($this->page->pageable->free_articles_slot3_page_id);

        $freeArticles = [];
        if (!empty($freeArticlesSlot1Page)){$freeArticles[] = $freeArticlesSlot1Page;}
        if (!empty($freeArticlesSlot2Page)){$freeArticles[] = $freeArticlesSlot2Page;}
        if (!empty($freeArticlesSlot3Page)){$freeArticles[] = $freeArticlesSlot3Page;}

        return [
            'free_articles_block_heading' => $freeArticlesBlockHeading,
            'free_articles_block_text' => $freeArticlesBlockText,
            'free_articles_slots' => $freeArticles,
        ];
    }







    /**
     * getFeaturedEvents
     * get the events set in public homepage
     *
     * @return void
     */
    public function getFeaturedEvents()
    {

        $eventService = new EventsService($this->articlesService);


        $eventSlot1 = $eventSlot2 = NULL;
        $eventsSlots = [];

        if ($this->page->pageable->featured_event_slot1_id)
        {
            $event1 = $this->page->pageable->featured_event_slot1_id;

            if (!empty($event1))
            {

                //the events will only be returned if their dates have not passed
                $eventSlot1 = $eventService->loadLiveEvent($event1);

                if ($eventSlot1)
                {
                    $eventsSlots[] = $eventSlot1;
                }

            }

        }


        if ($this->page->pageable->featured_event_slot2_id)
        {
            $event2 = $this->page->pageable->featured_event_slot2_id;

            if (!empty($event2))
            {

                //the events will only be returned if their dates have not passed
                $eventSlot2 = $eventService->loadLiveEvent($event2);

                if ($eventSlot2)
                {
                    $eventsSlots[] = $eventSlot2;
                }

            }

        }

        //dd($eventsSlots);

        //if we need to get any upcoming event to complete the events block
        $nbFeaturedEventsFound = count($eventsSlots);
        if ($nbFeaturedEventsFound < 2)
        {

            $nbUpcomingEventToGet = 2 - $nbFeaturedEventsFound;

            $events = $eventService->getUpcomingEvents($nbUpcomingEventToGet, [], 'asc');

            if (!empty($events))
            {

                if ($nbUpcomingEventToGet > 0)
                {
                    $eventsSlots[] = $events->get(0, null);
                }

                if ($nbUpcomingEventToGet > 1)
                {
                    $eventsSlots[] = $events->get(1, null);
                }

            }

        }

        //sorts events by date
        $sortedEventsSlots = collect($eventsSlots)->sortBy('date');

        return [
                'eventSlot1' => $sortedEventsSlots->shift(),
                'eventSlot2' => $sortedEventsSlots->shift(),
            ];



    }



}
