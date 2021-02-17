<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\PageService;

class FixedLinksComposer
{

    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }


    public function compose(View $view)
    {

        $fixedLinks = collect();

        if (!Auth::guard('web')->check())
        {

            $fixedLinks = $this->pageService->getFixedLinks();

        }

        $view->with('fixedLinks', $fixedLinks);

    }


}
