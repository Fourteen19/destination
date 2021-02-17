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
            'title' => '',
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
            'free_articles_slot3_page_id' => $data->freeArticlesSlot3Page,
        ]);

        //fetch the template
        $template = PageTemplate::where('Name', 'Homepage')->first();

        $nbPages = 1;

        //creates the model record
        $newPage = $page->page()->create([
                        'template_id' => $template->id,
                        'title' => $data->title,
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

        $page = Page::where('uuid', $data->pageRef)->get()->first();

        //updates the resource
        $page->update([
            'title' => '',
            'slug' => 'home',
            'updated_at' => now(),
            'display_in_header' => 'N',
        ]);

       //updates the resource
        $page->pageable->update([
            'title' => '',
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
        ]);

        return $page;

    }


}
