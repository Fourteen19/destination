<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;

class WwwHomeController extends Controller
{

    /**
     * Show the application www homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('frontend.pages.www.show');

    }
}
