<?php

namespace App\Http\Controllers\FrontEnd;


use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Session;

class TermsController extends Controller
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
    public function index()
    {

        SEOMeta::setTitle("Terms & Conditions");

        $data = Session::get('fe_client')->staticClientContent()->select('show_terms as show_screen', 'terms as body_txt')->first()->toArray();
        $data['title'] = "Terms & Conditions";

        if ($data['show_screen'] == 'N')
        {
            return redirect()->route('frontend.home');
        }

        return view('frontend.pages.page-info', ['data' => $data]);

    }
}
