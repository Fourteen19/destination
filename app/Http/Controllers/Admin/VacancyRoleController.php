<?php

namespace App\Http\Controllers\Admin;

use App\Models\VacancyRole;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\VacancyRoleService;
use App\Http\Requests\Admin\VacancyRoleStoreRequest;

class VacancyRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //check authoridation
        $this->authorize('list', VacancyRole::class);

        if (!$request->ajax()) {


        //if AJAX request
         } else {

            //compiles the query
            $items = VacancyRole::select('uuid', 'name')
                            ->orderBy('name', 'ASC');


            return DataTables::of($items)
            ->addColumn('name', function($row){
                return $row->name;
            })
            ->addColumn('action', function($row){

                $actions = "";

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-role-edit') ){
                    $actions = '<a href="'.route("admin.vacancies.roles.edit", ['role' => $row->uuid]).'" class="edit mydir-dg btn">Edit</a> ';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-role-delete') ){
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Delete</button>';
                }

                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);

        }

        return view('admin.pages.vacancies.roles.index', ['contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //check authoridation
        $this->authorize('create', VacancyRole::class);

        $vacancyRole = new VacancyRole;

        return view('admin.pages.vacancies.roles.create', ['vacancyRole' => $vacancyRole,
                                                     'contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
    }

    /**
     * Store a newly created vacancy in storage.
     *
     * @param  mixed $request
     * @param  mixed $vacancyService
     * @return void
     */
    public function store(VacancyRoleStoreRequest $request, VacancyRoleService $vacancyRoleService)
    {
        //checks policy
        $this->authorize('create', VacancyRole::class);

        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            //creates the resource
            $vacancyRoleService->createResource($validatedData);

            DB::commit();

            return redirect()->route('admin.vacancies.roles.index')
                ->with('success','Your vacancy role has been created successfully');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.vacancies.roles.index')
                            ->with('error', 'An error occured, your vacancy role could not be created');
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  VacancyRole $vacancyRole
     * @return \Illuminate\Http\Response
     */
    public function edit(VacancyRole $vacancyRole)
    {

        //check authoridation
        $this->authorize('update', $vacancy);

        return view('admin.pages.vacancies.roles.edit', ['action' => 'edit', 'resource' => $vacancy]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed $request
     * @param  mixed $resource
     * @return void
     */
    public function update(VacancyRoleStoreRequest $request, VacancyRole $vacancyRole, VacancyRoleService $vacancyRoleService)
    {

        //checks policy
        $this->authorize('update', $vacancyRole);

        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            //creates the vacancy
            $vacancyRoleService->updateResource($vacancyRole, $validatedData);

            DB::commit();

            return redirect()->route('admin.vacancies.roles.index')
                ->with('success','Your vacancy role has been updated successfully');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.vacancies.roles.index')
                            ->with('error', 'An error occured, your vacancy role could not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed $resource
     * @return void
     */
    public function destroy(Request $request, VacancyRole $vacancyRole, VacancyRoleService $vacancyRoleService)
    {
        //check policy authorisation
        $this->authorize('delete', $vacancyRole);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $vacancyRoleId = $vacancyRole->id;

                $result = $vacancyRoleService->delete($vacancyRole);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Vacancy role successfully deleted!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Vacancy role could not be not deleted, Try Again!";

            }

            return response()->json($data_return, 200);

        }
    }

}
