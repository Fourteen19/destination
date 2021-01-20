<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\AdvisorService;

class AdvisorDetailsComposer
{

    protected $advisorService;

    public function __construct(AdvisorService $advisorService)
    {
        $this->advisorService = $advisorService;
    }


    public function compose(View $view)
    {

        if (Auth::guard('web')->check())
        {

            $institutionAdvisor = $this->advisorService->getAdvisorDetailsForCurrentUser();

            $view->with('institutionAdvisor', $institutionAdvisor);

        }

    }


}
