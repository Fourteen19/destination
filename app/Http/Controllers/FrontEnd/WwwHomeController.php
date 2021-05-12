<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;

class WwwHomeController extends Controller
{

    /**
     * Show the application www homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        SEOMeta::setTitle("");

        return view('frontend.pages.www.show');

    }
}
