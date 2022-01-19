<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use \Illuminate\Support\Facades\DB;
use App\Services\Admin\PageService;
use \Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\Admin\PageHomepageService;
use App\Http\Requests\Admin\ClientStoreRequest;

class ClientController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //checks policy
        $this->authorize('list', Client::class);

        if ($request->ajax()) {

            $data = DB::select('select * from clients where deleted_at IS NULL');

            return DataTables::of($data)
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('subdomain', function($row){
                    return $row->subdomain;
                })
                ->addColumn('action', function($row){

                    if (Auth::guard('admin')->user()->hasAnyPermission('client-edit')) {
                        $actions = '<a href="'.route("admin.clients.edit", ["client" => $row->uuid]).'" class="edit mydir-dg btn mx-1"><i class="far fa-edit"></i></a>';
                    }

                    if (Auth::guard('admin')->user()->hasAnyPermission('client-suspend')) {

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

                        $actions .= '<button id="suspend_'.$row->uuid.'" class="'.$class.' mydir-dg btn mx-1" id="" data-id="'.$row->uuid.'">'.$label.'</button>';
                    }

                    if (Auth::guard('admin')->user()->hasAnyPermission('client-delete')) {
                        $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
                    }

                    if (Auth::guard('admin')->user()->hasAnyPermission('client-settings-edit')) {
                        $actions .= '<a href="'.route("admin.client-settings.edit", ["client" => $row->uuid]).'" class="edit mydir-dg btn mx-1"><i class="fas fa-sliders-h"></i></a>';
                    }

                    if (Auth::guard('admin')->user()->hasAnyPermission('institution-list')) {
                        $actions .= '<a href="'.route("admin.clients.institutions.index", ["client" => $row->uuid]).'" class="edit mydir-dg btn mx-1"><i class="fas fa-school"></i></a>';
                    }

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('admin.pages.clients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //checks policy
        $this->authorize('create', Client::class);

        $client = new Client;

        return view('admin.pages.clients.create', ['client' => $client]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\ClientStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreRequest $request)
    {
        $validatedData = $request->validated();

        if (app('clientService')->createClient($validatedData))
        {
            $returnType = "success";
            $returnMessage = "Client created successfully";
        } else {
            $returnType = "error";
            $returnMessage = "Your client could not be created!";
        }

        app('clientService')->createClientList(FALSE);

        return redirect()->route('admin.clients.index')->with($returnType, $returnMessage);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Client $client)
    {
        //check authoridation
        $this->authorize('update', $client);

        return view('admin.pages.clients.edit', ['client' => $client]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\ClientStoreRequest  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientStoreRequest $request, Client $client)
    {
        // Will return only validated data
        $validatedData = $request->validated();

        //updates the client
        $client->update($validatedData);

        app('clientService')->createClientList(FALSE);

        return redirect()->route('admin.clients.index')
                         ->with('success','Client updated successfully');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function editSettings(Request $request, Client $client)
    {
        //check authoridation
        $this->authorize('update', $client);

        return view('admin.pages.clients.settings', ['client' => $client]);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Admin\Client $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Client $client){

        //check policy authorisation
        $this->authorize('delete', $client);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $client_id = $client->id;
                $client->delete();

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your client has been successfully deleted!";

            } catch (\Exception $e) {

                Log::error($e);

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your client could not be not deleted. Try Again!";
            }

            return response()->json($data_return, 200);

        }
    }



    /**
     * Suspend the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Admin\Client $client
     * @return \Illuminate\Http\Response
     */
    public function suspend(Request $request, Client $client){

        //check policy authorisation
        $this->authorize('suspend', $client);

        if ($request->ajax())
        {

            DB::beginTransaction();

            try  {

                $client->suspended = 'Y';
                $client->save();

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your client has been successfully suspended!";

            } catch (\Exception $e) {

                Log::error($e);

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your client could not be not suspended. Try Again!";
            }

            return response()->json($data_return, 200);

        }
    }


    /**
     * Unsuspend the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Admin\Client $client
     * @return \Illuminate\Http\Response
     */
    public function unsuspend(Request $request, Client $client){

        //check policy authorisation
        $this->authorize('suspend', $client);

        if ($request->ajax())
        {

            DB::beginTransaction();

            try  {

                $client->suspended = 'N';
                $client->save();

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your client has successfully been unsuspended!";

            } catch (\Exception $e) {

                Log::error($e);

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your client could not be not unsuspended. Try Again!";
            }

            return response()->json($data_return, 200);

        }
    }

}
