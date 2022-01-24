<?php

namespace App\Http\Controllers\Admin;

use App\Models\VacancyRole;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            $items = VacancyRole::select('uuid', 'name', 'display')
                                ->where('deleted_at', '=', NULL)
                                ->orderBy('name', 'ASC');


            return DataTables::of($items)
            ->addColumn('name', function($row){
                return $row->name;
            })
            ->addColumn('display', function($row){
                return $row->display;
            })
            ->addColumn('action', function($row){

                $actions = "";

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-role-edit') ){
                    $actions = '<a href="'.route("admin.vacancies.roles.edit", ['role' => $row->uuid]).'" class="edit mydir-dg btn"><i class="fas fa-edit"></i></a> ';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-role-delete') ){
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
                }

                return $actions;
            })
            ->filter(function ($query){
                if (request()->has('search.value')) {
                    if (!empty(request('search.value'))){
                        $query->where('vacancy_roles.name', 'LIKE', "%" . request('search.value') . "%");
                    }
                }
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
            $vacancyRoleService->createVacancyRole($validatedData);

            DB::commit();

            return redirect()->route('admin.vacancies.roles.index')
                ->with('success','Your vacancy role has been created successfully');

        } catch (\Exception $e) {

            Log::error($e);

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
    public function edit(VacancyRole $role)
    {

        //check authoridation
        $this->authorize('update', $role);

        return view('admin.pages.vacancies.roles.edit', ['vacancyRole' => $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed $request
     * @param  mixed $resource
     * @return void
     */
    public function update(VacancyRoleStoreRequest $request, VacancyRole $role, VacancyRoleService $vacancyRoleService)
    {

        //checks policy
        $this->authorize('update', $role);

        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            //creates the vacancy
            $vacancyRoleService->updateVacancyRole($role, $validatedData);

            DB::commit();

            return redirect()->route('admin.vacancies.roles.index')
                ->with('success','Your vacancy role has been updated successfully');

        } catch (\Exception $e) {

            Log::error($e);

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
    public function destroy(Request $request, VacancyRole $role, VacancyRoleService $vacancyRoleService)
    {
        //check policy authorisation
        $this->authorize('delete', $role);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $vacancyRoleId = $role->id;

                $role->delete();

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Vacancy role successfully deleted!";

            } catch (\Exception $e) {

                Log::error($e);

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Vacancy role could not be not deleted, Try Again!";

            }

            return response()->json($data_return, 200);

        }
    }

}
