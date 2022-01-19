<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\SystemKeywordTag;
use \Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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

        if ($request->ajax()) {

            $data = SystemKeywordTag::where('type', 'keyword')->orderBy('name', 'ASC')->get()->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE);

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
                        $actions .= '<a href="'.route("admin.keywords.edit", ["keyword" => $row->uuid]).'" class="edit mydir-dg btn"><i class="far fa-edit"></i></a> ';

                        if ($row->live == "Y")
                        {
                            $actions .= '<button id="live_'.$row->uuid.'" class="open-remove-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="fas fa-times mr-1"></i><i class="fas fa-bolt"></i></button>';
                        } else {
                            $actions .= '<button id="live_'.$row->uuid.'" class="open-make-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="fas fa-check mr-1"></i><i class="fas fa-bolt"></i></button>';
                        }

                    }

                    if (Auth::guard('admin')->user()->hasAnyPermission('client-keyword-delete')){
                        $actions .= '<button class="open-delete-modal mydir-dg btn" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
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

            //creates the tag
            $tag = SystemKeywordTag::create($validatedData);

            DB::commit();

            return redirect()->route('admin.keywords.index')
                            ->with('success', 'Your keyword tag has been created successfully');

        }
        catch (\Exception $e) {

            Log::error($e);

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

            Log::error($e);

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



    /**
     * Make live the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\SystemKeywordTag $route
     * @return \Illuminate\Http\Response
     */
    public function makeLive(Request $request, SystemKeywordTag $keyword)
    {

        //check policy authorisation
        $this->authorize('makeLive', $keyword);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $keywordId = $keyword->id;

                $keyword->update(['live' => 'Y']);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your keyword tag has successfully been made live!";

            } catch (\Exception $e) {

                Log::error($e);

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your keyword tag could not be made live!";
            }

            return response()->json($data_return, 200);

        }

    }

    /**
     * remove from live the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\SystemKeywordTag $route
     * @return \Illuminate\Http\Response
     */
    public function removeLive(Request $request, SystemKeywordTag $keyword)
    {
        //check policy authorisation
        $this->authorize('makeLive', $keyword);

         if ($request->ajax()) {

           DB::beginTransaction();

            try  {

                $keywordId = $keyword->id;

                $keyword->update(['live' => 'N']);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your keyword tag has successfully been removed from live!";

            } catch (\Exception $e) {

                Log::error($e);

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your keyword tag could not be removed from live!";
            }

            return response()->json($data_return, 200);

        }
    }

}
