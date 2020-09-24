<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Institution;
use App\Models\User;
use DataTables;
use DB;
use Form;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Client $client, Institution $institution)
    {

        //current client
        $clientUuid = $client->uuid;

        //current institution
        $institutionUuid = $institution->uuid;

        if ($request->ajax()) {

//            $data = DB::select('select first_name, last_name, email, uuid from users where deleted_at IS NULL');
            
            $data = DB::table('users')
                        ->select('id', 'first_name', 'last_name', 'email', 'uuid')
                        ->where('deleted_at', '=', NULL)
                        ->where('institution_id', '=', $institution->id)
                        ->get();
            

            return DataTables::of($data)
                ->addColumn('name', function($row){
                    return $row->first_name." ".$row->last_name;
                })
                ->addColumn('email', function($row){
                    return $row->email;
                })
                ->addColumn('action', function($row) use ($clientUuid, $institutionUuid){

                    $actions = '<a href="'.route("admin.clients.institutions.users.edit", ["client" => $clientUuid, "institution" => $institutionUuid, "user" => $row->uuid]).'" class="edit btn btn-primary btn-sm">Edit</a> ';
                    $actions .= '<button class="open-delete-modal btn btn-danger" data-id="'.$row->uuid.'">Delete</button>';

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
      
        return view('admin.pages.users.index', ['client'=>$client, 'institution'=>$institution]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
