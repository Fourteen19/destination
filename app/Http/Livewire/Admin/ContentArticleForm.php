<?php

namespace App\Http\Livewire\Admin;

use App\Models\Content;
use Livewire\Component;
use Spatie\Image\Image;
use App\Models\SystemTag;
use App\Models\RelatedLink;
use Illuminate\Support\Str;
use App\Models\RelatedVideo;
use Illuminate\Http\Request;
use App\Models\ContentArticle;
use App\Models\ContentTemplate;
use App\Models\RelatedDownload;
use Illuminate\Validation\Rule;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\ContentArticleService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContentArticleForm extends Component
{

    use AuthorizesRequests;

    protected $listeners = ['make_banner_image' => 'makeBannerImage',
                            'make_summary_image' => 'makeSummaryImage',
                            ];

    public $title, $slug, $type, $lead, $subheading, $body, $alt_block_heading, $alt_block_text, $lower_body, $summary_heading, $summary_text;
    public $action;
    public $baseUrl;

    public $activeTab;

    public $banner;
    public $bannerOriginal;
    public $bannerImagePreview;

    public $summary_image_type;
    public $summary;
    public $summaryOriginal;
    public $summaryImageSlot1Preview;
    public $summaryImageSlot23Preview;
    public $summaryImageSlot456Preview;
    public $summaryImageYouMightLikePreview;

    public $supportingImages;

    public $relatedVideosIteration = 1;
    public $relatedLinksIteration = 1;
    public $relatedDownloadsIteration = 1;
    public $relatedVideos = [];
    public $relatedLinks = [];
    public $relatedDownloads = [];

    public $content;
    public $tagsSubjects, $tagsYearGroups, $tagsTerms, $tagsLscs, $tagsRoutes, $tagsSectors, $tagsFlags;
    public $contentSubjectTags = [];
    public $contentTermsTags = [];
    public $contentYearGroupsTags = [];
    public $contentLscsTags = [];
    public $contentRoutesTags = [];
    public $contentSectorsTags = [];
    public $contentFlagTags = [];

    public $tempImagePath;
//image|dimensions:min_width=720,min_height=600|max:2048
    protected $rules = [
        'title' => 'required',

       // 'bannerOriginal' => 'mimes:jpg,jpeg,png,gif',

        'summary_image_type' => 'required',
        'summary_heading'=> 'required',
        'summary_text' => 'required',

        'supportingImages.*.url' => 'required',
        'relatedVideos.*.url' => 'required',
        'relatedLinks.*.title' => 'required',
        'relatedLinks.*.url' => 'required',
        'relatedDownloads.*.title' => 'required',
        'relatedDownloads.*.url' => 'required',

    ];


    protected $messages = [
        'slug.unique' => 'The slug has already been taken. Please modify your title',

        'relatedVideos.*.url.required' => 'The URL is required',

        'relatedLinks.*.title.required' => 'The title is required',
        'relatedLinks.*.url.required' => 'The URL is required',

        'relatedDownloads.*.title.required' => 'The title is required',
        'relatedDownloads.*.url.required' => 'The URL is required',
    ];


    //setup of the component
    public function mount(String $action, Content $content)
    {

        $this->action = $action;

        $this->content = $content;

        $this->baseUrl = config('app.url').'/article/';

        //preview images are saved a temp folder
        if (!empty(Auth::guard('admin')->user()->client))
        {
            $this->tempImagePath = Auth::guard('admin')->user()->client->subdomain;
        } else {
            $this->tempImagePath = "global";
        }
        $this->tempImagePath = $this->tempImagePath.'\preview_images\\'.Str::random(32);
        Storage::disk('public')->makeDirectory($this->tempImagePath);

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
            $this->summary_heading = $this->content->summary_heading;
            $this->summary_text = $this->content->summary_text;
            $this->summary_image_type = $this->content->summary_image_type;

            $banner = $this->content->getMedia('banner')->first();
            if ($banner)
            {
                $this->banner = $banner->getCustomProperty('folder'); //relative path in field
                $this->bannerOriginal = $banner->getFullUrl();
                $this->bannerImagePreview = $banner->getUrl('banner'); // retrieves URL of converted image
            }

            $summary = $this->content->getMedia('summary')->first();
            if ($summary)
            {
                $this->summary = $summary->getCustomProperty('folder'); //relative path in field
                $this->summaryOriginal = $summary->getFullUrl();
                $this->summaryImageSlot1Preview = $summary->getUrl('summary_slot1'); // retrieves URL of converted image
                $this->summaryImageSlot23Preview = $summary->getUrl('summary_slot2-3'); // retrieves URL of converted image
                $this->summaryImageSlot456Preview = $summary->getUrl('summary_slot4-5-6'); // retrieves URL of converted image
                $this->summaryImageYouMightLikePreview = $summary->getUrl('summary_you_might_like'); // retrieves URL of converted image
            }

        } else {

            $this->summary_image_type = 'Automatic';

        }


        $this->tagsYearGroups = SystemTag::where('type', 'year')->get()->toArray();
        if ($action == 'add')
        {
            foreach($this->tagsYearGroups as $key => $value){
                $this->contentYearGroupsTags[] = $value['name'][ app()->getLocale() ];
            }
        } else {
            $contentYearGroupsTags = $this->content->tagsWithType('year');
            foreach($contentYearGroupsTags as $key => $value){
                $this->contentYearGroupsTags[] = $value['name'];
            }
        }


        $this->tagsLscs = SystemTag::where('type', 'career_readiness')->get()->toArray();
        if ($action == 'add')
        {
            foreach($this->tagsLscs as $key => $value){
                $this->contentLscsTags[] = $value['name'][ app()->getLocale() ];
            }
        } else {
            $contentLscsTags = $this->content->tagsWithType('career_readiness');
            foreach($contentLscsTags as $key => $value){
                $this->contentLscsTags[] = $value['name'];
            }
        }

        $this->tagsTerms = SystemTag::where('type', 'term')->get()->toArray();
        $contentTermsTags = $this->content->tagsWithType('term');
        foreach($contentTermsTags as $key => $value){
            $this->contentTermsTags[] = $value['name'];
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

        $this->tagsFlags = SystemTag::where('type', 'flag')->get()->toArray();
        $contentFlagTags = $this->content->tagsWithType('flag');
        foreach($contentFlagTags as $key => $value){
            $this->contentFlagTags[] = $value['name'];
        }

        $this->relatedVideos = $this->content->relatedVideos->toArray();

        $this->relatedLinks = $this->content->relatedLinks->toArray();

        $this->relatedDownloads = $this->content->relatedDownloads->toArray();

        $this->activeTab = "article-settings";

    }


    /**
     * Keeps track of the active Tab
     *
     */
    public function updateTab($tabName)
    {
        $this->activeTab = $tabName;
       // dd($this->activeTab);
    }


    /**
     * Add as video
     */
    public function addRelatedVideo()
    {
        $this->relatedVideos[] = ['url' => ''];
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
     * Remove a video
     */
    public function removeRelatedVideo($relatedVideosIteration)
    {
        unset($this->relatedVideos[$relatedVideosIteration]);
    }

    /**
     * Remove a link
     */
    public function removeRelatedLink($relatedLinksIteration)
    {
        unset($this->relatedLinks[$relatedLinksIteration]);
    }

    /**
     * Remove a download
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


        } elseif ($propertyName == "banner"){
            /*
            $this->validateOnly('banner', [
                'slug' => [ 'required',
                            'alpha_dash',
                            //search the `contents` table for the slug name, ignores our current content
                            Rule::unique('contents')->whereNot('uuid', $this->content->uuid),
                        ]

                    ]

            );

*/
    //        $this->bannerOriginal = 'E:\rfmedia projects\ckcorp\website_platform\ckcorp\public\storage\ck\images\business_consulting.jpg';//public_path('/storage/ck/images/business_consulting.jpgl');
    //        $this->validateOnly('bannerOriginal');

        } elseif ($propertyName == "summary"){


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

        $this->contentService = new ContentArticleService();
        $this->contentService->storeAndMakeLive($this);

        $this->removeTempImagefolder();

        return redirect()->route('admin.contents.index');

    }


    public function removeTempImagefolder()
    {
        Storage::disk('public')->deleteDirectory($this->tempImagePath);
    }

    public function updateVideoOrder($videosOrder)
    {
        $tmpVideos = [];

        foreach($videosOrder as $key => $value)
        {
            $tmpVideos[] = $this->relatedVideos[$value['value']];
        }

        $this->relatedVideos = $tmpVideos;
        //dd($this->videos);

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

            $this->contentService = new ContentArticleService();
            $this->contentService->store($this);

            Session::flash('success', 'Content Created Successfully');


        } catch (exception $e) {

            Session::flash('fail', 'Content not Created Successfully');

        }


        if ($this->action == 'add')
        {

            $this->removeTempImagefolder();

            return redirect()->route('admin.contents.index');

        } else {

        }

    }


    public function makeBannerImage($image)
    {

        $version = date("YmdHis");

        $this->banner = $image; //relative path in field
        $this->bannerOriginal = '/storage' . $image; //relative path of image selected. displays the image

        $imageName = "preview_banner.jpg";

        Image::load (public_path( 'storage' . $image ) )
            ->crop(Manipulations::CROP_CENTER, 2074, 798)
            ->save( public_path( 'storage\\'.$this->tempImagePath.'/'.$imageName ));

        $this->bannerImagePreview = '\storage\\'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

        if ($this->summary_image_type == 'Automatic')
        {

            $this->makeSummaryImage($image);

        }

    }


    public function makeSummaryImage($image)
    {

        $version = date("YmdHis");

        if ($this->summary_image_type == 'Custom')
        {

            $this->summary = $image; //relative path in field
            $this->summaryOriginal = '/storage' . $image; //relative path of image selected. displays the image

        }

        $imageNameSlot1 = "preview_summary_slot_1.jpg";
        $imageNameSlot23 = "preview_summary_slot_23.jpg";
        $imageNameSlot456 = "preview_summary_slot_456.jpg";
        $imageNameYouMightLike = "preview_summary_you_might_like.jpg";

        Image::load (public_path( 'storage' . $image ) )
            ->crop(Manipulations::CROP_CENTER, 2074, 1056)
            ->save( public_path( 'storage\\'.$this->tempImagePath.'/'.$imageNameSlot1 ));

        Image::load (public_path( 'storage' . $image ) )
            ->crop(Manipulations::CROP_CENTER, 771, 512)
            ->save( public_path( 'storage\\'.$this->tempImagePath.'/'.$imageNameSlot23 ));

        Image::load (public_path( 'storage' . $image ) )
            ->crop(Manipulations::CROP_CENTER, 1006, 670)
            ->save( public_path( 'storage\\'.$this->tempImagePath.'/'.$imageNameSlot456 ));

        Image::load (public_path( 'storage' . $image ) )
            ->crop(Manipulations::CROP_CENTER, 737, 737)
            ->save( public_path( 'storage\\'.$this->tempImagePath.'/'.$imageNameYouMightLike ));

        $this->summaryImageSlot1Preview = '\storage\\'.$this->tempImagePath.'/'.$imageNameSlot1.'?'.$version;//versions the file to prevent caching
        $this->summaryImageSlot23Preview = '\storage\\'.$this->tempImagePath.'/'.$imageNameSlot23.'?'.$version;//versions the file to prevent caching
        $this->summaryImageSlot456Preview = '\storage\\'.$this->tempImagePath.'/'.$imageNameSlot456.'?'.$version;//versions the file to prevent caching
        $this->summaryImageYouMightLikePreview = '\storage\\'.$this->tempImagePath.'/'.$imageNameYouMightLike.'?'.$version;//versions the file to prevent caching

    }



    public function render()
    {

        return view('livewire.admin.content-article-form');

    }

}
