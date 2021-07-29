<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportArticlesDataController extends Controller
{

    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function index(Request $request)
    {

        if (!Auth::guard('admin')->user()->hasPermissionTo('report-list')) {
            abort(403);
        }

        return view('admin.pages.reports.articles.show');

    }

}
