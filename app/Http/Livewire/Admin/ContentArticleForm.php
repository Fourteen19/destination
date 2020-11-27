<?php

namespace App\Http\Livewire\Admin;

use App\Models\Video;
use App\Models\Content;
use Livewire\Component;
use App\Models\SystemTag;
use Illuminate\Support\Str;
use App\Models\ContentArticle;
use App\Models\ContentTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContentArticleForm extends Component
{

    use AuthorizesRequests;

    public $title, $lead, $body;
    public $action;
    public $i = 1;
    public $videos = [];

    public $content;
    public $tagsSubjects, $tagsYearGroups, $tagsLscs, $tagsRoutes;
    public $contentSubjectTags = [];
    public $contentYearGroupsTags = [];
    public $contentLscsTags = [];
    public $contentRoutesTags = [];


    protected $rules = [
        'title' => 'required',
        'lead' => 'required',
        'contentSubjectTags.*' => '',
        'videos.*.url' => 'required',
    ];

    protected $messages = [
        'videos.*.url.required' => 'The URL is required',
    ];


    //setup of the component
    public function mount($action, $content)
    {

        $this->action = $action;

        $this->content = $content;

        if ($action == 'edit')
        {

          //  $this->fill($this->content->contentable);

            $this->title = $this->content->contentable->title;
            $this->lead = $this->content->contentable->lead;
            $this->body = $this->content->contentable->body;

        }

        $this->tagsSubjects = SystemTag::where('type', 'subject')->get()->toArray();
        $contentSubjectTags = $this->content->tagsWithType('subject');
        foreach($contentSubjectTags as $key => $value){
            $this->contentSubjectTags[] = $value['name'];
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

        $this->videos = $this->content->videos->toArray();

    }


    /**
     * Add as video to the videos array
     */
    public function addVideo()
    {
        $this->videos[] = ['url' => ''];
    }


    /**
     * Remove as video to the videos array
     */
    public function remove($i)
    {
        unset($this->videos[$i]);
    }

    /**
     * Validate single a field
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }



    public function store()
    {

        if ($this->action == 'add')
        {
//           $this->authorize('create', 'App\Models\Content');
        } else {
//            $this->authorize('update', $this->content);
        }

        $this->validate($this->rules, $this->messages);


        if ($this->action == 'add')
        {

            //create the `article` record
            $article = ContentArticle::create([
                    'title' => $this->title,
                    'lead' => $this->lead,
                    'body' => $this->body,
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
            $newContent->attachTags( !empty($this->contentSubjectTags) ? $this->contentSubjectTags : [] , 'subject' );
            $newContent->attachTags( !empty($this->contentYearGroupsTags) ? $this->contentYearGroupsTags : [] , 'year' );
            $newContent->attachTags( !empty($this->contentLscsTags) ? $this->contentLscsTags : [] , 'lscs' );
            $newContent->attachTags( !empty($this->contentRoutesTags) ? $this->contentRoutesTags : [] , 'lscs' );

            //create the videos to attach to content
            foreach($this->videos as $key => $value){

                $video = new Video();
                $video->url = $value['url'];

                $newContent->videos()->save($video);
            }


        } elseif ($this->action == 'edit'){

            //updates the resource
            $this->content-> update([
                'title' => $this->title,
            ]);

            //updates the resource
            $this->content-> contentable-> update([
                'title' => $this->title,
                'lead' => $this->lead,
                'body' => $this->body,
            ]);


            //if no tag submitted
            if (!isset($this->contentSubjectTags)) {

                //reset tags for the resource
                $this->content->syncTagsWithType([], 'subject');
                $this->content->syncTagsWithType([], 'year');
                $this->content->syncTagsWithType([], 'route');
                $this->content->syncTagsWithType([], 'lscs');

            } else {

                //attaches tags to the resource
                $this->content->syncTagsWithType($this->contentSubjectTags, 'subject');
                $this->content->syncTagsWithType($this->contentYearGroupsTags, 'year');
                $this->content->syncTagsWithType($this->contentLscsTags, 'lscs');
                $this->content->syncTagsWithType($this->contentRoutesTags, 'route');

            }


            $this->content->videos()->delete();

            //create the videos to attach to content
            foreach($this->videos as $key => $value){

                $video = new Video();
                $video->url = $value['url'];

                $this->content->videos()->save($video);
            }

        }

        /*

        session()->flash('message', 'Content Created Successfully.');
        */
    }

    public function render()
    {


        info($this->contentSubjectTags);

        return view('livewire.admin.content-article-form');
    }

}
