<?php

namespace App\Http\Controllers\FrontEnd;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\Frontend\PageService;
use Illuminate\Support\Facades\Session;
use App\Services\Frontend\EventsService;
use App\Services\Frontend\ArticlesService;
use App\Services\Frontend\HomepageService;
use App\Services\Frontend\ClientContentSettigsService;

class HomeController extends Controller
{

    protected $clientContentSettigsService;
    protected $pageService;
    protected $articlesService;
    protected $eventsService;

    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct(ClientContentSettigsService $clientContentSettigsService,
                                PageService $pageService,
                                ArticlesService $articlesService,
                                EventsService $eventsService) {

        $this->clientContentSettigsService = $clientContentSettigsService;
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

        $homepageService = new HomepageService($this->clientContentSettigsService, $this->pageService, $this->articlesService, $this->eventsService);

        $loginBlock = $homepageService->loadLoginBoxdata();
        $homepageBannerData = $homepageService->loadBannerData();
        $freeArticles = $homepageService->loadFreeArticles();

        //$latestVacancies = $homepageService->loadLatestVacancies();

        return view('frontend.pages.home', ['loginBlock' => $loginBlock,
                                            'homepageBannerData' => $homepageBannerData,
                                            'freeArticles' => $freeArticles,

                                            //'latestVacancies' => $latestVacancies,
                                            ] );

/*         $staticClientContent = json_decode(Cache::get('client:'.Session::get('fe_client')['id'].':static-content'));

        return view('frontend.pages.home', ['staticClientContent' => $staticClientContent,] ); */

    }
}
