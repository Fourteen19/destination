<?php

namespace App\Services\Frontend;


use App\Models\HomepageSettings;
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

        //selects all the client dashboard settings based on client and year
        $hompageSettings = HomepageSettings::where('client_id', '=', Auth::guard('web')->user()->client_id)
                                            ->where('school_year', '=', Auth::guard('web')->user()->school_year)
                                            ->first();

        //gets the user dashboard details
        $dashboardData = Auth::guard('web')->user()->getUserDashboardDetails();

        //loops through the slots
        for($i=1;$i<7;$i++)
        {
            //check if the slot is set to `managed`
            if ($hompageSettings->{'dashboard_slot_'.$i.'_type'} == "managed")
            {

                ${'slot'.$i.'Id'} = $hompageSettings->{'dashboard_slot_'.$i.'_id'};  // $hompageSettings->dashboard_slot_1_id
                if (!${'slot'.$i.'Id'})
                {
                    ${'slot'.$i.'Id'} = $dashboardData->{'slot_'.$i};  // $dashboardData->slot_1
                }

            //else
            } else {
                ${'slot'.$i.'Id'} = $dashboardData->{'slot_'.$i};
            }

        }

        $this->articlesPanelService->articlePanelSlots = [NULL, $slot1Id, $slot2Id, $slot3Id, $slot4Id, $slot5Id, $slot6Id ];

        //Slots 4, 5, 6 have the highest priority in terms of articles selection as they are restricted as to what they can show (1 type - route, sector or subject)
        $slot4 = $this->articlesPanelService->getSlot4Article($slot4Id);
        $slot5 = $this->articlesPanelService->getSlot5Article($slot5Id);
        $slot6 = $this->articlesPanelService->getSlot6Article($slot6Id);

        //slots 1, 2, 3 have more fallbacks articles and can be done after 4, 5, 6
        $slot1 = $this->articlesPanelService->getSlot1Article($slot1Id);
        $slot2 = $this->articlesPanelService->getSlot2Article($slot2Id);
        $slot3 = $this->articlesPanelService->getSlot3Article($slot3Id);


        return collect([$slot1, $slot2, $slot3, $slot4, $slot5, $slot6]);

    }



   /**
     * assignArticleToDashboardSlot
     * Assigns an article to a dasboard slot
     *
     * @param  mixed $slotId
     * @param  mixed $articleId
     * @return void
     */
    public function assignArticleToDashboardSlot(String $slotPrefix = "", Int $slotId, Int $articleId)
    {
        $this->articlesPanelService->assignArticleToDashboardSlot($slotPrefix, $slotId, $articleId);
    }


    /**
     * clearArticleFromDashboard
     * looks in the dashboard and clears the slot where the article is located
     *
     * @param  mixed $articleId
     * @return void
     */
/*    public function clearArticleFromDashboard($articleId)
    {

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


    }
*/

}
