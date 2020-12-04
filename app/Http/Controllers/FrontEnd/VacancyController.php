<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VacancyController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct() {

    }

    /**
     * Show the application vacancies.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('frontend.pages.vacancies.index');

    }


    /**
     * Show the vacancy.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {

        return view('frontend.pages.vacancies.show');

    }
}
