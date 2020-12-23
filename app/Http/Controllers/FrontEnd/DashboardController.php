<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Services\Frontend\frontContentService;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{


    protected $frontContentService;

    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct(frontContentService $frontContentService) {

        $this->frontContentService = $frontContentService;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $articles = $this->frontContentService->getArticlesPanel();

        $slot1 = $articles->shift();
        $slot2 = $articles->shift();
        $slot3 = $articles->shift();
        $slot4 = $articles->shift();
        $slot5 = $articles->shift();
        $slot6 = $articles->shift();

        return view('frontend.pages.dashboard', ['slot1' => $slot1, 'slot2' => $slot2, 'slot3' => $slot3, 'slot4' => $slot4, 'slot5' => $slot5, 'slot6' => $slot6]);

    }
}
