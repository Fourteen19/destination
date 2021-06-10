<?php

namespace App\Http\Controllers\Admin;

use App\Models\Resource;
use App\Models\Institution;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\ResourceService;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\ResourceStoreRequest;

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

            //dd( Auth::guard('admin')->user()->institution);

        //if AJAX request
        } else {


            $items = Resource::where('resources.deleted_at', NULL)
                                ->orderBy('resources.created_at','DESC')
                                ->select(
                                    "resources.id",
                                    "resources.uuid",
                                    "resources.filename",
                                    "resources.description",
                                    "resources.all_clients",
                                )
                                ->with('Media');


            if (!isGlobalAdmin())
            {
                $items = $items->where('resources.all_clients', 'Y')
                                ->orWhereHas('resourceClient', function($query)  {
                                    $query->where('client_id', Session::get('adminClientSelectorSelected'));
                                });

                //if the admin is a teacher AND the institution has the `work experience` module IS NOT enabled
                if (isClientTeacher(Auth::guard('admin')->user()))
                {
                    $institution = Auth::guard('admin')->user()->institutions->first();

                    //if an institution was found
                    if ($institution instanceOf Institution)
                    {
                        //if the institution does not have the `work experience` enabled, ONLY select resources that are nor work experience related
                        if ($institution->work_experience == 'N')
                        {
                            $items = $items->where('resources.work_experience', 'N');
                        }
                    }

                }

            }




            return DataTables::of($items)
            ->addColumn('filename', function($row){
                return $row->filename;
            })
            ->addColumn('description', function($row){
                return $row->description;
            })
            ->addColumn('link', function($row){
                return "<a href=\"".$row->getFirstMedia('resource')->getFullUrl()."\" target=\"_blank\"><i class=\"fas fa-file-download fa-lg\"></i></a>";
            })
            ->addColumn('client', function($row){
                if ($row->all_clients == 'Y')
                {
                    return "All Clients";
                } else {
                    return $row->clients->map(function($client) {
                        return $client->name;
                    })->implode(' | ');
                }
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
                        $query->where('resources.filename', 'LIKE', "%" . request('search.value') . "%");
                    }
                }

            })
            ->rawColumns(['link', 'client', 'action'])
            ->make(true);

        }

        return view('admin.pages.resources.index', ['contentOwner' => $contentOwner]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //checks policy
        $this->authorize('create', Resource::class);

        $resource = new Resource;

        return view('admin.pages.resources.create', ['resource' => $resource, 'action' => 'create']);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  mixed $request
     * @param  mixed $resourceService
     * @return void
     */
    public function store(ResourceStoreRequest $request, ResourceService $resourceService)
    {

        //checks policy
        $this->authorize('create', Resource::class);

        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            //creates the resource
            $resourceService->createResource($validatedData);

            DB::commit();

            return redirect()->route('admin.resources.index')
                ->with('success','Your resource has been created successfully');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.resources.index')
                            ->with('error', 'An error occured, your resource could not be created');
        }

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  mixed $request
     * @param  mixed $resource
     * @return void
     */
    public function edit(Resource $resource)
    {

        //check authoridation
        $this->authorize('update', $resource);

        return view('admin.pages.resources.edit', ['action' => 'edit', 'resource' => $resource]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  mixed $request
     * @param  mixed $resource
     * @return void
     */
    public function update(ResourceStoreRequest $request, Resource $resource, ResourceService $resourceService)
    {

        //checks policy
        $this->authorize('update', $resource);

        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            //creates the resource
            $resourceService->updateResource($resource, $validatedData);

            DB::commit();

            return redirect()->route('admin.resources.index')
                ->with('success','Your resource has been updated successfully');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.resources.index')
                            ->with('error', 'An error occured, your resource could not be updated');
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed $resource
     * @return void
     */
    public function destroy(Request $request, Resource $resource, ResourceService $resourceService)
    {
        //check policy authorisation
        $this->authorize('delete', $resource);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $resourceId = $resource->id;

                $result = $resourceService->delete($resource);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Resource successfully deleted!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Resource could not be not deleted, Try Again!";

            }

            return response()->json($data_return, 200);

        }
    }


}
