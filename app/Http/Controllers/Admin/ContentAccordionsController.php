<?php

namespace App\Http\Controllers\Admin;

use App\Models\Content;
use App\Models\SystemTag;
use Illuminate\Http\Request;
use App\Models\ContentAccordion;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentArticleStoreRequest;

class ContentAccordionsController extends Controller
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
        //$tagsSubjects = SystemTag::where('type', 'subject')->get();

        //$contentSubjectTags = $content->tagsWithType('subject'); // returns a collection
//, 'tagsSubjects' => $tagsSubjects, 'contentSubjectTags' => $contentSubjectTags
        return view('admin.pages.contents.accordions.create', ['content' => $content]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
/*    public function store(ContentAccordionStoreRequest $request, Content $content)
    {

        dd("accordion store not used");

        ///checks policy
        $this->authorize('create', '\App\Models\Content');

        // Will return only validated data
        $validatedData = $request->validated();

        try {

            //create the `article` record
            $accordion = ContentAccordion::create($validatedData);

            //fetch the template
            $template = ContentTemplate::where('Name', 'Accordion')->first();

            //creates the `content` record
            $content = $accordion->content()->create([
                                'template_id' => $template->id,
                                'title' => $validatedData['title'],
                                'slug' => Str::slug($validatedData['title']),
                                'client_id' => auth()->user()->client_id
                            ]);

            //attaches tags to the content
            //$content->attachTags( !empty($validatedData['tagsSubjects']) ? $validatedData['tagsSubjects'] : [] , 'subject' );

        } catch (exception $e) {

            return redirect()->route('admin.contents.index')->withFail('Content creation failed!');

        }

        return redirect()->route('admin.contents.index')->with('success', 'Content created successfully');

    }
*/
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $uuid)
    {

        $content = Content::where('uuid', $uuid)->firstOrFail();

        //$content->addMedia( "C:\\rfmedia_projects\projects\ckcorp\storage\app\public\ck\articles\images\BarbariansCard.png" )->toMediaCollection('banner');

        //check authoridation
       // $this->authorize('update', $content);

        //gets all the tags of type 'subject'
//        $tagsSubjects = SystemTag::where('type', 'subject')->get();

        //gets the tags allocated to the content
//        $contentSubjectTags = $content->tagsWithType('subject'); // returns a collection

//, 'tagsSubjects' => $tagsSubjects, 'contentSubjectTags' => $contentSubjectTags
       return view('admin.pages.contents.accordions.edit', ['content' => $content, 'article' => $content->uuid, 'content' => $content]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 /*   public function update(Request $request, $id)
    {
        //
    }
*/
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
