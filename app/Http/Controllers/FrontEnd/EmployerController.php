<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;

class EmployerController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct() {
        //
    }



    public function index(Request $request)
    {

        $data = ContentLive::select('summary_heading', 'summary_text')->where('template_id', 4)->get();

        return view('frontend.pages.employers.index', ['data' => $data]);

    }





    /**
     * show
     *
     * @param  mixed $clientSubdomain
     * @param  mixed $employer
     * @return void
     */
    public function show(String $clientSubdomain, ContentLive $employer)
    {

        SEOMeta::setTitle($employer->title);

        return view('frontend.pages.employers.show', ['content' => $employer]);

    }

}
