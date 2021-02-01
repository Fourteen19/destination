<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
//use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\FooterService;

class FooterDetailsComposer
{

    protected $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }


    public function compose(View $view)
    {
/*
        if (Auth::guard('web')->check())
        {
*/
            $footerDetails = $this->footerService->getFooterDetailsForCurrentClient();

            $view->with('footerDetailsForCurrentClient', $footerDetails);

//        }

    }


}
