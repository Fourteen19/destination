<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;

class WwwController extends Controller
{

    /**
     * Show the application www homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        abort(404);

    }
}
