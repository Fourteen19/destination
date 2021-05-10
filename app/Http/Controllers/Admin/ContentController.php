<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
//use App\Models\Admin\Admin;
use App\Models\Content;

use Illuminate\Http\Request;
use App\Models\ContentTemplate;
use \Yajra\DataTables\DataTables;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Services\Admin\ContentService;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\ContentStoreRequest;

class ContentController extends Controller
{

    private $contentService;


    public function __construct(ContentService $contentService)
    {

        $this->contentService = $contentService;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //check authoridation
        $this->authorize('list', Content::class);


        if (!$request->ajax()) {

            $contentOwner = app('clientService')->getClientNameForAdminPages();

        //if AJAX request
        } else {

            $this->types = ContentTemplate::where('show', 'Y')->orderBy('name', 'ASC')->pluck('id')->toArray();

            if (request()->has('type')) {
                if (!empty(request('type'))){

                    $validationRules = [
                        'type' => 'sometimes|in:'.implode(",", $this->types),
                    ];

                    //filtered data
                    $validatedData = $this->validate($request, $validationRules);
                }
            }




            $items = DB::table('contents')
            ->leftjoin('contents_live', 'contents.id', '=', 'contents_live.id')
            ->join('content_templates', 'contents.template_id', '=', 'content_templates.id')
            ->leftjoin('clients', 'clients.id', '=', 'contents.client_id')
            ->leftjoin('admins', 'contents.updated_by', '=', 'admins.id')
            ->where('contents.deleted_at', NULL)
            ->orderBy('contents.updated_at','DESC')
            ->select(
                "contents.uuid",
                "contents.title",
                "contents.updated_at",
                "contents.deleted_at",
                "contents_live.deleted_at as deleted_at_live",
                "contents_live.id as live_id",
                "contents_live.updated_at as live_updated_at",
                "content_templates.name",
                "content_templates.slug",
                "content_templates.slug_plural",
                DB::raw("CONCAT(admins.first_name, \" \", admins.last_name) as admin_name"),
                DB::raw("DATE_FORMAT(contents.updated_at, \"%d/%m/%Y\") as last_updated_date")
            );

            //if browsing the global articles
            if (Route::is('admin.global*')){

                $items = $items->where('contents.client_id', '=', NULL);

            //if browsing client's articles
            } else {

                if (isGlobalAdmin())
                {
                    $items = $items->where('clients.uuid', '=', Session::get('adminClientSelectorSelection') );
                } elseif (isclientAdmin()) {
                    $items = $items->where('contents.client_id', '=', Auth::guard('admin')->user()->client_id);
                }

            }



            return DataTables::of($items)
                ->addColumn('name', function($row){
                    return $row->title;
                })
                ->addColumn('type', function($row){
                    return UCWords($row->name);
                })
                ->addColumn('lastedited', function($row){
                    $admin_full_name = (!empty($row->admin_name)) ? $row->admin_name : "Unknown";
                    return "Last edited by ".$admin_full_name." on ".$row->last_updated_date;
                })
                ->addColumn('action', function($row){

                    $actions = "";

                    if ( (Route::is('admin.global*')) && (Auth::guard('admin')->user()->hasAnyPermission('global-content-edit')) ) {
                        $actions = '<a href="'.route("admin.global.contents.".$row->slug_plural.".edit", [$row->slug => $row->uuid]).'" class="edit mydir-dg btn">Edit</a> ';

                    } elseif ( (Route::is('admin.content*')) && (Auth::guard('admin')->user()->hasAnyPermission('client-content-edit')) ){
                        $actions = '<a href="'.route("admin.contents.".$row->slug_plural.".edit", [$row->slug => $row->uuid]).'" class="edit mydir-dg btn">Edit</a> ';
                    }



                    //if the user has the permission to make content live
                    if ( ( (Route::is('admin.global*')) && (Auth::guard('admin')->user()->hasAnyPermission('global-content-make-live')) ) ||
                    ( (Route::is('admin.content*')) && (Auth::guard('admin')->user()->hasAnyPermission('client-content-make-live')) ) )
                    {

                        if ( (empty($row->live_id)) || ( (!empty($row->live_id) && (!empty($row->deleted_at_live)) ) ) )
                        {
                            $actions .= '<button id="live_'.$row->uuid.'" class="open-make-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Make Live</button>';
                        } elseif ( (!empty($row->live_id)) && ($row->updated_at != $row->live_updated_at) && (empty($row->deleted_at_live)) )
                        {
                            $actions .= '<button id="live_'.$row->uuid.'" class="open-apply-latest-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Apply latest changes to Live</button>';
                        }

                        if ( (!empty($row->live_id)) && (empty($row->deleted_at_live)) )
                        {
                            $actions .= '<button id="live_'.$row->uuid.'" class="open-remove-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Remove from Live</button>';
                        }

                    }

                    //if the user has the permission to delete content
                    if ( ( (Route::is('admin.global*')) && (Auth::guard('admin')->user()->hasAnyPermission('global-content-delete')) ) ||
                    ( (Route::is('admin.content*')) && (Auth::guard('admin')->user()->hasAnyPermission('client-content-delete')) ) )
                    {
                        $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Delete</button>';
                    }

                    return $actions;
                })
                ->filter(function ($query){

                    if (request()->has('type')) {
                        if (!empty(request('type'))){
                            $query->where('contents.template_id', '=', request('type'));
                        }
                    }

                    if (request()->has('search.value')) {
                        if (!empty(request('search.value'))){
                            $query->where('contents.title', 'LIKE', "%" . request('search.value') . "%");
                        }
                    }

                })

                ->rawColumns(['action'])
                ->make(true);

        }

        return view('admin.pages.contents.index', ['contentOwner' => $contentOwner ]);
    }

