<?php

namespace App\Services\Frontend;


use App\Services\Frontend\ArticlesPanelService;


Class DashboardService
{

    protected $articlesPanelService;


    public function __construct(ArticlesPanelService $articlesPanelService)
    {

        $this->articlesPanelService = $articlesPanelService;

    }


    public function getArticlesPanel()
    {

        return $this->getAllSlots();

    }


    public function getAllSlots()
    {

        $slot1 =  $this->articlesPanelService->getSlot1Article();
        $slot2 =  $this->articlesPanelService->getSlot2Article();
        $slot3 =  $this->articlesPanelService->getSlot3Article();
        $slot4 =  $this->articlesPanelService->getSlot4Article();
        $slot5 =  $this->articlesPanelService->getSlot5Article();
        $slot6 =  $this->articlesPanelService->getSlot6Article();

        return collect([$slot1, $slot2, $slot3, $slot4, $slot5, $slot6]);

    }



}
