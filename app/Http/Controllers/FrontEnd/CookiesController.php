<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Client;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
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

        SEOMeta::setTitle("Cookie policy");

        $data = Client::find(Session::get('fe_client')['id'])->staticClientContent()->select('show_cookies as show_screen', 'cookies as body_txt')->first()->toArray();
        $data['title'] = "Cookie policy";

        if ($data['show_screen'] == 'N')
        {
            return redirect()->route('frontend.home');
        }

        return view('frontend.pages.page-info', ['data' => $data]);

    }
}
