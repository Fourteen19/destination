<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemTag;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

        //calls the policy to check authoridation
        $this->authorize('list', SystemTag::class);

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

                    $actions = "";

                    if (Auth::guard('admin')->user()->hasAnyPermission('tag-edit')){
                        $actions = '<a href="'.route("admin.tags.sectors.edit", ["sector" => $row->uuid]).'" class="edit mydir-dg btn"><i class="far fa-edit"></i></a> ';

                        if ($row->live == "Y")
                        {
                            $actions .= '<button id="live_'.$row->uuid.'" class="open-remove-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="fas fa-times mr-1"></i><i class="fas fa-bolt"></i></button>';
                        } else {
                            $actions .= '<button id="live_'.$row->uuid.'" class="open-make-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="fas fa-check mr-1"></i><i class="fas fa-bolt"></i></button>';
                        }

                    }

                    if (Auth::guard('admin')->user()->hasAnyPermission('tag-delete')){
                        $actions .= '<button class="open-delete-modal mydir-dg btn" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
                    }

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
        //calls the policy to check authoridation
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

        //calls the policy to check authoridation
        $this->authorize('create', SystemTag::class);

        DB::beginTransaction();

        try {

            $validatedData = $request->validated();

            $validatedData['type'] = 'sector';

            //creates the tag
            $tag = SystemTag::create($validatedData);

            DB::commit();

            return redirect()->route('admin.tags.sectors.index')
                            ->with('success', 'Your sector tag has been created successfully');

        }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.tags.sectors.index')
                            ->with('error', 'An error occured, your sector tag could not be created');
        }

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
        //calls the policy to check authoridation
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

        //checks policy
        $this->authorize('update', $sector);

        DB::beginTransaction();

        try {

            // Will return only validated data
            $validatedData = $request->validated();

            $validatedData['type'] = 'sector';

            //updates the tag
            $sector->update($validatedData);

            DB::commit();

            return redirect()->route('admin.tags.sectors.index')
                            ->with('success', 'Your sector tag has been updated successfully');

        }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.tags.sectors.index')
                            ->with('error', 'An error occured, your sector tag could not be updated');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SystemTag $sector)
    {

        //check policy authorisation
        $this->authorize('delete', $sector);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $sectorId = $sector->id;

                $sector->delete();

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your sector tag has been successfully deleted!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your sector tag could not be deleted, Try Again!";
            }

            return response()->json($data_return, 200);

        }

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

        //check authorisation
        $this->authorize('update', SystemTag::class);

        // "page" is the page number
        // "entries" is the number of records per page
        if ( (!empty($request->input('entries'))) && ($request->has('page')) )
        {

            $page_nb = $request->input('page');
            $nb_entries = $request->input('entries');

            DB::beginTransaction();

            try {

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




    /**
     * Make live the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\SystemTag $sector
     * @return \Illuminate\Http\Response
     */
    public function makeLive(Request $request, SystemTag $sector)
    {

        //check policy authorisation
        $this->authorize('makeLive', $sector);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $sectorId = $sector->id;

                $sector->update(['live' => 'Y']);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your sector tag has successfully been made live!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your sector tag could not be made live!";
            }

            return response()->json($data_return, 200);

        }

    }

    /**
     * remove from live the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\SystemTag $sector
     * @return \Illuminate\Http\Response
     */
    public function removeLive(Request $request, SystemTag $sector)
    {
        //check policy authorisation
        $this->authorize('makeLive', $sector);

         if ($request->ajax()) {

           DB::beginTransaction();

            try  {

                $sectorId = $sector->id;

                $sector->update(['live' => 'N']);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your sector tag has successfully been removed from live!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your sector tag could not be removed from live!";
            }

            return response()->json($data_return, 200);

        }
    }


}
