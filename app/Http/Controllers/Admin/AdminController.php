<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\DataTables\Admin\AdminsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use DataTables;
use DB;
use Form;
use App\Repositories\AdminRepositoryInterface;

class AdminController extends Controller
{

    private $adminRepository;

    /**
     * Create a new controller instance.
     * 
     * @return void
     */
    public function __construct(AdminRepositoryInterface $adminRepository)
    {

//        parent::__construct();

        $this->adminRepository = $adminRepository;

    }
    
 
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::select('select * from admins where deleted_at IS NULL');
//$this->adminRepository->all();
            return Datatables::of($data)
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
    public function edit(Admin $id)
    {
        dd($id);
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

            $data = $this->adminRepository->delete($admin->id);

            if ($data == true){

                return response()->json([
                    'error' => false,
                    'id' => $id
                ], 200);

            } else {

                return response()->json([
                    'error' => true,
                    'id' => $id
                ], 200);

            }

        } else {

            return false;

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
