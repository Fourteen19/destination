<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemTag;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\RouteTagStoreRequest;

class TagsRouteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //checks policy
        $this->authorize('list', SystemTag::class);

        if ($request->ajax()) {

            $data = SystemTag::where('type', 'route')->orderBy('order_column', 'ASC')->get();

            return DataTables::of($data)
                ->addColumn('#', function($row){
                    return '<i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i>';
                })
                ->setRowAttr([
                    'data-id' => function($row) {
                        return $row->id;
                    },
                ])
                ->setRowClass(function () {
                    return 'row-item';
                })
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('action', function($row){

                    $actions = "";

                    if (Auth::guard('admin')->user()->hasAnyPermission('tag-edit')){
                        $actions .= '<a href="'.route("admin.tags.routes.edit", ["route" => $row->id]).'" class="edit mydir-dg btn">Edit</a> ';

                        $live_buttton_txt = "";
                        if ($row->live == "Y")
                        {
                            $live_buttton_txt = "Make Not Live";
                        } else {
                            $live_buttton_txt = "Make Live";
                        }
                        $actions .= '<a href="#" class="edit mydir-dg btn">'.$live_buttton_txt.'</a> ';
                    }

                    if (Auth::guard('admin')->user()->hasAnyPermission('tag-delete')){
                        $actions .= '<button class="open-delete-modal mydir-dg btn" data-id="'.$row->id.'">Delete</button>';
                    }

                    return $actions;
                })
                ->rawColumns(['#', 'action'])
                ->make(true);

        }

        return view('admin.pages.tags.routes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //checks policy
        $this->authorize('create', SystemTag::class);

        $tag = new SystemTag;

        return view('admin.pages.tags.routes.create', ['tag' => $tag]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\RouteTagStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RouteTagStoreRequest $request)
    {

        //checks policy
        $this->authorize('create', SystemTag::class);

        DB::beginTransaction();

        try {

            $validatedData = $request->validated();

            $validatedData['type'] = 'route';

            //creates the tag
            $tag = SystemTag::create($validatedData);

            DB::commit();

            return redirect()->route('admin.tags.routes.index')
                         ->with('success', 'Your route tag has been created successfully');

        }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.tags.routes.index')
                            ->with('error', 'An error occured, your route tag could not be created');
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Models\SystemTag  $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SystemTag $route)
    {
        //checks policy
        $this->authorize('update', $route);

        return view('admin.pages.tags.routes.edit', ['tag' => $route]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\RouteTagStoreRequest  $request
     * @param  App\Models\SystemTag  $route
     * @return \Illuminate\Http\Response
     */
    public function update(RouteTagStoreRequest $request, SystemTag $route)
    {

        //checks policy
        $this->authorize('update', $route);

        DB::beginTransaction();

        try {

            // Will return only validated data
            $validatedData = $request->validated();

            $validatedData['type'] = 'route';

            //updates the tag
            $route->update($validatedData);

            DB::commit();

            return redirect()->route('admin.tags.routes.index')
                            ->with('success', 'Your route tag has been updated successfully');

        }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.tags.routes.index')
                            ->with('error', 'An error occured, your route tag could not be updated');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //calls the policy to check authoridation
//        $this->authorize('delete', $route);


    }


    /**
     * reorder
     * Reorder the records
     * Updates the records based on the 'page' and the number of 'entries' in the manage page
     *
     * @param  mixed $request
     * @return void
     */
    public function reorder(Request $request)
    {

        //check authoridation
        $this->authorize('update', SystemTag::class);

        // "page" is the page number
        // "entries" is the number of records per page
        if ( (!empty($request->input('entries'))) && ($request->has('page')) )
        {

            DB::beginTransaction();

            try {

                $page_nb = $request->input('page');
                $nb_entries = $request->input('entries');

                foreach($request->input('order', []) as $row)
                {
                    SystemTag::find($row['id'])->update([
                        'order_column' => $row['position'] + ($page_nb * $nb_entries)
                    ]);
                }

                DB::commit();

            }
            catch (\Exception $e) {

                DB::rollback();

            }

        }

        return response()->noContent();

    }

}
