<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Client;
use App\Models\Role;
use DataTables;
use Illuminate\Support\Facades\DB;
//use App\Repositories\AdminRepositoryInterface;

class AdminController extends Controller
{

    private $adminRepository;

    /**
     * Create a new controller instance.
     * 
     * @return void
     */
    public function __construct()
    {
        //AdminRepositoryInterface $adminRepository

//        parent::__construct();

        //$this->adminRepository = $adminRepository;

    }
    
 
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = DB::select('select first_name, last_name, email, uuid from admins where deleted_at IS NULL');

//$this->adminRepository->all();
            return DataTables::of($data)
                ->addColumn('name', function($row){
                    return $row->first_name." ".$row->last_name;
                })
                ->addColumn('email', function($row){
                    return $row->email;
                })
                ->addColumn('action', function($row){

                    $actions = '<a href="'.route("admin.admins.edit", ["admin" => $row->uuid]).'" class="edit btn btn-primary btn-sm">Edit</a> ';
                    $actions .= '<button class="open-delete-modal btn btn-danger" data-id="'.$row->uuid.'">Delete</button>';

                    return $actions;
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

        if (\Auth::guard('admin')->user()->hasRole('System Administrator')){
            $roles = Role::orderBy('name','asc')->pluck('name','name')->prepend(trans('ck_admin.pleaseSelect'), '')->all();
        } elseif (\Auth::guard('admin')->user()->hasRole('Client Administrator')){
            $roles = Role::wherein('level', [1,2])->orderBy('name','asc')->pluck('name','name')->all();
        }
      
        return view('admin.pages.admins.create', ['admin' => $admin,'roles' => $roles ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //checks policy
        $this->authorize('create', Admin::class);
        
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|same:confirm-password',
            'role' => 'required'
            ]);

        $input = $request->all();

        $input['password'] = \Hash::make($input['password']);
        
dd($request);

        //creates the admin
        $user = Admin::create($input);

        //if the admin is a "System Administrator" OR "Global Content Admin"
        if ( ($request->input('role') == "System Administrator") || ($request->input('role') == "Global Content Admin") )
        {
            // do nothing!!
        } else {

            //get the client selected
            //returns an Eloquent object
            $client = \App\Models\Client::where('uuid', $request->input('client'))->firstOrFail();
        
        }
        
        //creates the association betwee the 2 models
        $user->client()->associate($client);


        //if we create an advisor, save the institutions allocated to it
        if ($request->input('role') == "Advisor")
        {
            $user->institution()->sync([
                $request->input('institution')
            ]);
        }

        //persists the association in the database!
        $user->save();

        

        //Assigns a role to the user
        $user->assignRole($request->input('role'));

        return redirect()->route('admin.admins.index')
            ->with('success','Administrator created successfully');
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
    public function edit(Admin $id)
    {
        
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
    public function destroy(Request $request, Admin $admin){
           
        //calls the Adminpolicy update function to check authoridation 
        //$this->authorize('delete', $admin);

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
            Log::addToLog(__( $data_return['message'], ['name' => $admin_name]), isset($log_status) ? $log_status : "info");  

            return response()->json(data_return, 200);

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
