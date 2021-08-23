<?php

namespace App\Http\Controllers\Admin;

use App\Models\VacancyLive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportVacanciesDataController extends Controller
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

        $clientId = 1;
        $year = 1;
        $institutionId = 3;

        $ee = VacancyLive::query()->select('id', 'title', 'employer_id')
                                    ->where('all_clients', 'Y')
                                    ->orWhere(function ($query) use ($clientId) {
                                        $query->where('all_clients', 'N');
                                        $query->wherehas('clients', function ($query)  use ($clientId) {
                                            $query->where('client_id', $clientId );
                                        });
                                    })
                                    ->with('vacancyTotalStats', function ($query) use ($institutionId, $year){
                                        $query->where('year_id', $year);
                                        $query->select('vacancy_id', 'total');

                                        //if all institutions and public access
                                        if ($institutionId == -1)
                                        {
                                            //do nothing, and select all

                                        //if Public Access only
                                        } elseif ($institutionId == -2) {
                                            $query->where('institution_id', NULL);

                                        //if a specific institution
                                        } else {
                                            $query->where('institution_id', $institutionId);
                                        }
                                    })
                                    ->with('employer', function ($query) {
                                        $query->select('id', 'name');
                                    })
                                    ->orderBy('title', 'asc')->first();

//dd($ee);


        if (!Auth::guard('admin')->user()->hasPermissionTo('report-list')) {
            abort(403);
        }

        return view('admin.pages.reports.vacancies.show');

    }

}
