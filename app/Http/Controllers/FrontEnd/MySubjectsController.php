<?php

namespace App\Http\Controllers\FrontEnd;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;

class MySubjectsController extends Controller
{

    /**
     * Show pages.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request)
    {

        SEOMeta::setTitle("My subjects");

        return view('frontend.pages.my-subjects.show');
    }

}
