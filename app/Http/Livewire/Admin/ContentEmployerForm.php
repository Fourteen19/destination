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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Services\Admin\ContentEmployerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContentEmployerForm extends Component
{

    use AuthorizesRequests;

    protected $listeners = ['make_banner_image' => 'makeBannerImage',
                            'make_summary_image' => 'makeSummaryImage',
                            'make_related_download' => 'makeRelatedDownload',
                            'make_related_image' => 'makeRelatedImage',
                            'update_videos_order' => 'updateVideosOrder',
                            'update_links_order' => 'updateLinksOrder',
                            'update_downloads_order' => 'updateDownloadsOrder',
                            ];

    public $title, $slug, $type, $lead, $subheading, $body, $alt_block_heading, $alt_block_text, $lower_body, $summary_heading, $summary_text, $introduction;
    public $action;
    public $baseUrl;
    public $currentUrl;
    public $activeTab;
    public $isGlobal = 0;
    public $contentType = 'employer';

    public $banner;
    public $banner_alt;
    public $bannerOriginal;
    public $bannerImagePreview;

    public $summary_image_type;
    public $summary;
    public $summaryOriginal;
    public $summaryImageSlotPreview;
/*     public $summaryImageSlot1Preview;
    public $summaryImageSlot23Preview;
    public $summaryImageSlot456Preview;
    public $summaryImageYouMightLikePreview;
    public $summaryImageSearchPreview; */
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
        'relatedImages.*.alt' => 'required',
        'relatedImages.*.url' => 'required',



    ];


    protected $messages = [
        'slug.unique' => 'This URL has already been taken',

        'relatedVideos.*.url.required' => 'The URL is required',

        'relatedLinks.*.title.required' => 'The title is required',
        'relatedLinks.*.url.required' => 'The URL is required',

        'relatedDownloads.*.title.required' => 'The title is required',
        'relatedDownloads.*.url.required' => 'The URL is required',

        'relatedImages.*.alt.required' => 'The ALT Tag is required',
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


        $this->baseUrl = get_base_employer_url(); //from url custom helper

        $this->currentUrl = url()->current();
        if(strpos(url()->current(), '/global/') !== false){
            $this->isGlobal = 1;

            $this->canMakeContentLive = Auth::guard('admin')->user()->hasAnyPermission('global-content-make-live');

            $this->tempImagePath = "global";

        } else {
            $this->isGlobal = 0;

            $this->canMakeContentLive = Auth::guard('admin')->user()->hasAnyPermission('client-content-make-live');

            $clientData = app('clientService')->getClientDetails( session()->get('adminClientSelectorSelection') );
            $this->tempImagePath = $clientData['subdomain'];

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
            $this->introduction = $content->contentable->introduction;
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
                $bannerUrl = parse_encode_url($banner->getUrl());
                $this->banner = $banner->getCustomProperty('folder'); //relative path in field
                $this->bannerOriginal = $bannerUrl;//$banner->getCustomProperty('folder'); //$banner->getFullUrl();
                $this->banner_alt = $banner->getCustomProperty('alt');
                $this->bannerImagePreview = $bannerUrl;//$banner->getUrl();//$banner->getUrl('banner'); // retrieves URL of converted image
            }


            $summary = $content->getMedia('summary')->first();
            if ($summary)
            {
                $this->summary = $summary->getCustomProperty('folder'); //relative path in field
                $this->summaryOriginal = $summary->getCustomProperty('folder');
                $this->summaryImageSlotPreview = $summary->getUrl();
               /*  $this->summaryImageSlot1Preview = $summary->getUrl('summary_slot1'); // retrieves URL of converted image
                $this->summaryImageSlot23Preview = $summary->getUrl('summary_slot2-3'); // retrieves URL of converted image
                $this->summaryImageSlot456Preview = $summary->getUrl('summary_slot4-5-6'); // retrieves URL of converted image
                $this->summaryImageYouMightLikePreview = $summary->getUrl('summary_you_might_like'); // retrieves URL of converted image
                $this->summaryImageSearchPreview =  $summary->getUrl('search'); // retrieves URL of converted image */
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


        $this->tagsLscs = SystemTag::select('uuid', 'name')->where('type', 'career_readiness')->where('live', 'Y')->get()->toArray();
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

        $this->tagsTerms = SystemTag::select('uuid', 'name')->where('type', 'term')->where('live', 'Y')->get()->toArray();
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

        $this->tagsRoutes = SystemTag::select('uuid', 'name')->where('type', 'route')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $contentRoutesTags = $content->tagsWithType('route');
        foreach($contentRoutesTags as $key => $value){
            $this->contentRoutesTags[] = $value['name'];
        }

        $this->tagsSectors = SystemTag::select('uuid', 'name')->where('type', 'sector')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $contentSectorsTags = $content->tagsWithType('sector');
        foreach($contentSectorsTags as $key => $value){
            $this->contentSectorsTags[] = $value['name'];
        }

        $this->tagsSubjects = SystemTag::select('uuid', 'name')->where('type', 'subject')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $contentSubjectTags = $content->tagsWithType('subject');
        foreach($contentSubjectTags as $key => $value){
            $this->contentSubjectTags[] = $value['name'];
        }

        $this->tagsFlags = SystemTag::select('uuid', 'name')->where('type', 'flag')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $contentFlagTags = $content->tagsWithType('flag');
        foreach($contentFlagTags as $key => $value){
            $this->contentFlagTags[] = $value['name'];
        }

        $this->tagsNeet = SystemTag::select('uuid', 'name')->where('type', 'neet')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $contentNeetTags = $content->tagsWithType('neet');
        foreach($contentNeetTags as $key => $value){
            $this->contentNeetTags[] = $value['name'];
        }

        $this->tagsKeywords = SystemTag::select('uuid', 'name')->where('type', 'keyword')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
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
                $previewPath = parse_encode_url($value->getUrl()); //$previewPath = parse_url($value->getUrl('supporting_images'));

                $this->relatedImages[] = [
                    'title' => $value->getCustomProperty('title'),
                    'alt' => $value->getCustomProperty('alt'),
                    'url' => $value->getCustomProperty('folder'),
                    'open_link' => $previewPath,
                    'preview' => $previewPath,
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
        $this->relatedVideos[] = ['url' => '', 'title' => ''];
    }

    /**
     * Add a link
     */
    public function addRelatedLink()
    {
        $this->relatedLinks[] = ['title' => '', 'url' => ''];
    }

    /**
     * Add a download
     */
    public function addRelatedDownload()
    {
        $this->relatedDownloads[] = ['title' => '', 'url' => '', 'open_link' => ''];
    }

    /**
     * Add an image
     */
    public function addRelatedImage()
    {
        $this->relatedImages[] = ['title' => '', 'alt' => '', 'url' => '', 'open_link' => '', 'preview' => ''];
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
     * Remove an image
     */
    public function removeRelatedImage($relatedImagesIteration)
    {
        unset($this->relatedImages[$relatedImagesIteration]);
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
                            $this->generateSlugUniqueRule()
                        ]

                    ]);

        }elseif ($propertyName == "lead"){

            $this->summary_text = $this->lead;

        } else {
            $this->validateOnly($propertyName);
        }

    }



    public function removeTempImagefolder()
    {
        Storage::disk('public')->deleteDirectory($this->tempImagePath);
    }



    /**
     * updateVideosOrder
     *
     * @param  mixed $videosOrder
     * @return void
     */
    public function updateVideosOrder($videosOrder)
    {

        $videosOrder = explode(",", $videosOrder);

        $tmpVideos = [];

        foreach($videosOrder as $key => $value)
        {
            $tmpVideos[] = $this->relatedVideos[$value];
        }

        $this->relatedVideos = $tmpVideos;

    }



    /**
     * updateDownloadsOrder
     *
     * @param  mixed $downloadsOrder
     * @return void
     */
    public function updateDownloadsOrder($downloadsOrder)
    {
        $downloadsOrder = explode(",", $downloadsOrder);

        $tmpDownloads = [];

        foreach($downloadsOrder as $key => $value)
        {
            $tmpDownloads[] = $this->relatedDownloads[$value];
        }

        $this->relatedDownloads = $tmpDownloads;

    }


    /**
     * updateLinksOrder
     *
     * @param  mixed $linksOrder
     * @return void
     */
    public function updateLinksOrder($linksOrder)
    {
        $linksOrder = explode(",", $linksOrder);

        $tmpLinks = [];

        foreach($linksOrder as $key => $value)
        {
            $tmpLinks[] = $this->relatedLinks[$value];
        }

        $this->relatedLinks = $tmpLinks;

    }




    public function generateSlugUniqueRule()
    {

        if ($this->isGlobal == 1)
        {
            //search the `contents` table for the slug name in all clients, ignores our current content
            $slugUniqueRule = Rule::unique('contents')->whereNot('uuid', $this->contentUuid);
        } else {
            //search the `contents` table for the slug name in all clients, ignores our current content
            $slugUniqueRule = Rule::unique('contents')->whereNot('uuid', $this->contentUuid)
                                                    ->where(function ($query) {
                                                        $query->where('client_id', "=", session()->get('adminClientSelectorSelected') );
                                                        $query->orWhere('client_id', "=", NULL);
                                                    });

        }

        return $slugUniqueRule;

    }



    /**
     * store
     * $param contains the actions that need to be done by the store function
     *
     * @param  mixed $param
     * @return void
     */
    public function store($param)
    {

        //The slug must be checked against global and client content
        $this->rules['slug'] = [ 'required',
                                 'alpha_dash',
                                 $this->generateSlugUniqueRule()
                                ];


        $this->validate($this->rules, $this->messages);

        $verb = ($this->action == 'add') ? 'Created' : 'Updated';

        DB::beginTransaction();

        try {

            $this->contentService = new ContentEmployerService();

            //if the 'live' action needs to be processed
            if (strpos($param, 'live') !== false) {
                $this->contentService->storeAndMakeLive($this);
            } else {
                $newContent = $this->contentService->store($this);

                //this line is required when creating an article
                //after saving the article, the contentUuid variable is set and the article can now be edited
                $this->contentUuid = $newContent->uuid;
                $this->action = 'edit';
            }

            DB::commit();

            Session::flash('success', 'Content '.$verb.' Successfully');

        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('fail', 'Content could not be '.$verb.' Successfully');

        }


        //if the 'exit' action needs to be processed
        if (strpos($param, 'exit') !== false)
        {

            $this->removeTempImagefolder();

            $routeSegment = ($this->isGlobal == 1) ? '.global' : '';

            return redirect()->route('admin'.$routeSegment.'.contents.index');

        } else {

        }

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

        //encodes the URL
        $encodedFilePath = parse_encode_url($url);

        //extracts the ID of image
        $relatedImageId = Str::between($field, 'file_relatedImages[', "]['url']");
        $this->relatedImages[$relatedImageId]['url'] = $url;
        $this->relatedImages[$relatedImageId]['open_link'] = $encodedFilePath;

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

        $this->resetErrorBag('banner');
/*
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
 */
        return $error = 0;
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

        $this->resetErrorBag('summary');
/*
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
 */
        return $error = 0;
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

            //split the string, encode the parts and join the string together again.
            $this->bannerOriginal = implode('/', array_map('rawurlencode', explode('/', $image)));//relative path of image selected. displays the image

            //generates preview filename
            $imageName = "preview_banner.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( $image ) )
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
            $imageNameSlot = "preview_summary_slot.".$fileDetails['extension'];

            //generates image conversions
            Image::load (public_path( $image ) )
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageNameSlot ));

            //assigns preview images
            $this->summaryImageSlotPreview = '/storage/'.$this->tempImagePath.'/'.$imageNameSlot.'?'.$version;//versions the file to prevent caching

        }
    }



    public function render()
    {

        return view('livewire.admin.content-employer-form');

    }

}
