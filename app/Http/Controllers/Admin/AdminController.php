<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\DataTables\Admin\AdminsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use DataTables;
use DB;
use Form;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     * 
     * @return void
     */
    public function __construct()
    {

        
        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 /*   public function index(Request $request, AdminsDataTable $dataTables)
    {

        if ($request->ajax()) {
            $users = Admin::select('*');
            return Datatables::of($users)->make(true);
         }   


        return view('admin.pages.admins.index');


        return $dataTables->render('admin.pages.admins.index');
    }
*/

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $users = DB::select('select * from admins where deleted_at IS NULL');

            return Datatables::of($data)
                ->addColumn('name', function($row){
                    return $row->first_name." ".$row->last_name;
                })
                ->addColumn('email', function($row){
                    return $row->email;
                })
                ->addColumn('action', function($row){

                    $actions = '<a href="'.route("admin.admins.edit", ["admin" => $row->id]).'" class="edit btn btn-primary btn-sm">Edit</a> ';
                    $actions .= '<button class="open-delete-modal btn btn-danger" data-id="'.$row->id.'">Delete</button>';

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
    public function destroy(Request $request, $id){
           
        //calls the Adminpolicy update function to check authoridation 
    //    $this->authorize('delete', $admin);



        if ($request->ajax()) {
            
            $data = Admin::findOrFail($id);

            if ($data->delete() == true){

                return response()->json([
                    'error' => false,
                    'id' => $data->id
                ], 200);

            } else {

                return response()->json([
                    'error' => true,
                    'id' => $data->id
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
