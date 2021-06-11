<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\EmployerService;


class EmployerController extends Controller
{

    private $employerService;

    public function __construct(EmployerService $employerService)
    {

        $this->employerService = $employerService;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //check authoridation
        $this->authorize('list', Employer::class);

        if (!$request->ajax()) {


        //if AJAX request
         } else {

            //compiles the query
            $items = Employer::select('id', 'uuid', 'name')
                            ->orderBy('updated_at', 'DESC');

            return DataTables::of($items)
            ->addColumn('name', function($row){
                return $row->name;
            })
            ->addColumn('action', function($row){

                $actions = "";

                if (Auth::guard('admin')->user()->hasAnyPermission('employer-edit') ){
                    $actions = '<a href="'.route("admin.employers.edit", ['employer' => $row->uuid]).'" class="edit mydir-dg btn"><i class="fas fa-edit"></i></a> ';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('employer-delete') ){
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
                }

                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);

        }

        return view('admin.pages.employers.index', ['contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //check authoridation
        $this->authorize('create', Employer::class);

        $employer = new Employer;

        return view('admin.pages.employers.create', ['employer' => $employer,
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
     * @param  Employer $employer
     * @return \Illuminate\Http\Response
     */
    public function edit(Employer $employer)
    {

        //check authoridation
        $this->authorize('update', $employer);

        return view('admin.pages.employers.edit', ['employer' => $employer,
                                                    'contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
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
    public function destroy(Request $request, Employer $employer, EmployerService $employerService)
    {
        //check policy authorisation
        $this->authorize('delete', $employer);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $employerId = $employer->id;

                $result = $employerService->delete($employer);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Employer successfully deleted!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Employer could not be not deleted, Try Again!";

            }

            return response()->json($data_return, 200);

        }
    }

}
