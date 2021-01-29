<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\SystemKeywordTag;
use \Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\KeywordTagStoreRequest;

class TagsKeywordController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //checks policy
        $this->authorize('list', SystemKeywordTag::class);

        //gets the clientID from the `GetClientFromSelector` middleware
        $clientId = \Request::get('clientId');

        if ($request->ajax()) {

            $data = SystemKeywordTag::where('type', 'keyword')->withClient($clientId)->orderBy('name', 'ASC')->get();

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

                    if (Auth::guard('admin')->user()->hasAnyPermission('client-keyword-edit')){

                        $actions .= '<a href="'.route("admin.keywords.edit", ["keyword" => $row->uuid]).'" class="edit mydir-dg btn">Edit</a> ';

                        $live_buttton_txt = "";
                        if ($row->live == "Y")
                        {
                            $live_buttton_txt = "Make Not Live";
                        } else {
                            $live_buttton_txt = "Make Live";
                        }
                        $actions .= '<a href="#" class="edit mydir-dg btn">'.$live_buttton_txt.'</a> ';

                    }

                    if (Auth::guard('admin')->user()->hasAnyPermission('client-keyword-delete')){
                        $actions .= '<button class="open-delete-modal mydir-dg btn" data-id="'.$row->uuid.'">Delete</button>';
                    }

                    return $actions;
                })
                ->rawColumns(['#', 'action'])
                ->make(true);

        }

        return view('admin.pages.keywords.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //checks policy
        $this->authorize('create', SystemKeywordTag::class);

        $tag = new SystemKeywordTag;

        return view('admin.pages.keywords.create', ['tag' => $tag]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\KeywordTagStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KeywordTagStoreRequest $request)
    {
        //checks policy
        $this->authorize('create', SystemKeywordTag::class);

        DB::beginTransaction();

        try {

            $validatedData = $request->validated();

            $validatedData['type'] = 'keyword';

            //gets the clientID from the `GetClientFromSelector` middleware
            $validatedData['client_id'] = \Request::get('clientId');

            //creates the tag
            $tag = SystemKeywordTag::create($validatedData);

            DB::commit();

            return redirect()->route('admin.keywords.index')
                            ->with('success', 'Your keyword tag has been created successfully');

        }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.keywords.index')
                            ->with('error', 'An error occured, your keyword tag could not be created');
        }

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Models\SystemKeywordTag  $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SystemKeywordTag $keyword)
    {
        //calls the policy to check authoridation
        $this->authorize('update', $keyword);

        return view('admin.pages.keywords.edit', ['tag' => $keyword]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\KeywordTagStoreRequest  $request
     * @param  App\Models\SystemKeywordTag  $keyword
     * @return \Illuminate\Http\Response
     */
    public function update(KeywordTagStoreRequest $request, SystemKeywordTag $keyword)
    {
        //calls the policy to check authoridation
        $this->authorize('update', $keyword);

        DB::beginTransaction();

        try {

            // Will return only validated data
            $validatedData = $request->validated();

            $validatedData['type'] = 'keyword';

            //updates the tag
            $keyword->update($validatedData);

            DB::commit();

            return redirect()->route('admin.keywords.index')
                            ->with('success', 'Your keyword tag has been updated successfully');

        }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.keywords.index')
                            ->with('error', 'An error occured, your keyword tag could not be updated');
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
        //$this->authorize('delete', $keyword);


    }

}
