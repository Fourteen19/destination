<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct() {

    }

    /**
     * Show the application welcome screen.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('frontend.pages.welcome');

    }
}
