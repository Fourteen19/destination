<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Vacancy;
use App\Models\VacancyLive;
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
    public function show($clientSubdomain, VacancyLive $vacancy)
    {

        return view('frontend.pages.vacancies.show', ['vacancy' => $vacancy, ]);

    }
}
