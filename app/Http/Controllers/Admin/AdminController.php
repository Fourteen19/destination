<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Admin\Admin;
use App\Models\Institution;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use \Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use \Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
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


        //checks policy
        $this->authorize('list', Admin::class);



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

//dd($request);


            $validationRules = [
                'institution' => 'sometimes|nullable|uuid',
                //'search' => 'sometimes|nullable|alpha'  //The field under validation must be entirely alphabetic characters.
            ];

            //if the loged in user is a client admin
            if (isGlobalAdmin()){

                $validationRules['role'] = 'sometimes|nullable|'.Rule::in([
                    config('global.admin_user_type.Client_Admin'),
                    config('global.admin_user_type.Client_Content_Admin'),
                    config('global.admin_user_type.Advisor'),
                    config('global.admin_user_type.Third_Party_Admin'),
                    config('global.admin_user_type.System_Administrator'),
                    config('global.admin_user_type.Global_Content_Admin')
                ]);

            } elseif (isClientAdmin()){

                $validationRules['role'] = 'sometimes|nullable|'.Rule::in([
                    config('global.admin_user_type.Client_Admin'),
                    config('global.admin_user_type.Client_Content_Admin'),
                    config('global.admin_user_type.Advisor'),
                    config('global.admin_user_type.Third_Party_Admin')
                ]);

            }

            $validatedData = $this->validate($request, $validationRules);




            //gets all admins with roles
            //The ID column MUST be added for the relationships to work
            $items = Admin::select('id', 'first_name', 'last_name', 'uuid', 'email')->with('roles:name');

            $role = False;

            //if the role filter is selected
            if (isset($validatedData['role'])) {

                $role = $validatedData['role'];

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
                if (!in_array($role, $allowedRoles ))
                {
                    //$items = $items->role($role);
                    $role = "";
                }

            }


            ///$clientId = False; (isset($validatedData['client'])) ||
            //$institutionId = False;
            //$institution = $validatedData['institution'];

            //if the 'client' filter is set, OR if the logged in user is a Client admin
            //AND we are looking a Global admin


            /* if ( ( (Session::get('adminAccessLevel') == 2) ) && ( !in_array($role, [config('global.admin_user_type.System_Administrator'),
            config('global.admin_user_type.Global_Content_Admin') ])) ){
 */


            $clientId = Session::get('adminClientSelectorSelected');
            $institutionId = False;
 /*
            if (isClientAdmin())
            {

                //if the current user is a Client Admin
                if (Session::get('adminAccessLevel') == 2) {

                    //we set the client ID statically
                    $clientId = Session::get('client')['id'];

                } else {




                //else if the user is a Global Admin
                } elseif (!empty($validatedData['client'])){

                    //get the client
                    $client = Client::where('uuid', '=', $validatedData['client'])->select('id')->first();

                    if ($client)
                    {
                        $clientId = $client->id;
                    }
                }
*/

                if ($clientId)
                {

                    //filter by client
                    //$items = $items->where('client_id', $client->id);

                    //if the role selected is advisor, then further filtering can be done by institution
                    if (in_array($role, [
                        config('global.admin_user_type.Advisor'),
                    ] ))
                    {

                        if (isset($validatedData['institution']))
                        {

                            if (!empty($validatedData['institution']))
                            {


                                //get the institution
                                $institution = Institution::where('uuid', '=', $validatedData['institution'])->select('id')->first();
//dd($institution);
                                if ($institution)
                                {

                                    $institutionId = $institution->id;
/*
                                    $items = $items->with('institutions')
                                                ->whereHas('institutions', function($query) use ($institutionId) {
                                                    $query->where('institutions.id', $institutionId);
                                                });
                                                */
                                }

                            }

                        }

                    } elseif (in_array($role, [
                        config('global.admin_user_type.System_Administrator'),
                        config('global.admin_user_type.Global_Content_Admin'),
                    ] )){

                        if (empty($validatedData['institution'])){
                            $clientId = NULL;
                        }

                    }

                }

//            }






