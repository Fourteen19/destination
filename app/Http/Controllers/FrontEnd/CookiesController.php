<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CookiesController extends Controller
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

        $data = Session::get('fe_client')->staticClientContent()->select('show_cookies as show_screen', 'cookies as body_txt')->first()->toArray();
        $data['title'] = "Cookie policy";

        if ($data['show_screen'] == 'N')
        {
            return redirect()->route('frontend.home');
        }

        return view('frontend.pages.page-info', ['data' => $data]);

    }
}
