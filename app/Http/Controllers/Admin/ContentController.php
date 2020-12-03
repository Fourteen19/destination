<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
//use App\Models\Admin\Admin;
use App\Models\Content;

use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use \Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentStoreRequest;
use App\Models\SystemTag;
use App\Models\ContentTemplate;
use App\Models\ContentArticle;

class ContentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            //selects institution from specific client
           /* $data = DB::table('contents')
                ->select(['id', 'title', 'uuid']);
*/

            $data = Content::get();

            return DataTables::of($data)
                ->addColumn('name', function($row){
                    return $row->title;
                })
                ->addColumn('action', function($row){

                    $actions = '<a href="'.route("admin.contents.".$row->contentTemplate->slug_plural.".edit", [$row->contentTemplate->slug => $row->uuid]).'" class="edit btn btn-primary btn-sm">Edit</a> ';
                    $actions .= '<button class="open-make-live-modal btn btn-danger" data-id="'.$row->uuid.'">Make Live</button>';
                    $actions .= '<button class="open-delete-modal btn btn-danger" data-id="'.$row->uuid.'">Delete</button>';

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        //return view('admin.pages.contents.index', compact('clientUuid'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



/*
    public function makeLive(Content $content)
    {
       dd($content->id);
    }
*/

    public function makeLive(Content $content)
    {
       dd($content);
    }


    public function removeLive($id)
    {
        //
    }
}
