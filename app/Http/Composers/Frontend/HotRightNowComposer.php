<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\HotRightNowService;

class HotRightNowComposer
{

    protected $hotRightNowService;

    public function __construct(HotRightNowService $hotRightNowService)
    {
        $this->hotRightNowService = $hotRightNowService;
    }


    public function compose(View $view)
    {

        $hotRightNowArticles = $this->hotRightNowService->getHotRightNowArticles();

        $displayHotRightNowArticles = (count($hotRightNowArticles) == 4) ? 'Y' : 'N';

        $view->with('displayHotRightNowArticles', $displayHotRightNowArticles);

        if ($displayHotRightNowArticles == 'Y')
        {
            $view->with('hotRightNowArticles', $hotRightNowArticles);
        }

    }


}
