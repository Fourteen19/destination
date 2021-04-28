<?php

namespace App\Http\Composers\Frontend\Employers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\EmployersService;

class FeaturedEmployersComposer
{

    protected $employersService;

    public function __construct(EmployersService $employersService)
    {
        $this->employersService = $employersService;
    }


    public function compose(View $view)
    {

        //if the user is logged in
        if (Auth::guard('web')->check())
        {

            $view->with('employers', $this->employersService->getFeaturedEmployers() );

        }

    }


}