    /**
     * Show the form for selecting the content template
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //check authoridation
        $this->authorize('create', Content::class);

        $content = new Content;

        $templates = ContentTemplate::where('show', 'Y')->orderBy('name', 'ASC')->get();

        $contentOwner = app('clientService')->getClientNameForAdminPages();

        return view('admin.pages.contents.create', ['content' => $content, 'templates' => $templates, 'contentOwner' => $contentOwner]);

    }

    /**
     * Stores the temaplte selected for the model
     *
     * @param  \App\Http\Requests\Admin\ContentStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentStoreRequest $request)
    {

        //check authoridation
        $this->authorize('create', Content::class);

        // Will return only validated data
        $validatedData = $request->validated();

        $template = ContentTemplate::where('name', $validatedData['template'])->get()->first();

        $adminRouteSegment = '';
        if (Route::is('admin.global.*')){
            $adminRouteSegment = 'global.';
        }

        return redirect()->route('admin.'.$adminRouteSegment.'contents.' . $template->slug_plural . '.create');

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Content $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Content $content)
    {

        //check policy authorisation
        $this->authorize('delete', $content);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $content_id = $content->id;

                $this->contentService->delete($content);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Content successfully deleted!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Content could not be not deleted, Try Again!";
            }

            return response()->json($data_return, 200);

        }

    }



    /**
     * Make live the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Content $content
     * @return \Illuminate\Http\Response
     */
    public function makeLive(Request $request, Content $content)
    {

        //check policy authorisation
        $this->authorize('makeLive', $content);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $content_id = $content->id;

                $this->contentService->makeLive($content);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your page has successfully been made live!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your page could not be made live!";
            }

            return response()->json($data_return, 200);

        }

    }

    /**
     * remove from live the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Content $content
     * @return \Illuminate\Http\Response
     */
    public function removeLive(Request $request, Content $content)
    {
        //check policy authorisation
        $this->authorize('makeLive', $content);

         if ($request->ajax()) {

        /*    DB::beginTransaction();

            try  { */

                $content_id = $content->id;

                $this->contentService->removeLive($content);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your page has successfully been removed from live!";

            /* } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your page could not be removed from live!";
            } */

            return response()->json($data_return, 200);

        }
    }
}
