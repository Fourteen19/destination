<?php

namespace App\Http\Controllers\Admin;

use auth;
use App\Models\Content;
use App\Models\SystemTag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ContentArticle;
use App\Models\ContentTemplate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentArticleStoreRequest;

class ContentArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        //gets all the tags of type 'subject'
        $tagsSubjects = SystemTag::where('type', 'subject')->get();

        $contentSubjectTags = $content->tagsWithType('subject'); // returns a collection

        return view('admin.pages.contents.articles.create', ['content' => $content, 'tagsSubjects' => $tagsSubjects, 'contentSubjectTags' => $contentSubjectTags]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentArticleStoreRequest $request, Content $content)
    {

        //checks policy
        $this->authorize('create', '\App\Models\Content');

        // Will return only validated data
        $validatedData = $request->validated();

        //create the `article` record
        $article = ContentArticle::create($validatedData);

        //fetch the template
        $template = ContentTemplate::where('Name', 'Article')->first();

        //creates the `content` record
        $content = $article->content()->create([
                                'template_id' => $template->id,
                                'title' => $validatedData['title'],
                                'slug' => Str::slug($validatedData['title']),
                                'client_id' => auth()->user()->client_id
                            ]);

        //attaches tags to the content
        $content->attachTags( !empty($validatedData['tagsSubjects']) ? $validatedData['tagsSubjects'] : [] , 'subject' );

        return redirect()->route('admin.contents.index')->with('success', 'Content created successfully');

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $uuid )
    {

        $content = Content::where('uuid', $uuid)->firstOrFail();

        //check authoridation
       // $this->authorize('update', $content);

        //gets all the tags of type 'subject'
        $tagsSubjects = SystemTag::where('type', 'subject')->get();

        //gets the tags allocated to the content
        $contentSubjectTags = $content->tagsWithType('subject'); // returns a collection

        return view('admin.pages.contents.articles.edit', ['article' => $content->uuid, 'content' => $content, 'tagsSubjects' => $tagsSubjects, 'contentSubjectTags' => $contentSubjectTags]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContentArticleStoreRequest $request, $uuid)
    {

        $content = Content::where('uuid', $uuid)->firstOrFail();

        // Will return only validated data
        $validatedData = $request->validated();

        //updates the resource
        $content->update([
                    'title' => $validatedData['title'],
        ]);

        //updates the resource
        $content->contentable->update([
                'title' => $validatedData['title'],
                'lead' => $validatedData['lead'],
                'body' => $validatedData['body'],
        ]);

        //if no tag submitted
        if (!isset($validatedData['tagsSubjects']))
        {
            //reset tags for the resource
            $content->syncTagsWithType([], 'subject');

        } else {

            //attaches tags to the resource
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
}
