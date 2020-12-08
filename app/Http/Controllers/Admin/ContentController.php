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
use App\Services\ContentService;
use \Yajra\DataTables\DataTables;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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



        if ($request->ajax()) {

/*
            $data = Content::leftjoin('contents_live', 'contents.id', '=', 'contents_live.id')
                            ->select(['contents.*', 'contents_live.id as live_id', 'contents_live.updated_at as live_updated_at']);
*/

            $items = DB::table('contents')
            ->leftjoin('contents_live', 'contents.id', '=', 'contents_live.id')
            ->join('content_templates', 'contents.template_id', '=', 'content_templates.id')
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

            return DataTables::of($items)
                ->addColumn('name', function($row){
                    return $row->title;
                })
                ->addColumn('action', function($row){

                    $actions = "";

                    if (Auth::guard('admin')->user()->hasAnyPermission('global-content-edit')){
                        //$actions = '<a href="'.route("admin.contents.".$row->contentTemplate->slug_plural.".edit", [$row->contentTemplate->slug => $row->uuid]).'" class="edit btn btn-primary btn-sm">Edit</a> ';
                        $actions = '<a href="'.route("admin.contents.".$row->slug_plural.".edit", [$row->slug => $row->uuid]).'" class="edit btn btn-primary btn-sm">Edit</a> ';
                    }

                    //if the user has the permission to make content live
                    if (Auth::guard('admin')->user()->hasAnyPermission('global-content-make-live')){

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
                        $actions .= '<button id="live_'.$row->uuid.'" class="'.$class.' btn btn-danger" data-id="'.$row->uuid.'">'.$label.'</button>';
                    }

                    //if the user has the permission to delete content
                    if (Auth::guard('admin')->user()->hasAnyPermission('global-content-delete')){
                        $actions .= '<button class="open-delete-modal btn btn-danger" data-id="'.$row->uuid.'">Delete</button>';
                    }

                    return $actions;
                })

                ->rawColumns(['action'])
                ->make(true);

        }

        return view('admin.pages.contents.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //checks policy
        $this->authorize('create', 'App\Models\Content');

        $content = new Content;

        $templates = ContentTemplate::get();

        /*
        //gets all the tags of type 'subject'
        $tagsSubjects = SystemTag::where('type', 'subject')->get();

        $contentSubjectTags = $content->tagsWithType('subject'); // returns a collection

        return view('admin.pages.contents.create', ['content' => $content, 'tagsSubjects' => $tagsSubjects, 'contentSubjectTags' => $contentSubjectTags]);
        */

        return view('admin.pages.contents.create', ['content' => $content, 'templates' => $templates]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\ContentStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentStoreRequest $request)
    {

/*
        //checks policy
        //$this->authorize('create', '\App\Models\Content');

        // Will return only validated data
        $validatedData = $request->validated();

        //$validatedData['client_id'] = 1; //CURRENTLY SET STATICALLY

        //creates the client's institution
        $content = Content::create($validatedData);

        //attaches tags to the content
        $content->attachTags( $validatedData['tagsSubjects'], 'subject' );

*/

        //checks policy
        //$this->authorize('create', '\App\Models\Content');

        // Will return only validated data
        $validatedData = $request->validated();

        $template = ContentTemplate::where('name', $validatedData['template'])->get()->first();

/*
        $validatedData['client_id'] = 1; //CURRENTLY SET STATICALLY

        //creates the content
        $article = ContentArticle::create($validatedData);
        $content = $article->content()->create(['title' => 'title content', 'uuid' => '222']);
*/
        return redirect()->route('admin.contents.' . $template->slug_plural . '.create');


//        return redirect()->route('admin.contents.'.$template.'.create', ['content' => $content->uuid])->with('success', 'Content created successfully');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Content $content)
    {

        //check authoridation
        $this->authorize('update', $content);

        //gets all the tags of type 'subject'
        $tagsSubjects = SystemTag::where('type', 'subject')->get();

        //gets the tags allocated to the content
        $contentSubjectTags = $content->tagsWithType('subject'); // returns a collection

        return view('admin.pages.contents.articles.edit', ['content' => $content, 'tagsSubjects' => $tagsSubjects, 'contentSubjectTags' => $contentSubjectTags]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\ContentStoreRequest  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(ContentStoreRequest $request, Content $content)
    {

        // Will return only validated data
        $validatedData = $request->validated();

        //updates the resource
        $content->update($validatedData);


        if (!isset($validatedData['tagsSubjects']))
        {
            $content->syncTagsWithType([], 'subject');

        } else {

            //attaches tags to the content
            $content->syncTagsWithType( $validatedData['tagsSubjects'], 'subject' );
        }

        return redirect()->route('admin.contents.index')
                         ->with('success', 'Global Content updated successfully');
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
