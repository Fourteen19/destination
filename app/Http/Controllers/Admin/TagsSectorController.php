<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemTag;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SectorTagStoreRequest;

class TagsSectorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = SystemTag::where('type', 'sector')->orderBy('order_column', 'ASC')->get();

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

                    $actions = '<a href="'.route("admin.tags.sectors.edit", ["sector" => $row->id]).'" class="edit mydir-dg btn">Edit</a> ';

                    $live_buttton_txt = "";
                    if ($row->live == "Y")
                    {
                        $live_buttton_txt = "Make Not Live";
                    } else {
                        $live_buttton_txt = "Make Live";
                    }
                    $actions .= '<a href="#" class="edit mydir-dg btn">'.$live_buttton_txt.'</a> ';

                    $actions .= '<button class="open-delete-modal mydir-dg btn" data-id="'.$row->id.'">Delete</button>';


                    return $actions;
                })
                ->rawColumns(['#', 'action'])
                ->make(true);

        }

        return view('admin.pages.tags.sectors.index');
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

        return view('admin.pages.tags.sectors.create', ['tag' => $tag]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\SectorTagStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectorTagStoreRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['type'] = 'sector';

        //creates the tag
        $tag = SystemTag::create($validatedData);

        return redirect()->route('admin.tags.sectors.index')
                         ->with('success','Sector tag created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Models\SystemTag  $sector
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SystemTag $sector)
    {
        //calls the Adminpolicy update function to check authoridation
        $this->authorize('update', $sector);

        return view('admin.pages.tags.sectors.edit', ['tag' => $sector]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\SectorTagStoreRequest  $request
     * @param  App\Models\SystemTag  $sector
     * @return \Illuminate\Http\Response
     */
    public function update(SectorTagStoreRequest $request, SystemTag $sector)
    {
        // Will return only validated data
        $validatedData = $request->validated();

        $validatedData['type'] = 'sector';

        //updates the tag
        $sector->update($validatedData);

        return redirect()->route('admin.tags.sectors.index')
                         ->with('success','Sector tag updated successfully');
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

        // "page" is the page number
        // "entries" is the number of records per page
        if ( (!empty($request->input('entries'))) && ($request->has('page')) )
        {

            $page_nb = $request->input('page');
            $nb_entries = $request->input('entries');

            foreach($request->input('order', []) as $row)
            {
                SystemTag::find($row['id'])->update([
                    'order_column' => $row['position'] + ($page_nb * $nb_entries)
                ]);
            }

        }

        return response()->noContent();

    }


}
