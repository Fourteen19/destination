<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Exports\UsersExport;
use App\Jobs\SendOrderEmail;
use Illuminate\Http\Request;
use App\Jobs\SendReportEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyUserOfCompletedExport;

class ReportUserDataController extends Controller
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
/*
        $institution = "institution-name";
        $filename = 'user-data_'.$institution.'-'.date("dmyHis").'.csv';

        (new UsersExport(1, 2))->queue($filename, 'exports')->chain([
            new NotifyUserOfCompletedExport(request()->user(), $filename),
        ]);
*/
        return view('admin.pages.reports.user-data.show');

    }

}

