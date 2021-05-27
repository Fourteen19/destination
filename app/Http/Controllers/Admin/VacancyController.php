<?php

namespace App\Http\Controllers\Admin;

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

            //compiles the query
            $items = Vacancy::select('id', 'uuid', 'title', 'employer_name')
                            ->orderBy('updated_at', 'DESC');


            $items = DB::table('vacancies')
            ->leftjoin('vacancies_live', 'vacancies.id', '=', 'vacancies_live.id')
            ->where('vacancies.deleted_at', NULL)
            ->orderBy('vacancies.updated_at','DESC')
            ->select(
                "vacancies.uuid",
                "vacancies.title",
                "vacancies.employer_name",
                "vacancies.updated_at",
                "vacancies.deleted_at",
                "vacancies_live.deleted_at as deleted_at_live",
                "vacancies.id as live_id",
                "vacancies.updated_at as live_updated_at"
            );

            return DataTables::of($items)
            ->addColumn('title', function($row){
                return $row->title;
            })
            ->addColumn('employer', function($row){
                return $row->employer_name;
            })
            ->addColumn('client', function($row){
                return "[CLIENT]";
            })
            ->addColumn('action', function($row){

                $actions = "";

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-edit') ){
                    $actions = '<a href="'.route("admin.vacancies.edit", ['vacancy' => $row->uuid]).'" class="edit mydir-dg btn"><i class="fas fa-edit"></i></a> ';
                }

                if ( (Auth::guard('admin')->user()->hasAnyPermission('vacancy-make-live') ) && ( (empty($row->live_id)) || ( (!empty($row->live_id) && (!empty($row->deleted_at_live)) ) ) ) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-make-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Make Live</button>';
                } elseif ( (Auth::guard('admin')->user()->hasAnyPermission('vacancy-make-live') ) && (!empty($row->live_id)) && ($row->updated_at != $row->live_updated_at) && (empty($row->deleted_at_live)) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-apply-latest-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Apply latest changes to Live</button>';
                }

                if ( (Auth::guard('admin')->user()->hasAnyPermission('vacancy-make-live') ) && (!empty($row->live_id)) && (empty($row->deleted_at_live)) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-remove-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Remove from Live</button>';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-delete') ){
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
                }

                return $actions;
            })
            ->rawColumns(['action'])
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
     * Store a newly created vacancy in storage.
     *
     * @param  mixed $request
     * @param  mixed $vacancyService
     * @return void
     */
    /* public function store(VacancyStoreRequest $request, VacancyService $vacancyService)
    {
        //checks policy
        $this->authorize('create', Vacancy::class);

        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            //creates the resource
            $vacancyService->createResource($validatedData);

            DB::commit();

            return redirect()->route('admin.vacancies.index')
                ->with('success','Your vacancy has been created successfully');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.vacancies.index')
                            ->with('error', 'An error occured, your vacancy could not be created');
        }
    }
 */


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

            /* DB::beginTransaction();

            try  {
 */
                $vacancy_id = $vacancy->id;

                $this->vacancyService->makeLive($vacancy);

                /* DB::commit(); */

                $data_return['result'] = true;
                $data_return['message'] = "Your vacancy has successfully been made live!";

            /* } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your vacancy could not be made live!";
            } */

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

            /* DB::beginTransaction();

            try  { */

                $vacancy_id = $vacancy->id;

                $this->vacancyService->removeLive($vacancy);

                /* DB::commit(); */

                $data_return['result'] = true;
                $data_return['message'] = "Your vacancy has successfully been removed from live!";

            /* } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your vacancy could not be removed from live!";
            } */

            return response()->json($data_return, 200);

        }
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  mixed $request
     * @param  mixed $resource
     * @return void
     */
    /* public function update(VacancyStoreRequest $request, Vacancy $vacancy, VacancyService $vacancyService)
    {

        //checks policy
        $this->authorize('update', $vacancy);

        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            //creates the vacancy
            $vacancyService->updateResource($vacancy, $validatedData);

            DB::commit();

            return redirect()->route('admin.vacancies.index')
                ->with('success','Your vacancy has been updated successfully');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.vacancies.index')
                            ->with('error', 'An error occured, your vacancy could not be updated');
        }
    } */

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
