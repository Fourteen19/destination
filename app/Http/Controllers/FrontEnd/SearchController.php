<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\ArticlesSearchService;

class SearchController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct() {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        SEOMeta::setTitle("Search");

        $articlesSearchService = new ArticlesSearchService();

        $searchTerm = $request->searchTerm;
        if ($searchTerm)
        {
            $articlesSearchService->attachKeywordToUser($searchTerm);
        }

        return view('frontend.pages.search.index', ['articlesSearchService' => $articlesSearchService]);

    }
}
