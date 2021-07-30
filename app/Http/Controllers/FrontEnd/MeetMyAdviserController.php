<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;

class MeetMyAdviserController extends Controller
{
    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct() {

    }


    public function index()
    {

        SEOMeta::setTitle("Meet my adviser");

        return view('frontend.pages.my-account.meet-my-adviser');

    }

}
