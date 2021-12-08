<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\EmployerService;
use Illuminate\Support\Facades\Session;


class EmployerController extends Controller
{

    private $employerService;

    public function __construct(EmployerService $employerService)
    {

        $this->employerService = $employerService;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //check authoridation
        $this->authorize('list', Employer::class);

        if (!$request->ajax()) {


        //if AJAX request
         } else {

            $clientId = Session::get('adminClientSelectorSelected');

            //compiles the query
            $items = Employer::select('id', 'uuid', 'name')
                            //->where('client_id', Session::get('adminClientSelectorSelected'))
                            ->orderBy('updated_at', 'DESC');

            return DataTables::of($items)
            ->addColumn('name', function($row){
                return $row->name;
            })
            ->addColumn('action', function($row){

                $actions = "";

                if (Auth::guard('admin')->user()->hasAnyPermission('employer-edit') ){
                    $actions = '<a href="'.route("admin.employers.edit", ['employer' => $row->uuid]).'" class="edit mydir-dg btn"><i class="fas fa-edit"></i></a> ';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('employer-delete') ){
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
                }

                return $actions;
            })
            ->filter(function ($query){

                if (request()->has('search.value')) {
                    if (!empty(request('search.value'))){
                        $query->where('employers.name', 'LIKE', "%" . request('search.value') . "%");
                    }
                }

            })
            ->rawColumns(['action'])
            ->make(true);

        }

        return view('admin.pages.employers.index', ['contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //check authoridation
        $this->authorize('create', Employer::class);

        $employer = new Employer;

        return view('admin.pages.employers.create', ['employer' => $employer,]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Employer $employer
     * @return \Illuminate\Http\Response
     */
    public function edit(Employer $employer)
    {

        //check authoridation
        $this->authorize('update', $employer);

        return view('admin.pages.employers.edit', ['employer' => $employer ]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed $resource
     * @return void
     */
    public function destroy(Request $request, Employer $employer, EmployerService $employerService)
    {
        //check policy authorisation
        $this->authorize('delete', $employer);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $employerId = $employer->id;

                $result = $employerService->delete($employer);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Employer successfully deleted!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Employer could not be not deleted, Try Again!";

            }

            return response()->json($data_return, 200);

        }
    }

}
