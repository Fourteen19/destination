<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Employer;
use App\Models\Admin\Admin;
use App\Models\Institution;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use \Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\UserService;
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
        //
    }


    public function index(Request $request)
    {
        //checks policy
        $this->authorize('list', Admin::class);

 /*        $items = Admin::select('id', 'first_name', 'last_name', 'uuid', 'email', 'employer_id')->with('employer')->get();
        //$items = Admin::find(23)->with('employer')->first();
        dd($items);
        return $items->employer->name;
        $comment = Admin::find(23);

        return $comment->employer->name; */


/*         dd($items->client);

        dd($items); */


        if ($request->ajax()) {

            $validationRules = [
                'institution' => 'sometimes|nullable|uuid',
                //'search' => 'sometimes|nullable|alpha'  //The field under validation must be entirely alphabetic characters.
            ];

            //if the loged in user is a global admin
            if (isGlobalAdmin()){

                $validationRules['role'] = 'sometimes|nullable|'.Rule::in([
                    config('global.admin_user_type.Client_Admin'),
                    config('global.admin_user_type.Client_Content_Admin'),
                    config('global.admin_user_type.Advisor'),
                    config('global.admin_user_type.Teacher'),
                    config('global.admin_user_type.Third_Party_Admin'),
                    config('global.admin_user_type.System_Administrator'),
                    config('global.admin_user_type.Global_Content_Admin'),
                    config('global.admin_user_type.Employer'),
                ]);

            //if the loged in user is a client admin
            } elseif (isClientAdmin()){

                $validationRules['role'] = 'sometimes|nullable|'.Rule::in([
                    config('global.admin_user_type.Client_Admin'),
                    config('global.admin_user_type.Client_Content_Admin'),
                    config('global.admin_user_type.Advisor'),
                    config('global.admin_user_type.Teacher'),
                    config('global.admin_user_type.Third_Party_Admin'),
                ]);

            }

            //filtered data
            $validatedData = $this->validate($request, $validationRules);



            //gets all admins with roles
            //The ID column MUST be added for the relationships to work
            $items = Admin::select('id', 'first_name', 'last_name', 'uuid', 'email')->with('roles:name')->with('employer');



            $role = False;

            //if the role filter is selected. "Any type" does not satisfy the condition
            if (array_key_exists('role', $validatedData)) {

                $role = $validatedData['role'];

                //if the loged in user is a client admin
                if (isClientAdmin()){

                    $allowedRoles = [
                        config('global.admin_user_type.Client_Admin'),
                        config('global.admin_user_type.Client_Content_Admin'),
                        config('global.admin_user_type.Advisor'),
                        config('global.admin_user_type.Teacher'),
                        config('global.admin_user_type.Third_Party_Admin'),
                    ];

                //if the loged in user is a system admin
                } elseif (isGlobalAdmin()){

                    $allowedRoles = [
                        config('global.admin_user_type.Client_Admin'),
                        config('global.admin_user_type.Client_Content_Admin'),
                        config('global.admin_user_type.Advisor'),
                        config('global.admin_user_type.Teacher'),
                        config('global.admin_user_type.Third_Party_Admin'),
                        config('global.admin_user_type.System_Administrator'),
                        config('global.admin_user_type.Global_Content_Admin'),
                        config('global.admin_user_type.Employer')
                    ];

                }

                //if they can filter the role they selected depending on their permissions
                if (!in_array($role, $allowedRoles ))
                {
                    $role = "";
                }

            }




            $clientId = Session::get('adminClientSelectorSelected');
            $institutionId = False;
            $getEmployers = False;

            if ($clientId)
            {

                //if the role selected is advisor, client content admin or client admin, then further filtering can be done by institution
                if (in_array($role, [
                    config('global.admin_user_type.Advisor'), config('global.admin_user_type.Teacher'), config('global.admin_user_type.Client_Content_Admin'), config('global.admin_user_type.Client_Admin'), NULL
                ] ))
                {

                    if (isset($validatedData['institution']))
                    {
                        if (!empty($validatedData['institution']))
                        {

                            //get the institution
                            $institution = Institution::where('uuid', '=', $validatedData['institution'])->select('id');

                            //if the logged in user is a client admin, check the institution belongs to the same client as the admin's
                            if (isClientAdmin()){
                                $institution = $institution->CanOnlySeeClientInstitutions(Auth::guard('admin')->user()->client_id);
                            }

                            $institution = $institution->first();
                            if ($institution)
                            {
                                $institutionId = $institution->id;
                            }
                        }
                    }

                //if the role selected is global sys admin of global content sys admin, then further filtering can be done by institution
                } elseif (in_array($role, [
                    config('global.admin_user_type.System_Administrator'),
                    config('global.admin_user_type.Global_Content_Admin'),
                ] )){

                    //if (empty($validatedData['institution'])){
                        $clientId = NULL;
                    //}

                }

            //if no clientId is required
            } else {


                if (in_array($role, [
                    config('global.admin_user_type.Employer')
                ] ))
                {
                    $getEmployers = True;
                }

            }






            //compiles the query
            $items = Admin::select('id', 'first_name', 'last_name', 'uuid', 'email', 'employer_id')
                ->when($role, function ($query, $role) {
                    return $query->role($role);
                })
                ->when($clientId, function ($query, $clientId) use ($role){
                    if ($role == config('global.admin_user_type.Employer'))
                    {
                        return $query->where('client_id', NULL);
                    } else {
                        return $query->where('client_id', $clientId);
                    }
                })
                ->when($institutionId, function ($query, $institutionId) {
                    return $query->with('institutions')
                                ->whereHas('institutions', function($query) use ($institutionId) {
                                    $query->where('institutions.id', $institutionId);
                                });
                })
                ->when($getEmployers, function ($query, $getEmployers) {
                    if ($getEmployers)
                    {
                        return $query->with('employer:id,name');
                    }
                })
                ->with('roles:name')
                ->orderBy('updated_at', 'DESC');

//dd($items->toSql());


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
                ->addColumn('institutions', function ($row) {

                    $role = $row->getRoleNames()->first();
                    if (in_array($role, [
                        config('global.admin_user_type.Advisor'),
                        config('global.admin_user_type.Teacher')
                    ] ))
                    {

                        $list = [];
                        foreach($row->institutions as $institution){
                            $list[] = $institution->name;
                        }
                        return implode("<br>" ,$list);

                    } elseif (in_array($role, [
                        config('global.admin_user_type.Client_Content_Admin'),
                        config('global.admin_user_type.Client_Admin'),
                        config('global.admin_user_type.System_Administrator'),
                        config('global.admin_user_type.Global_Content_Admin'),
                    ] ))
                    {
                        return "All";
                    } elseif (in_array($role, [config('global.admin_user_type.Employer'),] ))
                    {
                        return "";
                        if ($row->employer->name)
                        {
                            return $row->employer->name;
                        }
                    } else {
                        return "";
                    }

                })
                ->addColumn('action', function($row){

                    if (Auth::guard('admin')->user()->hasAnyPermission('admin-edit')) {
                        $actions = '<a href="'.route("admin.admins.edit", ["admin" => $row->uuid]).'" class="edit mydir-dg btn"><i class="far fa-edit"></i></a> ';
                    }

                    if (Auth::guard('admin')->user()->hasAnyPermission('admin-delete')) {
                        $actions .= '<button class="open-delete-modal mydir-dg btn" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
                    }

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
                ->rawColumns(['action', 'institutions'])
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
                $passwordForUser = $validatedData['password'];
                $validatedData['password'] = Hash::make($validatedData['password']);
            }



            //creates the admin
            $user = Admin::create($validatedData);

            //checks who is creating the admin user
            //if system Admin
            if (isGlobalAdmin())
            {

                if (isset($validatedData['client']))
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
            //if ($request->input('role') == "Advisor")
            if (in_array($request->input('role'), [ config('global.admin_user_type.Advisor'),
                                                    config('global.admin_user_type.Teacher') ]) )
            {

                if (isset($validatedData['institutions']))
                {

                    if (!empty($validatedData['institutions']))
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

                }

            } else {
                $user->contact_me = 'N';
            }



            if (in_array($request->input('role'), [ config('global.admin_user_type.Employer'), ]) )
            {

                if (isset($validatedData['employer']))
                {

                    if (!empty($validatedData['employer']))
                    {

                        $employer = Employer::select('id')->where('uuid', '=', $validatedData['employer'])->first();
                        $user->employer_id = $employer->id;
                    }

                }

            }

            //persists the association in the database!
            $user->save();

            //Assigns a role to the user
            $user->assignRole($request->input('role'));


            $user->action = 'create';

            //$user->school_year = 12;
            $user->password = $passwordForUser;

            //creates a user to access the frontend
            $this->userService = new UserService();
            $adminUser = $this->userService->storeAdminAsUser($user->id, $passwordForUser);
            $this->userService->createBlankAssessmentForAdmin($adminUser);


            DB::commit();

            return redirect()->route('admin.admins.index')
                ->with('success','Your Administrator has been created successfully');


        } catch (\Exception $e) {

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

        //checks policy
        $this->authorize('update', $admin);

        DB::beginTransaction();

        try {

            // Will return only validated data
            $validatedData = $request->validated();

            //if the password field was left empty
            if (empty($validatedData['password'])){
                unset($validatedData['password']);
                unset($validatedData['confirm_password']);
            } else {
                $passwordForUser = $validatedData['password'];
                $validatedData['password'] = Hash::make($validatedData['password']);
            }

            $validatedData['contact_me'] = isset($validatedData['contact_me']) ? '1' : '0';


            //updates the admin
            $save_result = $admin->update($validatedData);

            //checks who is creating the admin user
            //if system Admin
            if (isGlobalAdmin())
            {

                $client = NULL;
                $clientId = NULL;

                if (isset($validatedData['client']))
                {

                    //if a client has been selected
                    if ($validatedData['client'])
                    {

                        //get the client selected
                        //returns an Eloquent object
                        $client = Client::select('id')->where('uuid', $validatedData['client'])->first();

                        //gets the client id
                        $clientId = $client->id;

                    }

                }

            //if client admin
            } elseif (isClientAdmin()){

                //gets the client Eloquent object from the session
                //ENFORCES the client of the user logged in
                $clientId = Session::get('adminClientSelectorSelected');

            }

            $admin->client_id = $clientId;

            //persists the association in the database!
            $admin->save();

            // if we create an advisor, save the institutions allocated to it
            if (in_array($request->input('role'), [ config('global.admin_user_type.Advisor'),
                                                    config('global.admin_user_type.Teacher') ]) )
            {

                $clearInstitutions = False;

                if (isset($validatedData['institutions']))
                {

                    if (!empty($validatedData['institutions']))
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

                    } else {
                        $clearInstitutions = True;
                    }

                } else {
                    $clearInstitutions = True;
                }


                //if we need to reset the institutions to nothing, no institution selected
                if ($clearInstitutions == True)
                {
                    //syncs admin user and institutions
                    $admin->institutions()->sync([]);
                }


            } else {
                $admin->contact_me = 'N';
            }


            // if we create an advisor, save the institutions allocated to it
            if (in_array($validatedData['role'], [ config('global.admin_user_type.Employer') ]) )
            {
                $employer = Employer::select('id')->where('uuid', $validatedData['employer'])->first();
                if ($employer)
                {
                    $admin->employer_id = $employer['id'];
                } else {
                    $admin->employer_id = NULL;
                }
            } else {
                $admin->employer_id = NULL;
            }


            //persists the association in the database!
            $admin->save();

            //Assigns a role to the user
            $admin->syncRoles($request->input('role'));


            //creates a user to access the frontend
            $this->userService = new UserService();
            $this->userService->updateAdminAsUser($admin->id, (!empty($passwordForUser)) ? $passwordForUser : NULL);


            DB::commit();

            return redirect()->route('admin.admins.index')
                ->with('success','Your administrator has been updated successfully');


        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.admins.index')
                            ->with('error', 'An error occured, your administrator could not be updated');
        }


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

            try  {

                $admin_id = $admin->id;

                $admin->delete();

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Admin user successfully deleted!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Admin user could not be deleted, Try Again!";
            }

            return response()->json($data_return, 200);

        }

    }

}
