<?php

namespace App\Services\Frontend;


use App\Services\Frontend\contentArticlesPanelService;


Class ContentService
{

    protected $articlesPanelService;


    public function __construct(contentArticlesPanelService $articlesPanelService)
    {

        $this->articlesPanelService = $articlesPanelService;

    }


    public function getArticlesPanel()
    {

        return $this->getAllSlots();

    }


    public function getAllSlots()
    {

        $slot1 =  $this->articlesPanelService->getSlot1();
        $slot2 =  $this->articlesPanelService->getSlot2();

        return collect([$slot1, $slot2]);
    }



}
