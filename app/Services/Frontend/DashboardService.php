<?php

namespace App\Services\Frontend;


use Illuminate\Support\Facades\Auth;
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
/*
        $dashboardData =$this->getUserDashboardDetails();

        $slot1 =  $this->articlesPanelService->getSlot1Article($dashboardData->slot_1);
        $slot2 =  $this->articlesPanelService->getSlot2Article($dashboardData->slot_2);
        $slot3 =  $this->articlesPanelService->getSlot3Article($dashboardData->slot_3);
        $slot4 =  $this->articlesPanelService->getSlot4Article($dashboardData->slot_4);
        $slot5 =  $this->articlesPanelService->getSlot5Article($dashboardData->slot_5);
        $slot6 =  $this->articlesPanelService->getSlot6Article($dashboardData->slot_6);
*/
$slot1 = NULL;
$slot2 = NULL;
$slot3 = NULL;
$slot4 = NULL;
$slot5 = NULL;
$slot6 = NULL;

        return collect([$slot1, $slot2, $slot3, $slot4, $slot5, $slot6]);

    }



    /**
     * getUserDashboardDetails
     * loads the articles ID for each dashborad
     * If the user has no dahboard, we create it
     *
     * @return void
     */
    public function getUserDashboardDetails()
    {
/*
        if (is_null(Auth::guard('web')->user()->dashboard))
        {
            $this->createDashboardForUser();
        }

        return Auth::guard('web')->user()->getDashboardSlots;
*/
    }



    /**
     * clearDashborad
     * Resets all articles from the dashboard
     *
     * @return void
     */
    public function clearDashborad()
    {
/*
        Auth::guard('web')->user()->dashboard()->update([
            'slot_1'=> NULL,
            'slot_2'=> NULL,
            'slot_3'=> NULL,
            'slot_4'=> NULL,
            'slot_5'=> NULL,
            'slot_6'=> NULL,
        ]);
*/
    }

    /**
     * createDashboardForUser
     * creates a dashboard for the current user
     *
     * @return void
     */
    public function createDashboardForUser()
    {
  //      Auth::guard('web')->user()->dashboard()->create();
    }




    /**
     * clearDashboardSlot
     * reset a dashboard slot
     *
     * @return void
     */
    public function clearDashboardSlot($slotId)
    {
  /*      Auth::guard('web')->user()->dashboard()->update([
            'slot_'.$slotId => NULL
        ]);
        */
    }




    /**
     * clearArticleFromDashboard
     * looks in the dashboard and clears the slot where the article is located
     *
     * @param  mixed $articleId
     * @return void
     */
    public function clearArticleFromDashboard($articleId)
    {
/*
        $dashboard = $this->getUserDashboardDetails();

        if ($dashboard->slot_1 == $articleId)
        {
            $this->clearDashboardSlot(1);
        } elseif ($dashboard->slot_2 == $articleId)
        {
            $this->clearDashboardSlot(2);
        } elseif ($dashboard->slot_3 == $articleId)
        {
            $this->clearDashboardSlot(3);
        } elseif ($dashboard->slot_4 == $articleId)
        {
            $this->clearDashboardSlot(4);
        } elseif ($dashboard->slot_5 == $articleId)
        {
            $this->clearDashboardSlot(5);
        } elseif ($dashboard->slot_6 == $articleId)
        {
            $this->clearDashboardSlot(6);
        }
*/

    }


}
