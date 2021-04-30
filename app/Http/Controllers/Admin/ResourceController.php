<?php

namespace App\Http\Controllers\Admin;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \Yajra\DataTables\DataTables;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //check authoridation
        $this->authorize('list', Resource::class);

        if (!$request->ajax()) {

            $contentOwner = app('clientService')->getClientNameForAdminPages();

        //if AJAX request
        } else {

            $items = DB::table('resources')
            ->where('resources.deleted_at', NULL)
            ->orderBy('resources.name','ASC')
            ->select(
                "resources.uuid",
                "resources.name",
                "resources.description",
            );




            return DataTables::of($items)
            ->addColumn('name', function($row){
                return $row->name;
            })
            ->addColumn('description', function($row){
                return $row->description;
            })
            ->addColumn('link', function($row){
                return "link";
            })
            ->addColumn('client', function($row){
            //    return $row->clients->map(function($client) {
            //        return $client->name;
            //    })->implode('<br>');
                return "";
            })
            ->addColumn('action', function($row){

                $actions = "";

                if (Auth::guard('admin')->user()->hasAnyPermission('resource-edit')) {
                    $actions = '<a href="'.route("admin.resources.edit", ['resource' => $row->uuid]).'" class="edit mydir-dg btn">Edit</a> ';
                }

                //if the user has the permission to delete content
                if (Auth::guard('admin')->user()->hasAnyPermission('resource-delete'))
                {
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Delete</button>';
                }

                return $actions;
            })
            ->filter(function ($query){

                if (request()->has('search.value')) {
                    if (!empty(request('search.value'))){
                        $query->where('resources.name', 'LIKE', "%" . request('search.value') . "%");
                    }
                }

            })
            ->rawColumns(['action'])
            ->make(true);

        }

        return view('admin.pages.resources.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.resources.create');
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
        return view('admin.pages.resources.edit');
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
