<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Admin\VacancyService;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PassedVacancyController extends Controller
{

    private $vacancyService;


    public function __construct(VacancyService $vacancyService)
    {

        $this->vacancyService = $vacancyService;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //check authoridation
        $this->authorize('list', Vacancy::class);

        if (!$request->ajax()) {


        //if AJAX request
         } else {


            //if system admin, load all the vacancies
            if (isGlobalAdmin())
            {

                $items = DB::table('vacancies')
                            ->leftjoin('vacancies_live', 'vacancies.id', '=', 'vacancies_live.id')
                            ->leftjoin('employers', 'vacancies.employer_id', '=', 'employers.id')
                            ->leftjoin('clients', 'vacancies.client_id', '=', 'clients.id')
                            ->where('vacancies.deleted_at', NULL)
                            ->whereNotNull('vacancies.display_until')
                            ->whereDate('vacancies.display_until', '<', Carbon::today()->toDateString())
                            ->orderBy('vacancies.updated_at','DESC')
                            ->select(
                                "vacancies.id",
                                "vacancies.uuid",
                                "vacancies.title",
                                "vacancies.all_clients",
                                "employers.name as employer_name",
                                "vacancies.updated_at",
                                "vacancies.deleted_at",
                                "vacancies_live.deleted_at as deleted_at_live",
                                "vacancies_live.id as live_id",
                                "vacancies_live.updated_at as live_updated_at",
                                "clients.name as client_name"
                            );

            } elseif (isClientAdmin()) {

                $items = DB::table('vacancies')
                            ->leftjoin('vacancies_live', 'vacancies.id', '=', 'vacancies_live.id')
                            ->leftjoin('employers', 'vacancies.employer_id', '=', 'employers.id')
                            ->leftjoin('clients', 'vacancies.client_id', '=', 'clients.id')
                            ->leftJoin('clients_vacancies', 'clients_vacancies.vacancy_id', '=', 'vacancies.id')
                            ->where('vacancies.deleted_at', NULL)
                            ->where('clients_vacancies.client_id', Auth::guard('admin')->user()->client_id)
                            ->whereNotNull('vacancies.display_until')
                            ->whereDate('vacancies.display_until', '<', Carbon::today()->toDateString())
                            ->orderBy('vacancies.updated_at','DESC')
                            ->select(
                                "vacancies.id",
                                "vacancies.uuid",
                                "vacancies.title",
                                "vacancies.all_clients",
                                "employers.name as employer_name",
                                "vacancies.updated_at",
                                "vacancies.deleted_at",
                                "vacancies_live.deleted_at as deleted_at_live",
                                "vacancies_live.id as live_id",
                                "vacancies_live.updated_at as live_updated_at",
                                "clients.name as client_name"
                            );

            //a client admin can only see vacancies allocated to its own client
            } elseif ( (isClientAdvisor()) || (isClientTeacher(Auth::guard('admin')->user())) ) {


                $items = DB::table('vacancies')
                            ->leftjoin('vacancies_live', 'vacancies.id', '=', 'vacancies_live.id')
                            ->leftjoin('employers', 'vacancies.employer_id', '=', 'employers.id')
                            ->leftjoin('clients', 'vacancies.client_id', '=', 'clients.id')
                            ->leftJoin('clients_vacancies', 'clients_vacancies.vacancy_id', '=', 'vacancies.id')
                            ->where('vacancies.deleted_at', NULL)
                            ->where('clients_vacancies.client_id', Auth::guard('admin')->user()->client_id)
                            ->whereNotNull('vacancies.display_until')
                            ->whereDate('vacancies.display_until', '<', Carbon::today()->toDateString())
                            ->where('vacancies.created_by', Auth::guard('admin')->user()->id)
                            ->orderBy('vacancies.updated_at','DESC')
                            ->select(
                                "vacancies.id",
                                "vacancies.uuid",
                                "vacancies.title",
                                "vacancies.all_clients",
                                "employers.name as employer_name",
                                "vacancies.updated_at",
                                "vacancies.deleted_at",
                                "vacancies_live.deleted_at as deleted_at_live",
                                "vacancies_live.id as live_id",
                                "vacancies_live.updated_at as live_updated_at",
                                "clients.name as client_name"
                            );

            //an employer can see all allocations
            } elseif (isemployer(Auth::guard('admin')->user())) {

                $items = DB::table('vacancies')
                        ->leftjoin('vacancies_live', 'vacancies.id', '=', 'vacancies_live.id')
                        ->leftjoin('employers', 'vacancies.employer_id', '=', 'employers.id')
                        ->leftjoin('clients', 'vacancies.client_id', '=', 'clients.id')
                        ->leftJoin('clients_vacancies', 'clients_vacancies.vacancy_id', '=', 'vacancies.id')
                        ->whereNotNull('vacancies.display_until')
                        ->whereDate('vacancies.display_until', '<', Carbon::today()->toDateString())
                        ->where('vacancies.deleted_at', NULL)
                        ->where('vacancies.created_by', Auth::guard('admin')->user()->id)
                        ->orderBy('vacancies.updated_at','DESC')
                        ->select(
                            "vacancies.id",
                            "vacancies.uuid",
                            "vacancies.title",
                            "vacancies.all_clients",
                            "employers.name as employer_name",
                            "vacancies.updated_at",
                            "vacancies.deleted_at",
                            "vacancies_live.deleted_at as deleted_at_live",
                            "vacancies_live.id as live_id",
                            "vacancies_live.updated_at as live_updated_at",
                            "clients.name as client_name"
                        );

            }



            return DataTables::of($items)
            ->addColumn('title', function($row){
                return $row->title;
            })
            ->addColumn('employer', function($row){
                return $row->employer_name;
            })
            ->addColumn('client', function($row){
                $clients_name_txt = "";
                if ($row->all_clients == 'Y')
                {
                    $clients_name_txt = "ALL";
                } else {
                    $clients = Vacancy::find($row->id)->clients()->get();
                    foreach($clients as $client)
                    {
                        $clients_name_txt .= $client->name . "<br>";
                    }
                }
                return $clients_name_txt;
            })
            ->addColumn('action', function($row){

                $actions = "";

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-edit') ){
                    $actions = '<a href="'.route("admin.vacancies.edit", ['vacancy' => $row->uuid]).'" class="edit mydir-dg btn"><i class="fas fa-edit"></i></a> ';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-delete') ){
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
                }

                return $actions;
            })
            ->rawColumns(['action', 'client'])
            ->make(true);

        }

        return view('admin.pages.passed-vacancies.index', ['contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
    }


}
