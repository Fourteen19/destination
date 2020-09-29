<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientStoreRequest;
use DB;
use DataTables;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreRequest $request)
    {
        $validatedData = $request->validated();

        //creates the admin
        $client = Client::create($validatedData);

        return redirect()->route('admin.clients.index')
                         ->with('success','clients created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientStoreRequest $request, Client $client)
    {
        // Will return only validated data
        $validatedData = $request->validated();

        //updates the client
        $client->update($validatedData);

        return redirect()->route('admin.clients.index')
                         ->with('success','client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
