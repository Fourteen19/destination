<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Services\Frontend\FrontContentService;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{


    protected $frontContentService;

    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct(FrontContentService $frontContentService) {

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

        return view('frontend.pages.dashboard', ['slot1' => $slot1, 'slot2' => $slot2]);

    }
}
