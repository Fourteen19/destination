<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth;
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

        if (Auth::guard('web')->check())
        {

            $view->with('preFooterDetailsLoggedIn', $this->footerService->getLoggedInPreFooter() )
                 ->with('preFooterSupportBlock', $this->footerService->getPreFooterSupportBlock() )
                 ->with('footerDetails', $this->footerService->getFooterDetails() )
                 ->with('preFooterDetails', $this->footerService->getPreFooterBlock() );

        } else {

            $view->with('footerDetails', $this->footerService->getFooterDetails() )
                ->with('preFooterDetails', $this->footerService->getPreFooterBlock() );

        }


    }


}
