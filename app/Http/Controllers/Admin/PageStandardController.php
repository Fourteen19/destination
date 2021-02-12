<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class PageStandardController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //check authoridation
        $this->authorize('list', Page::class);


         if (!$request->ajax()) {

             if (isGlobalAdmin()){

                //check if the route is global or client
                $contentOwner = (Route::is('admin.global*')) ? "Global" : Session::get('client')->name ;
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

            } elseif (isClientAdmin()){
                $contentOwner = Session::get('client')->name;

            } else {

            }


        //if AJAX request
        } else {

            $items = DB::table('pages')
            ->leftjoin('pages_live', 'pages.id', '=', 'pages_live.id')
            ->join('page_templates', 'pages.template_id', '=', 'page_templates.id')
            ->join('clients', 'clients.id', '=', 'pages.client_id')
            ->where('pages.deleted_at', NULL)
            ->orderBy('pages.updated_at','DESC')
            ->select(
                "pages.uuid",
                "pages.title",
                "pages.updated_at",
                "pages_live.id as live_id",
                "pages_live.updated_at as live_updated_at",
                "page_templates.slug",
                "page_templates.slug_plural"
            );


            if (isGlobalAdmin())
            {
                $items = $items->where('clients.uuid', '=', Session::get('adminClientSelectorSelection') );
            } elseif (isclientAdmin()) {
                $items = $items->where('pages.client_id', '=', Auth::guard('admin')->user()->client_id);
            }


            return DataTables::of($items)
                ->addColumn('name', function($row){
                    return $row->title;
                })
                ->addColumn('action', function($row){

                    $actions = "";

                    if (Auth::guard('admin')->user()->hasAnyPermission('page-edit') ){
                        $actions .= $row->slug;
//                        $actions .= '<a href="'.route("admin.pages.".$row->slug.".edit", [$row->slug => $row->uuid]).'" class="edit mydir-dg btn">Edit</a> ';
                    }

                    //if the user has the permission to make content live
                    if ( Auth::guard('admin')->user()->hasAnyPermission('page-make-live') )
                    {

                        //if the content is NOT live OR if both updated date are not the same
                        if ( (empty($row->live_id)) || ($row->updated_at != $row->live_updated_at) )
                        {
                            $class = "open-make-live-modal";
                            $label = "Make Live";

                        //elseif the content is live
                        } else {
                            $class = "open-remove-live-modal";
                            $label = "Remove from Live";
                        }
                        $actions .= '<button id="live_'.$row->uuid.'" class="'.$class.' open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">'.$label.'</button>';
                    }

                    //if the user has the permission to delete content
                    if ( Auth::guard('admin')->user()->hasAnyPermission('page-delete') )
                    {
                        $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Delete</button>';
                    }

                    return $actions;
                })

                ->rawColumns(['action'])
                ->make(true);

        }

        return view('admin.pages.pages.index', ['contentOwner' => $contentOwner ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.pages.standard.create');
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
        return view('admin.pages.pages.edit');
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
