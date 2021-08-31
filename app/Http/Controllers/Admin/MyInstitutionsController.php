<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Institution;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use \Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\InstitutionService;
use App\Http\Requests\Admin\InstitutionStoreRequest;
use App\Http\Requests\Admin\MyInstitutionStoreRequest;
use App\Http\Requests\Admin\InstitutionAdvisorStoreRequest;

class MyInstitutionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //checks policy
        //$this->authorize('listClientInstitutions', $client);

        if ($request->ajax()) {

            //selects institution allocated to admin user
            $data = Auth::guard('admin')->user()->institutions;

            return DataTables::of($data)
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('action', function($row){

                    $actions = "";

                    //NEEDS TO BE UPDATED -- if advisor has access to institution
                    //if (Auth::guard('admin')->user()->hasAnyPermission('institution-edit')) {
                        $actions .= '<a href="'.route("admin.my-institutions.edit", ["my_institution" => $row->uuid]).'" class="edit mydir-dg btn mx-1"><i class="far fa-edit"></i></a>';
                    //}

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('admin.pages.my-institutions.index');
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\Client $client
     * @param  \App\Models\Institution $institution
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Institution $my_institution)
    {

        //check authoridation
        $this->authorize('updateMyInstitution', $my_institution);

        $institutionId = $my_institution->id;

        $advisorData = Auth::guard('admin')->user()->relatedInstitutionData($institutionId)->first();

        //'client' => $client,
        return view('admin.pages.my-institutions.edit', ['institution' => $my_institution, 'advisorData' => $advisorData]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\InstitutionStoreRequest  $request
     * @param  \App\Models\Client $client
     * @param  \App\Models\Institution $institution
     * @return \Illuminate\Http\Response
     */
    public function update(MyInstitutionStoreRequest $request, Institution $myInstitution)
    {

        //check authoridation
        $this->authorize('updateMyInstitution', $myInstitution);

        // Will return only validated data
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            $institution = Auth::guard('admin')->user()->relatedInstitutionData($myInstitution->id)->first();

            $institution->pivot->update($validatedData);

            DB::commit();

             return redirect()->route('admin.my-institutions.index')
                             ->with('success', 'Institution data updated successfully');

        }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.my-institutions.index')
                            ->with('error', 'An error occured, your institution data could not be updated');
        }

    }


}
