<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Institution;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use \Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\InstitutionStoreRequest;
use App\Services\Admin\InstitutionService;

class ClientInstitutionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Client $client)
    {

        //checks policy
        $this->authorize('listClientInstitutions', $client);

        //current client
        $clientUuid = $client->uuid;

        if ($request->ajax()) {

            //selects institution from specific client
            $data = DB::table('institutions')
                ->select(['id', 'name', 'uuid', 'suspended'])
                ->where(function ($query) use ($client){
                    $query->where('client_id', $client->id);
                })
                ->where('deleted_at', '=', NULL)
                ->orderBy('name', 'ASC');

            return DataTables::of($data)
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('action', function($row) use ($clientUuid){

                    $actions = "";

                    if (Auth::guard('admin')->user()->hasAnyPermission('institution-edit')) {
                        $actions .= '<a href="'.route("admin.clients.institutions.edit", ["client" => $clientUuid, "institution" => $row->uuid]).'" class="edit mydir-dg btn mx-1"><i class="far fa-edit"></i></a>';
                        $actions .= '<a href="'.route("admin.clients.institutions.advisers.edit", ["client" => $clientUuid, "institution" => $row->uuid]).'" class="edit mydir-dg btn mx-1"><i class="fas fa-user-edit"></i></a>';
                    }

                    if (Auth::guard('admin')->user()->hasAnyPermission('institution-suspend')) {

                        //if the content is NOT live OR if both updated date are not the same
                        if ($row->suspended == 'N')
                        {
                            $class = "open-suspend-modal";
                            $label = "<i class='fas fa-lock'></i>";

                        //elseif the content is live
                        } else {
                            $class = "open-unsuspend-modal";
                            $label = "<i class='fas fa-lock-open'></i>";
                        }

                        $actions .= '<button id="suspend_'.$row->uuid.'" class="'.$class.' mydir-dg btn mx-1" id="" data-id="'.$clientUuid.'" data-id2="'.$row->uuid.'">'.$label.'</button>';
                    }

                    if (Auth::guard('admin')->user()->hasAnyPermission('institution-delete')) {
                        $actions .= '<button id="delete_'.$row->uuid.'" class="open-delete-modal mydir-dg btn mx-1" id="" data-id="'.$clientUuid.'" data-id2="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
                    }

                    return $actions;
                })
                ->filter(function ($query){

                    if (request()->has('search.value')) {
                        if (!empty(request('search.value'))){
                            $query->where(function($query) {
                                $query->where('institutions.name', 'LIKE', "%" . request('search.value') . "%");
                            });
                        }
                    }

                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('admin.pages.institutions.index', compact('clientUuid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Institution $institution
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client, Institution $institution)
    {
        //checks policy
        $this->authorize('create', Institution::class);

        $institution = new Institution;

        return view('admin.pages.institutions.create', [ 'institution' => $institution, 'client' => $client]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\InstitutionStoreRequest  $request
     * @param  \App\Models\Client $client
     * @param  \App\Models\Institution $institution
     * @return \Illuminate\Http\Response
     */
    public function store(InstitutionStoreRequest $request, Client $client, Institution $institution)
    {

        // Will return only validated data
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            $validatedData['client_id'] = $client->id;

            //creates the client's institution
            Institution::create($validatedData);

            $level1Route = 'admin.clients.institutions.index';

            $level2Route = 'admin.institution.index';

            DB::commit();

            return redirect()->route('admin.clients.institutions.index', ['client' => $client->uuid])
                ->with('success', 'Institution created successfully');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.clients.institutions.index', ['client' => $client->uuid])
                            ->with('error', 'An error occured, your institution could not be created');
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\Client $client
     * @param  \App\Models\Institution $institution
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Client $client, Institution $institution)
    {

        //check authoridation
        $this->authorize('update', $institution);

        return view('admin.pages.institutions.edit', ['client' => $client, 'institution' => $institution]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\InstitutionStoreRequest  $request
     * @param  \App\Models\Client $client
     * @param  \App\Models\Institution $institution
     * @return \Illuminate\Http\Response
     */
    public function update(InstitutionStoreRequest $request, Client $client, Institution $institution)
    {

        //check authoridation
        $this->authorize('update', $institution);

        // Will return only validated data
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            if (!isset($validatedData['work_experience']))
            {
                $validatedData['work_experience'] = 'N';
            }
            $institution->update($validatedData);

            DB::commit();

             return redirect()->route('admin.clients.institutions.index', ['client' => $client, 'institution' => $institution])
                             ->with('success', 'Institution updated successfully');

        }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.clients.institutions.index', ['client' => $client, 'institution' => $institution])
                            ->with('error', 'An error occured, your institution could not be updated');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Institution $institution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Client $client, Institution $institution)
    {
        //check policy authorisation
        $this->authorize('delete', $institution);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $institutionId = $institution->id;

                $institutionService = new InstitutionService();
                $institutionService->delete($institutionId);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your institution has been successfully deleted!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your institution could not be deleted. Try Again!";
            }

            return response()->json($data_return, 200);

        }
    }



    /**
     * Suspend the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Institution $institution
     * @return \Illuminate\Http\Response
     */
    public function suspend(Request $request, Client $client, Institution $institution){

        //check policy authorisation
        $this->authorize('suspend', $institution);

        if ($request->ajax())
        {

            DB::beginTransaction();

            try  {

                $institution->suspended = 'Y';
                $institution->save();

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your institution has been successfully suspended!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your institution could not be suspended. Try Again!";
            }

            return response()->json($data_return, 200);

        }
    }


    /**
     * Unsuspend the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Admin\Institution $institution
     * @return \Illuminate\Http\Response
     */
    public function unsuspend(Request $request, Client $client, Institution $institution){

        //check policy authorisation
        $this->authorize('suspend', $institution);

        if ($request->ajax())
        {

            DB::beginTransaction();

            try  {

                $institution->suspended = 'N';
                $institution->save();

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your institution has successfully been unsuspended!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your institution could not be unsuspended. Try Again!";
            }

            return response()->json($data_return, 200);

        }
    }

}
