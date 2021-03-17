<?php

namespace App\Http\Livewire\Admin;

use Livewire\Request;
use App\Models\Content;
use Livewire\Component;
use Spatie\Image\Image;
use App\Models\SystemTag;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Services\Admin\ContentArticleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContentArticleForm extends Component
{

    use AuthorizesRequests;

    protected $listeners = ['make_banner_image' => 'makeBannerImage',
                            'make_summary_image' => 'makeSummaryImage',
                            'make_related_download' => 'makeRelatedDownload',
                            'make_related_image' => 'makeRelatedImage',
                            ];

    public $title, $slug, $type, $lead, $subheading, $body, $alt_block_heading, $alt_block_text, $lower_body, $summary_heading, $summary_text;
    public $action;
    public $baseUrl;
    public $currentUrl;
    public $activeTab;
    public $isGlobal = 0;

    public $banner;
    public $banner_alt;
    public $bannerOriginal;
    public $bannerImagePreview;

    public $summary_image_type;
    public $summary;
    public $summaryOriginal;
    public $summaryImageSlot1Preview;
    public $summaryImageSlot23Preview;
    public $summaryImageSlot456Preview;
    public $summaryImageYouMightLikePreview;
    public $summaryImageSearchPreview;
    public $summaryImageIsVisible; //used with alpine - @entangle

    public $supportingImages;

    public $relatedVideosIteration = 1;
    public $relatedLinksIteration = 1;
    public $relatedDownloadsIteration = 1;
    public $relatedImagesIteration = 1;
    public $relatedVideos = [];
    public $relatedLinks = [];
    public $relatedDownloads = [];
    public $relatedImages = [];

    public $content;
    public $contentUuid;
    public $tagsKeywords, $tagsSubjects, $tagsYearGroups, $tagsTerms, $tagsLscs, $tagsRoutes, $tagsSectors, $tagsFlags, $tagsNeet;
    public $contentKeywordTags = [];
    public $contentSubjectTags = [];
    public $contentTermsTags = [];
    public $contentYearGroupsTags = [];
    public $contentLscsTags = [];
    public $contentRoutesTags = [];
    public $contentSectorsTags = [];
    public $contentFlagTags = [];
    public $contentNeetTags = [];

    public $canMakeContentLive;


    public $tempImagePath;

    protected $rules = [
        'title' => 'required',

        'banner' => 'required',

        'summary_image_type' => 'required',
        'summary_heading'=> 'required',
        'summary_text' => 'required',
        'summary' => 'requiredIf:summary_image_type,Custom',

        'supportingImages.*.url' => 'required',
        'relatedVideos.*.url' => 'required',
        'relatedLinks.*.title' => 'required',
        'relatedLinks.*.url' => 'required',
        'relatedDownloads.*.title' => 'required',
        'relatedDownloads.*.url' => 'required',
        'relatedImages.*.title' => 'required',
        'relatedImages.*.url' => 'required',



    ];


    protected $messages = [
        'slug.unique' => 'The slug has already been taken. Please modify your title',

        'relatedVideos.*.url.required' => 'The URL is required',

        'relatedLinks.*.title.required' => 'The title is required',
        'relatedLinks.*.url.required' => 'The URL is required',

        'relatedDownloads.*.title.required' => 'The title is required',
        'relatedDownloads.*.url.required' => 'The URL is required',

        'relatedImages.*.title.required' => 'The title is required',
        'relatedImages.*.url.required' => 'The URL is required',

        'summary.required_if' => "The summary image is required when your summary image type is set to 'Custom'",

    ];


    //setup of the component
    public function mount(String $action, String $contentUuid)
    {

        $this->action = $action;

        if ($action == 'add'){
            $content = new Content;
            $this->authorize('create', $content);
        } else {
            $content = Content::where('uuid', $contentUuid)->firstOrFail();
            $this->authorize('update', $content);
        }


        $this->baseUrl = get_base_article_url(); //from url custom helper

        $this->currentUrl = url()->current();
        if(strpos(url()->current(), '/global/') !== false){
            $this->isGlobal = 1;
        } else {
            $this->isGlobal = 0;
        }

        //checks if the admin user can make content live
        //sets a flag used to display the "make live" button
        if ($this->isGlobal == 0){
            $this->canMakeContentLive = Auth::guard('admin')->user()->hasAnyPermission('client-content-make-live');
        } else{
            $this->canMakeContentLive = Auth::guard('admin')->user()->hasAnyPermission('global-content-make-live');
        }

        //preview images are saved a temp folder
        if (!empty(Auth::guard('admin')->user()->client))
        {
            $this->tempImagePath = Auth::guard('admin')->user()->client->subdomain;
        } else {
            $this->tempImagePath = "global";
        }
        $this->tempImagePath = $this->tempImagePath.'/preview_images/'.Str::random(32);
        Storage::disk('public')->makeDirectory($this->tempImagePath);

        if ($action == 'edit')
        {

            $this->title = $content->title;
            $this->slug = $content->slug;
            $this->type = $content->contentable->type;
            $this->lead = $content->contentable->lead;
            $this->subheading = $content->contentable->subheading;
            $this->body = $content->contentable->body;
            $this->alt_block_heading = $content->contentable->alt_block_heading;
            $this->alt_block_text = $content->contentable->alt_block_text;
            $this->lower_body = $content->contentable->lower_body;
            $this->summary_heading = $content->summary_heading;
            $this->summary_text = $content->summary_text;
            $this->summary_image_type = $content->summary_image_type;

            $banner = $content->getMedia('banner')->first();
//            dd( public_path() ); "C:\rfmedia_projects\projects\ckcorp\public"
//            dd( resource_path() );// "C:\rfmedia_projects\projects\ckcorp\resources"
//            dd( asset('testfile.txt') );// "http://ck.platformbrand.com:8000/testfile.txt"
//            dd( storage_path('app/file.txt') ); //"C:\rfmedia_projects\projects\ckcorp\storage\app/file.txt"
//            dd( app_path('app/file.txt') ); //"C:\rfmedia_projects\projects\ckcorp\app\app/file.txt"
            if ($banner)
            {
                $this->banner = $banner->getCustomProperty('folder'); //relative path in field
                $this->bannerOriginal = $banner->getCustomProperty('folder'); //$banner->getFullUrl();
                $this->banner_alt = $banner->getCustomProperty('alt');
                $this->bannerImagePreview = $banner->getUrl('banner'); // retrieves URL of converted image
            }


            $summary = $content->getMedia('summary')->first();
            if ($summary)
            {
                $this->summary = $summary->getCustomProperty('folder'); //relative path in field
                $this->summaryOriginal = $summary->getCustomProperty('folder');
                $this->summaryImageSlot1Preview = $summary->getUrl('summary_slot1'); // retrieves URL of converted image
                $this->summaryImageSlot23Preview = $summary->getUrl('summary_slot2-3'); // retrieves URL of converted image
                $this->summaryImageSlot456Preview = $summary->getUrl('summary_slot4-5-6'); // retrieves URL of converted image
                $this->summaryImageYouMightLikePreview = $summary->getUrl('summary_you_might_like'); // retrieves URL of converted image
            }

        } else {

            $this->summary_image_type = 'Automatic';

        }




        if ($this->summary_image_type == 'Automatic')
        {
            $this->summaryImageIsVisible = False;
        } else {
            $this->summaryImageIsVisible = True;
        }


        $this->tagsYearGroups = SystemTag::select('uuid', 'name')->where('type', 'year')->get()->toArray();
        if ($action == 'add')
        {
            foreach($this->tagsYearGroups as $key => $value){
                $this->contentYearGroupsTags[] = $value['name'][ app()->getLocale() ];
            }
        } else {
            $contentYearGroupsTags = $content->tagsWithType('year');
            foreach($contentYearGroupsTags as $key => $value){
                $this->contentYearGroupsTags[] = $value['name'];
            }
        }


        $this->tagsLscs = SystemTag::select('uuid', 'name')->where('type', 'career_readiness')->get()->toArray();
        if ($action == 'add')
        {
            foreach($this->tagsLscs as $key => $value){
                $this->contentLscsTags[] = $value['name'][ app()->getLocale() ];
            }
        } else {
            $contentLscsTags = $content->tagsWithType('career_readiness');
            foreach($contentLscsTags as $key => $value){
                $this->contentLscsTags[] = $value['name'];
            }
        }

        $this->tagsTerms = SystemTag::select('uuid', 'name')->where('type', 'term')->get()->toArray();
        if ($action == 'add')
        {
            foreach($this->tagsTerms as $key => $value){
                $this->contentTermsTags[] = $value['name'][ app()->getLocale() ];
            }
        } else {
            $contentTermsTags = $content->tagsWithType('term');
            foreach($contentTermsTags as $key => $value){
                $this->contentTermsTags[] = $value['name'];
            }
        }

        $this->tagsRoutes = SystemTag::select('uuid', 'name')->where('type', 'route')->get()->toArray();
        $contentRoutesTags = $content->tagsWithType('route');
        foreach($contentRoutesTags as $key => $value){
            $this->contentRoutesTags[] = $value['name'];
        }

        $this->tagsSectors = SystemTag::select('uuid', 'name')->where('type', 'sector')->get()->toArray();
        $contentSectorsTags = $content->tagsWithType('sector');
        foreach($contentSectorsTags as $key => $value){
            $this->contentSectorsTags[] = $value['name'];
        }

        $this->tagsSubjects = SystemTag::select('uuid', 'name')->where('type', 'subject')->get()->toArray();
        $contentSubjectTags = $content->tagsWithType('subject');
        foreach($contentSubjectTags as $key => $value){
            $this->contentSubjectTags[] = $value['name'];
        }

        $this->tagsFlags = SystemTag::select('uuid', 'name')->where('type', 'flag')->get()->toArray();
        $contentFlagTags = $content->tagsWithType('flag');
        foreach($contentFlagTags as $key => $value){
            $this->contentFlagTags[] = $value['name'];
        }

        $this->tagsNeet = SystemTag::select('uuid', 'name')->where('type', 'neet')->get()->toArray();
        $contentNeetTags = $content->tagsWithType('neet');
        foreach($contentNeetTags as $key => $value){
            $this->contentNeetTags[] = $value['name'];
        }

        $this->tagsKeywords = SystemTag::select('uuid', 'name')->where('type', 'keyword')->get()->toArray();
        $contentKeywordTags = $content->tagsWithType('keyword');
        foreach($contentKeywordTags as $key => $value){
            $this->contentKeywordTags[] = $value['name'];
        }

        $this->relatedVideos = $content->relatedVideos->toArray();

        $this->relatedLinks = $content->relatedLinks->toArray();



        $relatedDownloads = $content->getMedia('supporting_downloads');
        if (count($relatedDownloads) > 0)
        {
            foreach($relatedDownloads as $key => $value)
            {
                $tmpPath = parse_url($value->getUrl());

                $this->relatedDownloads[] = [
                    'title' => $value->getCustomProperty('title'),
                    'url' => $value->getCustomProperty('folder'),
                    'open_link' => $tmpPath['path']
                ];
            }
        }


        $relatedImages = $content->getMedia('supporting_images');
        if (count($relatedImages) > 0)
        {
            foreach($relatedImages as $key => $value)
            {
                //gets the URL of the conversion
                $previewPath = parse_url($value->getUrl('supporting_images'));

                $this->relatedImages[] = [
                    'title' => $value->getCustomProperty('title'),
                    'url' => $value->getCustomProperty('folder'),
                    'open_link' => $value->getCustomProperty('folder'),
                    'preview' => $previewPath['path'],
                ];
            }
        }

        $this->activeTab = "article-settings";

    }


    /**
     * Keeps track of the active Tab
     *
     */
    public function updateTab($tabName)
    {
        $this->activeTab = $tabName;
    }


    /**
     * Add a video
     */
    public function addRelatedVideo()
    {
        $this->relatedVideos[] = ['url' => ''];
        $this->updateTab('videos');
    }

    /**
     * Add a link
     */
    public function addRelatedLink()
    {
        $this->relatedLinks[] = ['title' => '', 'url' => ''];
        $this->updateTab('links');
    }

    /**
     * Add a download
     */
    public function addRelatedDownload()
    {
        $this->relatedDownloads[] = ['title' => '', 'url' => '', 'open_link' => ''];
        $this->updateTab('downloads');
    }

    /**
     * Add an image
     */
    public function addRelatedImage()
    {
        $this->relatedImages[] = ['title' => '', 'url' => '', 'open_link' => '', 'preview' => ''];
        $this->updateTab('images');
    }

    /**
     * Remove a video
     */
    public function removeRelatedVideo($relatedVideosIteration)
    {
        unset($this->relatedVideos[$relatedVideosIteration]);
        $this->updateTab('videos');
    }

    /**
     * Remove a link
     */
    public function removeRelatedLink($relatedLinksIteration)
    {
        unset($this->relatedLinks[$relatedLinksIteration]);
        $this->updateTab('links');
    }

    /**
     * Remove a download
     */
    public function removeRelatedDownload($relatedDownloadsIteration)
    {
        unset($this->relatedDownloads[$relatedDownloadsIteration]);
        $this->updateTab('downloads');
    }

    /**
     * Remove an image
     */
    public function removeRelatedImage($relatedImagesIteration)
    {
        unset($this->relatedImages[$relatedImagesIteration]);
        $this->updateTab('images');
    }


    /**
     * Validate single a field
     */
    public function updated($propertyName)
    {


        if ($propertyName == "title"){
            $this->summary_heading = $this->title;

            $this->slug = Str::slug($this->title);

            $this->validateOnly('slug', [
                'slug' => [ 'required',
                            'alpha_dash',
                            //search the `contents` table for the slug name, ignores our current content
                            Rule::unique('contents')->whereNot('uuid', $this->contentUuid),
                        ]

                    ]);

        }elseif ($propertyName == "lead"){

            $this->summary_text = $this->lead;

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
                                Rule::unique('contents')->whereNot('uuid', $this->contentUuid),
                                ];

        $this->validate($this->rules, $this->messages);

        $this->contentService = new ContentArticleService();
        $this->contentService->storeAndMakeLive($this);

        $this->removeTempImagefolder();


        $routeSegment = ($this->isGlobal == 1) ? '.global' : '';

        return redirect()->route('admin'.$routeSegment.'.contents.index');

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


        //The slug must be checked against global and client content
        $this->rules['slug'] = [ 'required',
                                'alpha_dash',
                                //search the `contents` table for the slug name, ignores our current content
                                Rule::unique('contents')->whereNot('uuid', $this->contentUuid),
                                ];

        $this->validate($this->rules, $this->messages);

        try {

            $this->contentService = new ContentArticleService();
            $this->contentService->store($this);

            Session::flash('success', 'Content Created Successfully');


        } catch (\Exception $e) {

            Session::flash('fail', 'Content not Created Successfully');

        }



        /* if ($this->action == 'add')
        { */

            $this->removeTempImagefolder();

            $routeSegment = ($this->isGlobal == 1) ? '.global' : '';

            return redirect()->route('admin'.$routeSegment.'.contents.index');

       /*  } */

    }


    public function makeRelatedDownload($field, $url)
    {

        $relatedDownloadId = Str::between($field, 'file_relatedDownloads[', "]['url']");
        $this->relatedDownloads[$relatedDownloadId]['url'] = $url;
        $this->relatedDownloads[$relatedDownloadId]['open_link'] = $url;

    }



    public function makeRelatedImage($field, $url)
    {

        $version = date("YmdHis");

        //Returns information about a file path
        $fileDetails = pathinfo($url);

        //extracts the ID of image
        $relatedImageId = Str::between($field, 'file_relatedImages[', "]['url']");
        $this->relatedImages[$relatedImageId]['url'] = $url;
        $this->relatedImages[$relatedImageId]['open_link'] = $url;

        //generates preview filename
        $imageName = "preview_supp_image_".$relatedImageId.".".$fileDetails['extension'];

        //generates Image conversion
         Image::load (public_path( $url ) )
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageName ));

        //stores the preview filename in array
        $this->relatedImages[$relatedImageId]['preview'] = '/storage/'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

    }


    /**
     * bannerValidation
     * Custom validation on the banner
     *
     * @param  mixed $image
     * @return void
     */
    public function bannerValidation($image)
    {
        //gets image information for validation
        $error = 0;
        list($width, $height, $type, $attr) = getimagesize( public_path($image) );

        $dimensionsErrorMessage = __('ck_admin.articles.banner.upload.error_messages.dimensions', ['width' => config('global.articles.banner.upload.required_size.width'), 'height' => config('global.articles.banner.upload.required_size.height') ]);

        //dimension validation
        if ( ($width != config('global.articles.banner.upload.required_size.width')) || ($height < config('global.articles.banner.upload.required_size.height')) )
        {
            $error = 1;
            $this->addError('banner', $dimensionsErrorMessage);
        }

        //if no error was found with the image dimensions, we check the image type
        if ($error == 0)
        {

            // 1	IMAGETYPE_GIF
            // 2	IMAGETYPE_JPEG
            // 3	IMAGETYPE_PNG
            // 18	IMAGETYPE_WEBP
            if (!in_array( exif_imagetype(public_path($image)) , [1, 2, 3, 18]) )
            {
                $error = 1;
                $this->addError('summary', __('ck_admin.articles.summary.upload.error_messages.type') );
            }

        }

        return $error;
    }

    /**
     * summaryImageValidation
     * Custom validation on the banner
     *
     * @param  mixed $image
     * @return void
     */
    public function summaryImageValidation($image)
    {
        //gets image information for validation
        $error = 0;
        list($width, $height, $type, $attr) = getimagesize( public_path($image) );

        $dimensionsErrorMessage = __('ck_admin.articles.summary.upload.error_messages.dimensions', ['width' => config('global.articles.summary.upload.required_size.width'), 'height' => config('global.articles.summary.upload.required_size.height') ]);

        //dimension validation
        if ( ($width != config('global.articles.summary.upload.required_size.width')) || ($height < config('global.articles.summary.upload.required_size.height')) )
        {
            $error = 1;
            $this->addError('summary', $dimensionsErrorMessage);
        }


        //if no error was found with the image dimensions, we check the image type
        if ($error == 0)
        {
            // 1	IMAGETYPE_GIF
            // 2	IMAGETYPE_JPEG
            // 3	IMAGETYPE_PNG
            // 18	IMAGETYPE_WEBP
            if (!in_array( exif_imagetype(public_path($image)) , [1, 2, 3, 18]) )
            {

                $error = 1;
                $this->addError('summary', __('ck_admin.articles.summary.upload.error_messages.type') );
            }

        }

        return $error;
    }


    public function makeBannerImage($image)
    {

        //Returns information about a file path
        $fileDetails = pathinfo($image);

        if ($this->bannerValidation($image) == FALSE)
        {

            $this->resetErrorBag('banner');

            $version = date("YmdHis");

            $this->banner = $image; //relative path in field
            $this->bannerOriginal = $image; //relative path of image selected. displays the image

            //generates preview filename
            $imageName = "preview_banner.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( $image ) )
                ->crop(Manipulations::CROP_CENTER, 2074, 798)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageName ));

            //assigns the preview filename
            $this->bannerImagePreview = '/storage/'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

            //if automatic
            if ($this->summary_image_type == 'Automatic')
            {
                //generates the summary image
                $this->makeSummaryImage($image);
            }

        }

        $this->updateTab('banner-image');

    }


    public function makeSummaryImage($image)
    {

        $error = 1;
        if ($this->summary_image_type == 'Custom')
        {

            if ($this->summaryImageValidation($image) == FALSE)
            {
                $error = 0;

                $this->summary = $image; //relative path in field
                $this->summaryOriginal = $image; //relative path of image selected. displays the image
            }

        } elseif ($this->summary_image_type == 'Automatic') {
            $error = 0;
        }



        if ($error == 0)
        {

            //clears error for summary images
            $this->resetErrorBag('summary');

            $version = date("YmdHis");

            //Returns information about a file path
            $fileDetails = pathinfo($image);

            //assigns the preview filename
            $imageNameSlot1 = "preview_summary_slot_1.".$fileDetails['extension'];
            $imageNameSlot23 = "preview_summary_slot_23.".$fileDetails['extension'];
            $imageNameSlot456 = "preview_summary_slot_456.".$fileDetails['extension'];
            $imageNameYouMightLike = "preview_summary_you_might_like.".$fileDetails['extension'];
            $imageNameSearch = "preview_summary_search.".$fileDetails['extension'];

            //generates image conversions
            Image::load (public_path( $image ) )
                ->crop(Manipulations::CROP_CENTER, 2074, 1056)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageNameSlot1 ));

            Image::load (public_path(  $image ) )
                ->crop(Manipulations::CROP_CENTER, 771, 512)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageNameSlot23 ));

            Image::load (public_path( $image ) )
                ->crop(Manipulations::CROP_CENTER, 1006, 670)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageNameSlot456 ));

            Image::load (public_path( $image ) )
                ->crop(Manipulations::CROP_CENTER, 737, 737)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageNameYouMightLike ));

            Image::load (public_path( $image ) )
                ->crop(Manipulations::CROP_CENTER, 1274, 536)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageNameSearch ));

            //assigns preview images
            $this->summaryImageSlot1Preview = '/storage/'.$this->tempImagePath.'/'.$imageNameSlot1.'?'.$version;//versions the file to prevent caching
            $this->summaryImageSlot23Preview = '/storage/'.$this->tempImagePath.'/'.$imageNameSlot23.'?'.$version;//versions the file to prevent caching
            $this->summaryImageSlot456Preview = '/storage/'.$this->tempImagePath.'/'.$imageNameSlot456.'?'.$version;//versions the file to prevent caching
            $this->summaryImageYouMightLikePreview = '/storage/'.$this->tempImagePath.'/'.$imageNameYouMightLike.'?'.$version;//versions the file to prevent caching
            $this->summaryImageSearchPreview = '/storage/'.$this->tempImagePath.'/'.$imageNameSearch.'?'.$version;//versions the file to prevent caching

        }
    }



    public function render()
    {

        return view('livewire.admin.content-article-form');

    }

}
