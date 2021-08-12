<?php

namespace App\Services\Admin;

use App\Models\Page;
use App\Models\PageHomepage;
use App\Models\PageTemplate;
use App\Services\Admin\PageService;

Class PageHomepageService extends PageService
{

    public function storeLivewire($data)
    {

        //create the model record
        $page = PageHomepage::create([
            'title' => 'Homepage',
            'banner_title' => $data->bannerTitle,
            'banner_text' =>  $data->bannerText,
            'banner_link1_text' => $data->bannerLink1Text,
            'banner_link1_page_id' => $data->bannerLink1Page,
            'banner_link2_text' => $data->bannerLink2Text,
            'banner_link2_page_id' => $data->bannerLink2Page,
            'free_articles_block_heading' => $data->freeArticlesBlockHeading,
            'free_articles_block_text' => $data->freeArticlesBlockText,
            'free_articles_slot1_page_id' => $data->freeArticlesSlot1Page,
            'free_articles_slot2_page_id' => $data->freeArticlesSlot2Page,
            'featured_event_slot1_id' => $data->eventSlot1Page,
            'featured_event_slot2_id' => $data->eventSlot2Page,
        ]);

        //fetch the template
        $template = PageTemplate::where('Name', 'Homepage')->first();

        $nbPages = 1;

        //creates the model record
        $newPage = $page->page()->create([
                        'template_id' => $template->id,
                        'title' => 'Homepage',
                        'slug' => $data->slug,
                        'client_id' => getClientId(),
                        'display_in_header' => 'N',
                        'order_id' => $nbPages,
                    ]);

         //return the new content
        return $newPage;

    }



    public function editLivewire($data)
    {

        $contentService = new ContentService();
        $eventService = new EventService();

        $page = Page::where('uuid', $data->pageRef)->get()->first();

        //updates the resource
        $page->update([
            'title' => 'Homepage',
            'slug' => 'home',
            'updated_at' => now(),
            'display_in_header' => 'N',
        ]);

       //updates the resource
        $page->pageable->update([
            'title' => 'Homepage',
            'banner_title' => $data->bannerTitle,
            'banner_text' =>  $data->bannerText,
            'banner_link1_text' => $data->bannerLink1Text,
            'banner_link1_page_id' => $this->getLivePageIdByUuid($data->bannerLink1Page),
            'banner_link2_text' => $data->bannerLink2Text,
            'banner_link2_page_id' => $this->getLivePageIdByUuid($data->bannerLink2Page),
            'free_articles_block_heading' => $data->freeArticlesBlockHeading,
            'free_articles_block_text' => $data->freeArticlesBlockText,
            'free_articles_slot1_page_id' => (!empty($data->freeArticlesSlot1Page)) ? $contentService->getLiveContentIdByUuid($data->freeArticlesSlot1Page) : NULL,
            'free_articles_slot2_page_id' => (!empty($data->freeArticlesSlot2Page)) ? $contentService->getLiveContentIdByUuid($data->freeArticlesSlot2Page) : NULL,
            'free_articles_slot3_page_id' => (!empty($data->freeArticlesSlot3Page)) ? $contentService->getLiveContentIdByUuid($data->freeArticlesSlot3Page) : NULL,
            'featured_event_slot1_id' => (!empty($data->eventSlot1Page)) ? $eventService->getLiveContentIdByUuid($data->eventSlot1Page) : NULL,
            'featured_event_slot2_id' => (!empty($data->eventSlot2Page)) ? $eventService->getLiveContentIdByUuid($data->eventSlot2Page) : NULL,
        ]);

        return $page;

    }


}
