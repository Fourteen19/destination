<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\VacancyService;


class VacancyController extends Controller
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
                            ->whereNull('vacancies.deleted_at')
                            ->Where(function ($query) {
                                $query->where('vacancies.display_until', NULL);
                                $query->orWhere(function($query) {
                                    $query->whereDate('vacancies.display_until', '>=', Carbon::today()->toDateString());
                                });
                            })
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

            } elseif ( adminHasAnyRole(Auth::guard('admin')->user(), [config('global.admin_user_type.Client_Admin'), config('global.admin_user_type.Client_Content_Admin'), ]) ) {

                $items = DB::table('vacancies')
                            ->leftjoin('vacancies_live', 'vacancies.id', '=', 'vacancies_live.id')
                            ->leftjoin('employers', 'vacancies.employer_id', '=', 'employers.id')
                            ->leftjoin('clients', 'vacancies.client_id', '=', 'clients.id')
                            ->leftJoin('clients_vacancies', 'clients_vacancies.vacancy_id', '=', 'vacancies.id')
                            ->where('vacancies.deleted_at', NULL)
                            ->where('clients_vacancies.client_id', Auth::guard('admin')->user()->client_id)
                            ->Where(function ($query) {
                                $query->where('vacancies.display_until', NULL);
                                $query->orWhere(function($query) {
                                    $query->whereDate('vacancies.display_until', '>=', Carbon::today()->toDateString());
                                });
                            })
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
                            ->Where(function ($query) {
                                $query->where('vacancies.display_until', NULL);
                                $query->orWhere(function($query) {
                                    $query->whereDate('vacancies.display_until', '>=', Carbon::today()->toDateString());
                                });
                            })
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
            //} elseif (isemployer(Auth::guard('admin')->user())) {
            } elseif ( adminHasAnyRole(Auth::guard('admin')->user(), [config('global.admin_user_type.Third_Party_Admin'), config('global.admin_user_type.Employer')]) ) {

                $items = DB::table('vacancies')
                        ->leftjoin('vacancies_live', 'vacancies.id', '=', 'vacancies_live.id')
                        ->leftjoin('employers', 'vacancies.employer_id', '=', 'employers.id')
                        ->leftjoin('clients', 'vacancies.client_id', '=', 'clients.id')
                        ->leftJoin('clients_vacancies', 'clients_vacancies.vacancy_id', '=', 'vacancies.id')
                        ->where('vacancies.created_by', "=", Auth::guard('admin')->user()->id)
                        ->whereNull('vacancies.deleted_at')
                        ->where('clients_vacancies.client_id', Auth::guard('admin')->user()->client_id)
                        ->where(function ($query)  {
                            $query->where('vacancies.display_until', NULL);
                            $query->orWhere(function($query) {
                                $query->whereDate('vacancies.display_until', '>=', Carbon::today()->toDateString());
                            });
                        })
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
                    {
                        foreach($clients as $client)
                        {
                            $clients_name_txt .= $client->name . "<br>";
                        }
                    }
                }
                return $clients_name_txt;
            })
            ->addColumn('action', function($row){

                $actions = "";

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-edit') ){
                    $actions = '<a href="'.route("admin.vacancies.edit", ['vacancy' => $row->uuid]).'" class="edit mydir-dg btn"><i class="fas fa-edit"></i></a> ';
                }

                if ( (Auth::guard('admin')->user()->hasAnyPermission('vacancy-make-live') ) && ( (empty($row->live_id)) || ( (!empty($row->live_id) && (!empty($row->deleted_at_live)) ) ) ) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-make-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="fas fa-check mr-1"></i><i class="fas fa-bolt"></i></button>';
                } elseif ( (Auth::guard('admin')->user()->hasAnyPermission('vacancy-make-live') ) && (!empty($row->live_id)) && ($row->updated_at != $row->live_updated_at) && (empty($row->deleted_at_live)) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-apply-latest-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="far fa-clock mr-1"></i><i class="fas fa-bolt"></i></button>';
                }

                if ( (Auth::guard('admin')->user()->hasAnyPermission('vacancy-make-live') ) && (!empty($row->live_id)) && (empty($row->deleted_at_live)) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-remove-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="fas fa-times mr-1"></i><i class="fas fa-bolt"></i></button>';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-delete') ){
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
                }

                return $actions;
            })
            ->filter(function ($query){
                if (request()->has('search.value')) {
                    if (!empty(request('search.value'))){
                        $query->where('vacancies.title', 'LIKE', "%" . request('search.value') . "%");
                    }
                }
            })
            ->rawColumns(['action', 'client'])
            ->make(true);

        }

        return view('admin.pages.vacancies.index', ['contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //check authoridation
        $this->authorize('create', Vacancy::class);

        $vacancy = new Vacancy;

        return view('admin.pages.vacancies.create', ['vacancy' => $vacancy,
                                                     'contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Vacancy $vacancy
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacancy $vacancy)
    {

        //check authoridation
        $this->authorize('update', $vacancy);

        return view('admin.pages.vacancies.edit', ['vacancy' => $vacancy,
                                                    'contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
    }




    /**
     * Make live the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\ContenVacancyt $vacancy
     * @return \Illuminate\Http\Response
     */
    public function makeLive(Request $request, Vacancy $vacancy)
    {

        //check policy authorisation
        $this->authorize('makeLive', $vacancy);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $vacancy_id = $vacancy->id;

                $this->vacancyService->makeLive($vacancy);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your vacancy has successfully been made live!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your vacancy could not be made live!";
            }

            return response()->json($data_return, 200);

        }

    }

    /**
     * remove from live the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Vacancy $vacancy
     * @return \Illuminate\Http\Response
     */
    public function removeLive(Request $request, Vacancy $vacancy)
    {
        //check policy authorisation
        $this->authorize('makeLive', $vacancy);

         if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $vacancy_id = $vacancy->id;

                $this->vacancyService->removeLive($vacancy);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your vacancy has successfully been removed from live!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your vacancy could not be removed from live!";
            }

            return response()->json($data_return, 200);

        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed $resource
     * @return void
     */
    public function destroy(Request $request, Vacancy $vacancy, VacancyService $vacancyService)
    {
        //check policy authorisation
        $this->authorize('delete', $vacancy);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $vacancyId = $vacancy->id;

                $result = $vacancyService->delete($vacancy);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Vacancy successfully deleted!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Vacancy could not be not deleted, Try Again!";

            }

            return response()->json($data_return, 200);

        }
    }

}
