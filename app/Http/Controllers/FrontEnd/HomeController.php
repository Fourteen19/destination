<?php

namespace App\Http\Controllers\FrontEnd;


use App\Http\Controllers\Controller;
use App\Services\Frontend\PageService;
use Illuminate\Support\Facades\Session;
use App\Services\Frontend\EventsService;
use App\Services\Frontend\ArticlesService;
use App\Services\Frontend\HomepageService;
use App\Services\Frontend\ClientContentSettingsService;

class HomeController extends Controller
{

    protected $clientContentSettingsService;
    protected $pageService;
    protected $articlesService;
    protected $eventsService;

    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct(ClientContentSettingsService $clientContentSettingsService,
                                PageService $pageService,
                                ArticlesService $articlesService,
                                EventsService $eventsService) {

        $this->clientContentSettingsService = $clientContentSettingsService;
        $this->pageService = $pageService;
        $this->articlesService = $articlesService;
        $this->eventsService = $eventsService;
    }

    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $homepageService = new HomepageService($this->clientContentSettingsService, $this->pageService, $this->articlesService, $this->eventsService);

        $loginBlock = $homepageService->loadLoginBoxdata();
        $homepageBannerData = $homepageService->loadBannerData();
        $freeArticles = $homepageService->loadFreeArticles();

        return view('frontend.pages.home', ['loginBlock' => $loginBlock,
                                            'homepageBannerData' => $homepageBannerData,
                                            'freeArticles' => $freeArticles,
                                            ] );

    }
}
