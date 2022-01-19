<?php

namespace App\Services\Admin;

use App\Models\Page;
use App\Models\PageHomepage;
use App\Models\PageTemplate;
use App\Services\Admin\PageService;

Class PageHomepageService extends PageService
{

    public function addNewClient($clientId)
    {

        //create the model record
        $page = PageHomepage::create([
            'title' => 'Homepage',
            'banner_title' => 'Welcome to MyDirections',
            'banner_text' =>  'Paragraph introducing the concept and talking to teachers and parents about how to get it for your school or child...',
            'banner_link1_text' => 'FIND OUT MORE',
            'banner_link1_page_id' => NULL,
            'banner_link2_text' => 'CONTACT US TO GET MYDIRECTIONS FOR YOUR SCHOOL',
            'banner_link2_page_id' => NULL,
            'free_articles_block_heading' => 'Free sample articles',
            'free_articles_block_text' => 'Here are some examples of the great articles and advice that are available when you are logged in to MyDirections',
            'free_articles_slot1_page_id' => NULL,
            'free_articles_slot2_page_id' => NULL,
            'featured_event_slot1_id' => NULL,
            'featured_event_slot2_id' => NULL,
        ]);

        //fetch the template
        $template = PageTemplate::where('Name', 'Homepage')->first();

        //creates the model record
        $newPage = $page->page()->create([
                        'template_id' => $template->id,
                        'title' => 'Homepage',
                        'slug' => 'home',
                        'client_id' => $clientId,
                        'display_in_header' => 'N',
                        'order_id' => 1,
                    ]);

        //return the new content
        return $newPage;

    }





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
