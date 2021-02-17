<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Services\Frontend\PageService;
use App\Http\Controllers\Controller;

class PageController extends Controller
{

    protected $pageService;

    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct(PageService $pageService)
    {

        $this->pageService = $pageService;

    }


    /**
     * Show pages.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request)
    {

        $page = $this->pageService->getLivePageBySlug($request->page);

        return view('frontend.pages.pages.show', ['page' => $page]);
    }

}