//dd($institutionId);

            //compiles the query
            $items = Admin::select('id', 'first_name', 'last_name', 'uuid', 'email')
                ->when($role, function ($query, $role) {
                    return $query->role($role);
                })
                ->when($clientId, function ($query, $clientId) {
                    return $query->where('client_id', $clientId);
                })
                ->when($institutionId, function ($query, $institutionId) {
                    return $query->with('institutions')
                                ->whereHas('institutions', function($query) use ($institutionId) {
                                    $query->where('institutions.id', $institutionId);
                                });
                })
                ->with('roles:name');




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
                ->filter(function ($query){

                    if (request()->has('search.value')) {
                        if (!empty(request('search.value'))){
                            $query->where(function($query) {
                                $query->where('admins.first_name', 'LIKE', "%" . request('search.value') . "%");
                                $query->orWhere( 'admins.last_name' , 'LIKE' , '%' . request('search.value') . '%');
                            });
                        }
                    }

                })
                ->rawColumns(['action'])
                ->make(true);

        }

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

        return view('admin.pages.admins.create', ['admin' => $admin, 'display_page_loader' => 1 ]);
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

        DB::beginTransaction();

        try {

            // Will return only validated data
            $validatedData = $request->validated();

            //if the user we want to create is a system global admin OR a Global content admin
            if (in_array($request->input('role'), [config('global.admin_user_type.System_Administrator'), config('global.admin_user_type.Global_Content_Admin')]) )
            {
                $validatedData['client'] = NULL;
            }

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
            if (isGlobalAdmin())
            {

                if ($validatedData['client'])
                {

                    //get the client selected
                    //returns an Eloquent object
                    $client = Client::select('id')->where('uuid', $validatedData['client'])->first();

                    //gets the client id
                    $clientId = $client->id;

                } else {

                    $client = NULL;
                    $clientId = NULL;

                }

            //if client admin
            } elseif (isClientAdmin()){

                $client = Client::select('id')->where('uuid', '=', $request->session()->get('adminClientSelectorSelection'))->first();

                //ENFORCES the client of the user logged in
                $clientId = $request->session()->get('adminClientSelectorSelected');

            }

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

            DB::commit();

            return redirect()->route('admin.admins.index')
                ->with('success','Your Administrator has been created successfully');


        }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.admins.index')
                            ->with('error', 'An error occured, your administrator could not be created');
        }


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

//dd($request);

        //checks policy
        $this->authorize('update', $admin);

     /*    DB::beginTransaction();

        try { */

            // Will return only validated data
            $validatedData = $request->validated();

            //if the password field was left empty
            if (empty($validatedData['password'])){
                unset($validatedData['password']);
                unset($validatedData['confirm_password']);
            } else {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }

            $validatedData['contact_me'] = isset($validatedData['contact_me']) ? '1' : '0';


            //updates the admin
            $save_result = $admin->update($validatedData);

            //checks who is creating the admin user
            //if system Admin
            if (isGlobalAdmin())
            {
                //get the client selected
                //returns an Eloquent object
                $client = Client::where('uuid', $validatedData['client'])->first();

            //if client admin
            } elseif (isClientAdmin()){

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

            DB::commit();

            return redirect()->route('admin.admins.index')
                ->with('success','Your administrator has been updated successfully');


        /* }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.admins.index')
                            ->with('error', 'An error occured, your administrator could not be updated');
        } */


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

            DB::beginTransaction();

            try {

                $admin_id = $admin->id;

                $result = $admin->delete();

                //if ($result) {
                    $data_return['result'] = true;
                    $data_return['message'] = "Admin user successfully deleted!";
             /*   } else {
                    $data_return['result'] = false;
                    $data_return['message'] = "Admin user could not be not deleted, Try Again!";
                    $log_status = "error";
                }
*/
                //Needs to be added to an observer
                Log::info($data_return['message'], ['user_id' => Auth::user()->id, 'admin_deleted' => $admin_id]);
                Log::error($data_return['message'], ['user_id' => Auth::user()->id, 'admin_deleted' => $admin_id]);
                //Log::addToLog(__( $data_return['message'], ['name' => $admin_name]), isset($log_status) ? $log_status : "info");

            }
            catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Admin user could not be not deleted, Try Again!";
            }

            return response()->json($data_return, 200);

        }

    }

}
