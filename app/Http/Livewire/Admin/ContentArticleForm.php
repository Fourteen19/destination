<?php

namespace App\Http\Livewire\Admin;

use App\Models\Video;
use App\Models\Content;
use Livewire\Component;
use App\Models\SystemTag;
use App\Models\RelatedLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ContentArticle;
use App\Models\ContentTemplate;
use App\Models\RelatedDownload;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Services\ContentArticleService;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContentArticleForm extends Component
{

    use AuthorizesRequests;

    //, $statement
    public $title, $slug, $type, $lead, $subheading, $body, $alt_block_heading, $alt_block_text, $lower_body;
    public $action;
    public $baseUrl;

    public $bannerImage;
    public $bannerImagePreview;
    public $supportingImages;

    public $videosIteration = 1;
    public $relatedLinksIteration = 1;
    public $relatedDownloadsIteration = 1;
    public $videos = [];
    public $relatedLinks = [];
    public $relatedDownloads = [];

    public $content;
    public $tagsSubjects, $tagsYearGroups, $tagsLscs, $tagsRoutes, $tagsSectors;
    public $contentSubjectTags = [];
    public $contentYearGroupsTags = [];
    public $contentLscsTags = [];
    public $contentRoutesTags = [];
    public $contentSectorsTags = [];


    protected $rules = [
        'title' => 'required',

        'bannerImage' => 'required',
        'supportingImages.*.url' => 'required',
        'videos.*.url' => 'required',
        'relatedLinks.*.title' => 'required',
        'relatedLinks.*.url' => 'required',
        'relatedDownloads.*.title' => 'required',
        'relatedDownloads.*.url' => 'required',

    ];


    protected $messages = [
        'slug.unique' => 'The slug has already been taken. Please modify your title',

        'videos.*.url.required' => 'The URL is required',

        'relatedLinks.*.title.required' => 'The title is required',
        'relatedLinks.*.url.required' => 'The URL is required',

        'relatedDownloads.*.title.required' => 'The title is required',
        'relatedDownloads.*.url.required' => 'The URL is required',
    ];


    //setup of the component
    public function mount(String $action, Content $content)
    {

        $this->action = $action;
       // 'slug' => 'required|alpha_dash|unique:contents, slug,'.$this->uuid,
        $this->content = $content;

        $this->baseUrl = config('app.url').'/article/';

        if ($action == 'edit')
        {

          //  $this->fill($this->content->contentable);
          //{{ config('app.url') }}.'article '.{{ $slug }}
            $this->title = $this->content->title;
            $this->slug = $this->content->slug;
            $this->type = $this->content->contentable->type;
            $this->lead = $this->content->contentable->lead;
            $this->subheading = $this->content->contentable->subheading;
            $this->body = $this->content->contentable->body;
            $this->alt_block_heading = $this->content->contentable->alt_block_heading;
            $this->alt_block_text = $this->content->contentable->alt_block_text;
            $this->lower_body = $this->content->contentable->lower_body;

        }


        $this->tagsYearGroups = SystemTag::where('type', 'year')->get()->toArray();
        $contentYearGroupsTags = $this->content->tagsWithType('year');
        foreach($contentYearGroupsTags as $key => $value){
            $this->contentYearGroupsTags[] = $value['name'];
        }

        $this->tagsLscs = SystemTag::where('type', 'lscs')->get()->toArray();
        $contentLscsTags = $this->content->tagsWithType('lscs');
        foreach($contentLscsTags as $key => $value){
            $this->contentLscsTags[] = $value['name'];
        }

        $this->tagsRoutes = SystemTag::where('type', 'route')->get()->toArray();
        $contentRoutesTags = $this->content->tagsWithType('route');
        foreach($contentRoutesTags as $key => $value){
            $this->contentRoutesTags[] = $value['name'];
        }

        $this->tagsSectors = SystemTag::where('type', 'sector')->get()->toArray();
        $contentSectorsTags = $this->content->tagsWithType('sector');
        foreach($contentSectorsTags as $key => $value){
            $this->contentSectorsTags[] = $value['name'];
        }

        $this->tagsSubjects = SystemTag::where('type', 'subject')->get()->toArray();
        $contentSubjectTags = $this->content->tagsWithType('subject');
        foreach($contentSubjectTags as $key => $value){
            $this->contentSubjectTags[] = $value['name'];
        }

        $this->videos = $this->content->videos->toArray();

        $this->relatedLinks = $this->content->related_links->toArray();

        $this->relatedDownloads = $this->content->related_downloads->toArray();

    }


    /**
     * Add as video
     */
    public function addVideo()
    {
        $this->videos[] = ['url' => ''];
    }

    /**
     * Add as link
     */
    public function addRelatedLink()
    {
        $this->relatedLinks[] = ['title' => '', 'url' => ''];
    }

    /**
     * Add as download
     */
    public function addRelatedDownload()
    {
        $this->relatedDownloads[] = ['title' => '', 'url' => ''];
    }


    /**
     * Remove as video
     */
    public function removeVideo($videosIteration)
    {
        unset($this->videos[$videosIteration]);
    }

    /**
     * Remove as link
     */
    public function removeRelatedLink($relatedLinksIteration)
    {
        unset($this->relatedLinks[$relatedLinksIteration]);
    }

    /**
     * Remove as download
     */
    public function removeRelatedDownload($relatedDownloadsIteration)
    {
        unset($this->relatedDownloads[$relatedDownloadsIteration]);
    }


    /**
     * Validate single a field
     */
    public function updated($propertyName)
    {
        if ($propertyName == "title"){
            $this->slug = Str::slug($this->title);

//            $this->addError('slug', 'message');

            $this->validateOnly('slug', [
                'slug' => [ 'required',
                            'alpha_dash',
                            //search the `contents` table for the slug name, ignores our current content
                            Rule::unique('contents')->whereNot('uuid', $this->content->uuid),
                        ]

                    ]

            );


        } else {
            $this->validateOnly($propertyName);
        }

    }



    public function storeAndMakeLive()
    {

        if ($this->action == 'add')
        {

//           $this->authorize('create', 'App\Models\Content');

        } else {


        }

        //The slug must be checked against global and client content
        $this->rules['slug'] = [ 'required',
                                'alpha_dash',
                                //search the `contents` table for the slug name, ignores our current content
                                Rule::unique('contents')->whereNot('uuid', $this->content->uuid),
                                ];

        $this->validate($this->rules, $this->messages);

        $this->contentArticleService = new ContentArticleService();
        $this->contentArticleService->storeAndMakeLive($this);

        return redirect()->route('admin.contents.index');

    }



    public function store()
    {

        if ($this->action == 'add')
        {
//           $this->authorize('create', 'App\Models\Content');
        } else {
//            $this->authorize('update', $this->content);
        }


        //The slug must be checked against global and client content
        $this->rules['slug'] = [ 'required',
                                'alpha_dash',
                                //search the `contents` table for the slug name, ignores our current content
                                Rule::unique('contents')->whereNot('uuid', $this->content->uuid),
                                ];

        $this->validate($this->rules, $this->messages);

        try {

            $this->contentArticleService = new ContentArticleService();
            $this->contentArticleService->store($this);

            Session::flash('success', 'Content Created Successfully');


        } catch (exception $e) {

            Session::flash('fail', 'Content not Created Successfully');

        }


        if ($this->action == 'add')
        {
            return redirect()->route('admin.contents.index');

        } else {

        }


/*
        if ($this->action == 'add')
        {

            //create the `article` record
            $article = ContentArticle::create([
                    'title' => $this->title,
                    'lead' => $this->lead,
                    'subheading' => $this->subheading,
                    'body' => $this->body,
                    //'statement' => $this->statement,
                    'alt_block_heading' => $this->alt_block_heading,
                    'alt_block_text' => $this->alt_block_text,
                    'lower_body' => $this->lower_body,
            ]);

            //fetch the template
            $template = ContentTemplate::where('Name', 'Article')->first();

            //creates the `content` record
            $newContent = $article->content()->create([
                                'template_id' => $template->id,
                                'title' => $this->title,
                                'slug' => Str::slug($this->title),
                                'client_id' => Auth::guard('admin')->user()->client_id
                            ]);

            //attach tags to the content
            $newContent->attachTags( !empty($this->contentYearGroupsTags) ? $this->contentYearGroupsTags : [] , 'year' );
            $newContent->attachTags( !empty($this->contentLscsTags) ? $this->contentLscsTags : [] , 'lscs' );
            $newContent->attachTags( !empty($this->contentRoutesTags) ? $this->contentRoutesTags : [] , 'route' );
            $newContent->attachTags( !empty($this->contentSectorsTags) ? $this->contentSectorsTags : [] , 'sector' );
            $newContent->attachTags( !empty($this->contentSubjectTags) ? $this->contentSubjectTags : [] , 'subject' );

            //create the videos to attach to content
            foreach($this->videos as $key => $value){

                $model = new Video();
                $model->url = $value['url'];

                $newContent->videos()->save($model);
            }


            //create the related links to attach to content
            foreach($this->relatedLinks as $key => $value){

                $model = new RelatedLink();
                $model->title = $value['title'];
                $model->url = $value['url'];

                $newContent->related_links()->save($model);
            }


            //create the related downloads to attach to content
            foreach($this->relatedDownloads as $key => $value){

                $model = new RelatedDownload();
                $model->title = $value['title'];
                $model->url = $value['url'];

                $newContent->related_downloads()->save($model);
            }

        } elseif ($this->action == 'edit'){

            //updates the resource
            $this->content-> update([
                'title' => $this->title,
                'timestamps' => false,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            //updates the resource
            $this->content-> contentable-> update([
                'title' => $this->title,
                'lead' => $this->lead,
                'subheading' => $this->subheading,
                'body' => $this->body,
                //'statement' => $this->statement,
                'alt_block_heading' => $this->alt_block_heading,
                'alt_block_text' => $this->alt_block_text,
                'lower_body' => $this->lower_body,
            ]);


            //if no tag submitted
           //if (!isset($this->contentSubjectTags)) {

                //reset tags for the resource
                $this->content->syncTagsWithType([], 'year');
                $this->content->syncTagsWithType([], 'route');
                $this->content->syncTagsWithType([], 'lscs');
                $this->content->syncTagsWithType([], 'sector');
                $this->content->syncTagsWithType([], 'subject');



            //} else {

                //attaches tags to the resource
                //dd($this->contentYearGroupsTags);
                $this->content->syncTagsWithType($this->contentYearGroupsTags, 'year');
                $this->content->syncTagsWithType($this->contentLscsTags, 'lscs');
                $this->content->syncTagsWithType($this->contentRoutesTags, 'route');
                $this->content->syncTagsWithType($this->contentSectorsTags, 'sector');
                $this->content->syncTagsWithType($this->contentSubjectTags, 'subject');

           // }


            // Attach videos

            $this->content->videos()->delete();

            //create the videos to attach to content
            foreach($this->videos as $key => $value){

                $model = new Video();
                $model->url = $value['url'];

                $this->content->videos()->save($model);
            }

            // Attach links

            $this->content->related_links()->delete();

            //create the videos to attach to content
            foreach($this->relatedLinks as $key => $value){

                $model = new RelatedLink();
                $model->title = $value['title'];
                $model->url = $value['url'];

                $this->content->related_links()->save($model);
            }

            // Attach downloads

            $this->content->related_downloads()->delete();

            //create the videos to attach to content
            foreach($this->relatedDownloads as $key => $value){

                $model = new RelatedDownload();
                $model->title = $value['title'];
                $model->url = $value['url'];

                $this->content->related_downloads()->save($model);
            }



        }
*/

    }

    public function render()
    {


        //info($this->contentSubjectTags);

        return view('livewire.admin.content-article-form');
    }

}
