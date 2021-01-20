<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemTag;
use App\Http\Requests\Frontend\SelfAssessmentRoutes;

class myAccountController extends Controller
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

        return view('frontend.pages.my-account.edit');

    }


}
