<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
//use App\Models\Admin\Admin;
use App\Models\Content;

use App\Models\SystemTag;
use App\Models\ContentLive;
use Illuminate\Http\Request;
use App\Models\ContentArticle;
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

            } elseif (isClientAdmin()){
                $contentOwner = Session::get('client')['name'];

            } else {

            }


        //if AJAX request
        } else {

            $items = DB::table('contents')
            ->leftjoin('contents_live', 'contents.id', '=', 'contents_live.id')
            ->join('content_templates', 'contents.template_id', '=', 'content_templates.id')
            ->leftjoin('clients', 'clients.id', '=', 'contents.client_id')
            ->where('contents.deleted_at', NULL)
            ->orderBy('contents.updated_at','DESC')
            ->select(
                "contents.uuid",
                "contents.title",
                "contents.updated_at",
                "contents_live.id as live_id",
                "contents_live.updated_at as live_updated_at",
                "content_templates.slug",
                "content_templates.slug_plural"
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
                    if ( ( (Route::is('admin.global*')) && (Auth::guard('admin')->user()->hasAnyPermission('global-content-delete')) ) ||
                    ( (Route::is('admin.content*')) && (Auth::guard('admin')->user()->hasAnyPermission('client-content-delete')) ) )
                    {
                        $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Delete</button>';
                    }

                    return $actions;
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

        $templates = ContentTemplate::where('show', 'Y')->get();

        return view('admin.pages.contents.create', ['content' => $content, 'templates' => $templates]);

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
        if(\Route::is('admin.global.*')){
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

            $result = $this->contentService->delete($content);

            if ($result) {
                $data_return['error'] = false;
                $data_return['message'] = "Content successfully deleted!";
            } else {
                $data_return['error'] = true;
                $data_return['message'] = "Content could not be not deleted, Try Again!";
                $log_status = "error";
            }

            //Needs to be added to an observer
            Log::info($data_return['message'], ['user_id' => Auth::user()->id, 'content_deleted' => $content->id]);
            Log::error($data_return['message'], ['user_id' => Auth::user()->id, 'content_deleted' => $content->id]);

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

        if ($request->ajax())
        {

            $result = $this->contentService->makeLive($content);

            if ($result) {
                $data_return['result'] = true;
                $data_return['message'] = "Your page has successfully been made live!";
            } else {
                $data_return['result'] = false;
                $data_return['message'] = "Your page coule not be made live!";
                $log_status = "error";
            }

            //Needs to be added to an observer
            Log::info($data_return['message'], ['user_id' => Auth::user()->id, 'content' => $content->id]);
            Log::error($data_return['message'], ['user_id' => Auth::user()->id, 'content' => $content->id]);

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

        if ($request->ajax())
        {

            $result = $this->contentService->removeLive($content);

            if ($result) {
                $data_return['result'] = true;
                $data_return['message'] = "Your page has successfully been removed from live!";
            } else {
                $data_return['result'] = false;
                $data_return['message'] = "Your page coule not be removed from live!";
                $log_status = "error";
            }

            //Needs to be added to an observer
            Log::info($data_return['message'], ['user_id' => Auth::user()->id, 'content' => $content->id]);
            Log::error($data_return['message'], ['user_id' => Auth::user()->id, 'content' => $content->id]);

            return response()->json($data_return, 200);

        }
    }
}
