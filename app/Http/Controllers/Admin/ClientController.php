<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Auth;
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

        if ($request->ajax()) {

            $data = DB::select('select * from clients');

            return DataTables::of($data)
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('subdomain', function($row){
                    return $row->subdomain;
                })
                ->addColumn('action', function($row){

                    $actions = '<a href="'.route("admin.clients.edit", ["client" => $row->uuid]).'" class="edit btn btn-primary btn-sm">Edit</a> ';
                    $actions .= '<button class="open-suspend-modal btn btn-danger" data-id="'.$row->uuid.'">Suspend</button>';
                    $actions .= '<button class="open-delete-modal btn btn-danger" data-id="'.$row->uuid.'">Delete</button>';
                    $actions .= '<a href="'.route("admin.clients.edit", ["client" => $row->uuid]).'" class="edit btn btn-primary btn-sm">Client Branding</a> ';
                    $actions .= '<a href="'.route("admin.clients.institutions.index", ["client" => $row->uuid]).'" class="edit btn btn-primary btn-sm">Manage Institutions</a>';

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

        //creates the admin
        $client = Client::create($validatedData);

        return redirect()->route('admin.clients.index')
                         ->with('success','Client created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Client $client)
    {
        //calls the Adminpolicy update function to check authoridation
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

        return redirect()->route('admin.clients.index')
                         ->with('success','Client updated successfully');
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

            $client_id = $client->id;
            $result = $client->delete();
            if ($result) {
                $data_return['result'] = true;
                $data_return['message'] = "Admin user successfully deleted!";
            } else {
                $data_return['result'] = false;
                $data_return['message'] = "Admin user could not be not deleted, Try Again!";
                $log_status = "error";
            }

            //Needs to be added to an observer
            Log::info($data_return['message'], ['user_id' => Auth::user()->id, 'admin_deleted' => $admin_id]);
            Log::error($data_return['message'], ['user_id' => Auth::user()->id, 'admin_deleted' => $admin_id]);
            //Log::addToLog(__( $data_return['message'], ['name' => $admin_name]), isset($log_status) ? $log_status : "info");

            return response()->json($data_return, 200);

        }
    }

}
