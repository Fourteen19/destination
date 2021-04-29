<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Frontend\PageService;
use Artesaos\SEOTools\Facades\SEOMeta;

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

        SEOMeta::setTitle($page->title);

        return view('frontend.pages.pages.show', ['page' => $page]);
    }

}
