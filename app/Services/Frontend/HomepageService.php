<?php

namespace App\Services\Frontend;

use App\Models\StaticClientContent;
use App\Services\Frontend\PageService;
use App\Services\Frontend\ClientContentSettigsService;
use Illuminate\Support\Facades\Session;
use App\Services\Frontend\ArticlesService;

Class HomepageService
{

    protected $clientContentSettigsService;
    protected $pageService;
    protected $articlesService;

    protected $page;

    public function __construct(ClientContentSettigsService $clientContentSettigsService, PageService $pageService, ArticlesService $articlesService) {

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

        $bannerImage = $this->page->getFirstMediaUrl('banner', 'banner');
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

        return [
            'free_articles_block_heading' => $freeArticlesBlockHeading,
            'free_articles_block_text' => $freeArticlesBlockText,
            'free_articles_slots' => [$freeArticlesSlot1Page, $freeArticlesSlot2Page, $freeArticlesSlot3Page],
        ];
    }



}
