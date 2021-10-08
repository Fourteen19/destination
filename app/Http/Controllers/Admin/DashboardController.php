<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\EventAccess;
use App\Models\LoginAccess;
use Illuminate\Http\Request;
use App\Models\ContentAccess;
use App\Models\VacancyAccess;
use App\Models\DashboardStats;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


        if (Auth::guard('admin')->user()->can('dashboard-stats-view'))
        {

            $dashboardStatsData = DashboardStats::where('client_id', Session::get('adminClientSelectorSelected') )->orderBy('created_at', 'desc')->limit(1)->get();
            if (count($dashboardStatsData) > 0)
            {
                $dashboardStats = $dashboardStatsData->first()->toArray();
            } else {
                $dashboardStats = NULL;
            }

        } else {

            $dashboardStats = NULL;

        }

        return view('admin.dashboard',  compact('dashboardStats'));
    }

}
