<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use App\Models\Client;
use App\Models\Admin\Admin;
use App\Models\Institution;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\AdminStoreRequest;

class AdminController extends Controller
{

    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function index(Request $request)
    {




        /*
        $institution_id = 1;
        
        $items = Admin::with(['institutions, roles'])
        ->whereHas('institutions', function($query) use ($institution_id) {
            $query->where('institution_id', $institution_id);
        })
        ->get();
        */
    
    

/*
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
        */
        if ($request->ajax()) {

            
/*  
            $items = Admin::with(['institutions', 'roles'])
            ->whereHas('institutions', function($query) use ($institution_id) {
                $query->where('institutions.id', $institution_id);
            });
*/            
            $validation = $this->validate($request, [
                'institution' => 'present|uuid',
                'client' => 'present|uuid',
            ]);

            //if the loged in user is a client admin
            if (Session::get('adminAccessLevel') == 2){

                $validation['role'] = Rule::in([
                    config('global.admin_user_type.Client_Admin'), 
                    config('global.admin_user_type.Client_Content_Admin'), 
                    config('global.admin_user_type.Advisor'), 
                    config('global.admin_user_type.Third_Party_Admin'),
                    config('global.admin_user_type.System_Administrator'), 
                    config('global.admin_user_type.Global_Content_Admin')
                ]);

            } elseif (Session::get('adminAccessLevel') == 1){

                $validation['role'] = Rule::in([
                    config('global.admin_user_type.Client_Admin'), 
                    config('global.admin_user_type.Client_Content_Admin'), 
                    config('global.admin_user_type.Advisor'), 
                    config('global.admin_user_type.Third_Party_Admin')
                ]);

            }

            

            //dd($validation);



            //gets all admins with roles
            $items = Admin::with(['roles']);

            //if the role filter is selected
            if (request()->has('role')) {

                $role = $request->get('role');

                //user type 2
                //if the loged in user is a client admin
                if (Session::get('adminAccessLevel') == 2){
                    
                    $allowedRoles = [
                        config('global.admin_user_type.Client_Admin'), 
                        config('global.admin_user_type.Client_Content_Admin'), 
                        config('global.admin_user_type.Advisor'), 
                        config('global.admin_user_type.Third_Party_Admin')
                    ];

                //user type 3
                } elseif (Session::get('adminAccessLevel') == 3){
                    
                    $allowedRoles = [
                        config('global.admin_user_type.Client_Admin'), 
                        config('global.admin_user_type.Client_Content_Admin'), 
                        config('global.admin_user_type.Advisor'), 
                        config('global.admin_user_type.Third_Party_Admin'),
                        config('global.admin_user_type.System_Administrator'), 
                        config('global.admin_user_type.Global_Content_Admin')
                    ];

                }

                //if they can filter the role they selected depending on their permissions
                if (in_array($role, [
                    $allowedRoles 
                ] ))
                {
                    $items = $items->role($role);
                }
            

            //if the 'client' filter is set
            //OR if the logged in user is a Client admin
            if ( (request()->has('client')) || (Session::get('adminAccessLevel') == 2) ){

                $clientId = 0;

                //if the current user is a Client Admin 
                if (Session::get('adminAccessLevel') == 2) {

                    //we set the client ID sttically
                    $clientId = Session::get('client')->id;
                
                //else if the user is a Global Admin
                } elseif (!empty($request->get('client'))){

                    //get the client
                    $client = Client::where('uuid', '=', request('client'))->select('id')->first();

                    if ($client)
                    {
                        $clientId = $client->id;
                    }
                }


                if ($clientId)
                {

                    //filter by client
                    $items = $items->where('client_id', $client->id);
                        
                    //if the role selected is advisor, then further filtering can be done by institution
                    if (in_array($role, [
                        config('global.admin_user_type.Advisor'), 
                    ] ))
                    {
                        
                        if (request()->has('institution')) {
                            
                            if (!empty($request->get('institution'))){
                                
                                $institution_id = $request->get('institution');

                                //get the institution
                                $institution = Institution::where('uuid', '=', request('institution'))->select('id')->first();

                                if ($institution)
                                {

                                    $institution_id = $institution->id;

                                    $items = $items->with('institutions')
                                                ->whereHas('institutions', function($query) use ($institution_id) {
                                                    $query->where('institutions.id', $institution_id);
                                                });
                                }

                            }

                        }

                    }

                }

            }
        
        }
            /*
            $institution_id = 2;
            $items = Admin::with(['institutions', 'roles'])
            ->whereHas('institutions', function($query) use ($institution_id) {
                $query->where('institutions.id', $institution_id);
            });
            */
//            ->get();
            
            return DataTables::of($items)
                ->addColumn('name', function($row){
                    return $row->first_name." ".$row->last_name;
                })
                ->addColumn('email', function($row){
                    return $row->email;
                })
                ->addColumn('role', function ($row) {
                    return $row->roles->map(function($role) {
                        return $role->name;
                    })->implode('<br>');
                })
                ->addColumn('action', function($row){

                    $actions = '<a href="'.route("admin.admins.edit", ["admin" => $row->uuid]).'" class="edit mydir-dg btn">Edit</a> ';
                    $actions .= '<button class="open-delete-modal mydir-dg btn" data-id="'.$row->uuid.'">Delete</button>';

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
    /*
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Admin::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Admin::select('count(*) as allcount')->where('last_name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Admin::orderBy($columnName,$columnSortOrder)
        ->where('admins.last_name', 'like', '%' .$searchValue . '%')
        ->select('admins.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();

        foreach($records as $record){
            $uuid = $record->uuid;
            $name = $record->FullName;
            $email = $record->email;

            $actions = '<a href="'.route("admin.admins.edit", ["admin" => $record->uuid]).'" class="edit btn btn-primary btn-sm">Edit</a> ';
            $actions .= '<button class="open-delete-modal btn btn-danger" data-id="'.$record->uuid.'">Delete</button>';

            $data_arr[] = array(
                "uuid" => $uuid,
                "last_name" => $name,
                "email" => $email,
                "action" => $actions
            );
        }

        $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    */

        return view('admin.pages.admins.index');
    }






    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //checks policy
        $this->authorize('create', Admin::class);

        $admin = new Admin;

        return view('admin.pages.admins.create', ['admin' => $admin ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\AdminStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreRequest $request)
    {

        //checks policy
        $this->authorize('create', Admin::class);

        // Will return only validated data
        $validatedData = $request->validated();

        //if the password field was left empty
        if (empty($validatedData['password'])){
            unset($validatedData['password']);
            unset($validatedData['confirm_password']);
        } else {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        //creates the admin
        $user = Admin::create($validatedData);

        //checks who is creating the admin user
        //if system Admin
        if (Session::get('adminAccessLevel') == 3)
        {
            //get the client selected
            //returns an Eloquent object
            $client = Client::where('uuid', $validatedData['client'])->first();

        //if client admin
        } elseif (Session::get('adminAccessLevel') == 2){

            //gets the client Eloquent object from the session 
            //ENFORCES the client of the user logged in
            $client = $request->session()->get('client');
            
        }

        //gets the client id 
        $clientId = $client->id;

        $user->client_id = $clientId;

        //creates the association between the `admin` user and the `client` models
        $user->client()->associate($client);


        // if we create an advisor, save the institutions allocated to it
        if ($request->input('role') == "Advisor")
        {
            //init query to fetch institutions.
            //We are not fetching yet!! There is still scoping to add to the query
            $institutionsQuery = Institution::select('id')->whereIn('uuid', $validatedData['institutions']);

            //if the logged in user is a client (not global admin)
            if (Session::get('adminAccessLevel') == 2){

                //gets the institutions - flatten query results
                $institutionsQuery = $institutionsQuery->CanOnlySeeClientInstitutions($clientId);

            }

            //gets the institutions - flatten query results
            $institutions = Arr::flatten( $institutionsQuery->get()->toArray() );

            //syncs admin user and institutions
            $user->institutions()->sync($institutions);

        }

        //persists the association in the database!
        $user->save();

        //Assigns a role to the user
        $user->assignRole($request->input('role'));

        return redirect()->route('admin.admins.index')
            ->with('success','Administrator created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Admin $admin)
    {

        //check authoridation
        $this->authorize('update', $admin);
/*
        //Loads roles based on the administartor role
        if (Auth::guard('admin')->user()->hasRole('System Administrator')){
            $roles = Role::orderBy('name','asc')->pluck('name','name')->prepend(trans('ck_admin.pleaseSelect'), '')->all();
        } elseif (Auth::guard('admin')->user()->hasRole('Client Administrator')){
            $roles = Role::wherein('level', [1,2])->orderBy('name','asc')->pluck('name','name')->all();
        }

        return view('admin.pages.admins.edit', ['admin' => $admin, 'role' => $admin->getRoleNames(), 'roles' => $roles ]);
*/

        return view('admin.pages.admins.edit', ['admin' => $admin ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\AdminStoreRequest  $request
     * @param  \App\Models\Admin\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminStoreRequest $request, Admin $admin)
    {

        //checks policy
        $this->authorize('update', Admin::class);

        // Will return only validated data
        $validatedData = $request->validated();

        //if the password field was left empty
        if (empty($validatedData['password'])){
            unset($validatedData['password']);
            unset($validatedData['confirm_password']);
        } else {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        //updates the admin
        $save_result = $admin->update($validatedData);

        //if the admin is a "System Administrator" OR "Global Content Admin"
        //if ( ($validatedData['role'] == "System Administrator") || ($validatedData['role'] == "Global Content Admin") )
        //{
/*
        if (Session::get('adminAccessLevel') == 3)
        {
            // do nothing!!

        } else {

            //get the client selected
            //returns an Eloquent object
            $client = Client::where('uuid', $validatedData['client'])->first();

            //creates the association between the `admin` and the `client` models
            $admin->client()->associate($client);

        }
*/
        //checks who is creating the admin user
        //if system Admin
        if (Session::get('adminAccessLevel') == 3)
        {
            //get the client selected
            //returns an Eloquent object
            $client = Client::where('uuid', $validatedData['client'])->first();

        //if client admin
        } elseif (Session::get('adminAccessLevel') == 2){

            //gets the client Eloquent object from the session 
            //ENFORCES the client of the user logged in
            $client = $request->session()->get('client');
            
        }

        //gets the client id 
        $clientId = $client->id;

        $admin->client_id = $clientId;

        //persists the association in the database!
        $admin->save();

        // if we create an advisor, save the institutions allocated to it
        if ($request->input('role') == "Advisor")
        {
            //init query to fetch institutions.
            //We are not fetching yet!! There is still scoping to add to the query
            $institutionsQuery = Institution::select('id')->whereIn('uuid', $validatedData['institutions']);

            //if the logged in user is a client (not global admin)
            if (Session::get('adminAccessLevel') == 2){

                //gets the institutions - flatten query results
                $institutionsQuery = $institutionsQuery->CanOnlySeeClientInstitutions($clientId);

            }

            //gets the institutions - flatten query results
            $institutions = Arr::flatten( $institutionsQuery->get()->toArray() );

            //syncs admin user and institutions
            $admin->institutions()->sync($institutions);

        }

        //persists the association in the database!
        $admin->save();

        //Assigns a role to the user
        $admin->syncRoles($request->input('role'));

        return redirect()->route('admin.admins.index')
            ->with('success','Administrator updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Admin $admin){

        //check policy authorisation
        $this->authorize('delete', $admin);

        if ($request->ajax()) {

            $admin_id = $admin->id;
            $result = $admin->delete();
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
            /*
    //    $admin_name = $admin->full_name;

        //deletes the record
        if ($data->delete())
        {

            $status = "success";
            $flash_msg = 'ok 1';
            $log_msg = 'log 1';

        } else {

            $status = "error";
            $flash_msg = 'not ok 2';
            $log_msg = 'log 2';

        }

//        LogActivity::addToLog(__($log_msg, ['name' => $admin_name]), isset($log_status) ? $log_status : "info");

        //redirect
        //return redirect()->route('admin.admins.index')
        //                ->with($status, __($flash_msg, ['name' => $id]));

        */
    }
}
