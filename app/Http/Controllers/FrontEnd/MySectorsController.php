<?php

namespace App\Http\Controllers\FrontEnd;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;

class MySectorsController extends Controller
{

    /**
     * Show pages.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request)
    {

        SEOMeta::setTitle("My Sectors");

        return view('frontend.pages.my-sectors.show');
    }

}
