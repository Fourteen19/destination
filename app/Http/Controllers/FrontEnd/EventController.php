<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct() {

    }

    /**
     * Show the application events.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('frontend.pages.events.index');

    }

    /**
     * Show the event.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {

        return view('frontend.pages.events.show');

    }
}
