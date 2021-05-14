<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vacancy;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //check authoridation
        $this->authorize('list', Vacancy::class);

        if (!$request->ajax()) {

            if (isGlobalAdmin()){

                //check if the route is global or client
                $contentOwner = (Route::is('admin.global*')) ? "Global" : Session::get('client')['name'] ;
                if (Route::is('admin.global*')){
                    $contentOwner = "Global";
                } else {

                    //determine if present in the session and is not null
                    if ( Session::has('adminClientSelectorSelection') )
                    {
                        $contentOwner = Session::get('all_clients')[ Session::get('adminClientSelectorSelection') ];
                    } else {
                        $contentOwner = "Undefined";
                    }

                }

            } else {
                $contentOwner = Session::get('adminClientName');

            }


        //if AJAX request
         } else {

            //compiles the query
            $items = Vacancy::select('id', 'uuid', 'title')
                            ->orderBy('updated_at', 'DESC');




            return DataTables::of($items)
            ->addColumn('title', function($row){
                return $row->title;
            })
            ->addColumn('employer', function($row){
                return $row->employer_name;
            })
            ->addColumn('client', function($row){
                return "[CLIENT]";
            })
            ->addColumn('action', function($row){

                $actions = "";

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-edit') ){
                    $actions = '<a href="'.route("admin.contents.".$row->slug_plural.".edit", [$row->slug => $row->uuid]).'" class="edit mydir-dg btn">Edit</a> ';
                }


                if ( (Auth::guard('admin')->user()->hasAnyPermission('vacancy-make-live') ) && (empty($row->live_id)) || ( (!empty($row->live_id) && (!empty($row->deleted_at_live)) ) ) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-make-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Make Live</button>';
                } elseif ( (Auth::guard('admin')->user()->hasAnyPermission('vacancy-make-live') ) && (!empty($row->live_id)) && ($row->updated_at != $row->live_updated_at) && (empty($row->deleted_at_live)) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-apply-latest-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Apply latest changes to Live</button>';
                }

                if ( (Auth::guard('admin')->user()->hasAnyPermission('vacancy-make-live') ) && (!empty($row->live_id)) && (empty($row->deleted_at_live)) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-remove-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Remove from Live</button>';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-delete') ){
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Delete</button>';
                }

                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);

        }

        return view('admin.pages.vacancies.index', ['contentOwner' => $contentOwner ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.vacancies.create');
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
        return view('admin.pages.vacancies.edit');
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
