<?php

namespace App\Http\Controllers\FrontEnd;


use App\Http\Controllers\Controller;
use App\Services\Frontend\PageService;
use App\Services\Frontend\ArticlesService;
use App\Services\Frontend\HomepageService;
use App\Services\Frontend\ClientContentSettigsService;

class HomeController extends Controller
{

    protected $clientContentSettigsService;
    protected $pageService;
    protected $articlesService;
    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct(ClientContentSettigsService $clientContentSettigsService, PageService $pageService, ArticlesService $articlesService) {

        $this->clientContentSettigsService = $clientContentSettigsService;
        $this->pageService = $pageService;
        $this->articlesService = $articlesService;

    }

    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $homepageService = new HomepageService($this->clientContentSettigsService, $this->pageService, $this->articlesService);

        $loginBlock = $homepageService->loadLoginBoxdata();
        $homepageBannerData = $homepageService->loadBannerData();
        $freeArticles = $homepageService->loadFreeArticles();

        return view('frontend.pages.home', ['loginBlock' => $loginBlock, 'homepageBannerData' => $homepageBannerData, 'freeArticles' => $freeArticles] );

    }
}
