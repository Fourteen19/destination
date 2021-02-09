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

        $dashboardData = $this->getUserDashboardDetails();

        $slot1 =  $this->articlesPanelService->getSlot1Article($dashboardData->slot_1);
        $slot2 =  $this->articlesPanelService->getSlot2Article($dashboardData->slot_2);
        $slot3 =  $this->articlesPanelService->getSlot3Article($dashboardData->slot_3);
        $slot4 =  $this->articlesPanelService->getSlot4Article($dashboardData->slot_4);
        $slot5 =  $this->articlesPanelService->getSlot5Article($dashboardData->slot_5);
        $slot6 =  $this->articlesPanelService->getSlot6Article($dashboardData->slot_6);

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
dd(789);/*
        if (is_null(Auth::guard('web')->user()->dashboard))
        {
            $this->createDashboardForUser();
        }

        return Auth::guard('web')->user()->getDashboardSlots;
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

        dd(888);
/*
        $dashboard = Auth::guard('web')->user()->getUserDashboardDetails();

        if ($dashboard->slot_1 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(1);
        } elseif ($dashboard->slot_2 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(2);
        } elseif ($dashboard->slot_3 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(3);
        } elseif ($dashboard->slot_4 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(4);
        } elseif ($dashboard->slot_5 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(5);
        } elseif ($dashboard->slot_6 == $articleId)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot(6);
        }
*/

    }


}
