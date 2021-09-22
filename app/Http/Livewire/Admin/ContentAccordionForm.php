<?php

namespace App\Http\Livewire\Admin;

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
use App\Services\Admin\ContentAccordionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContentAccordionForm extends Component
{

    use AuthorizesRequests;

    protected $listeners = ['make_banner_image' => 'makeBannerImage',
                            'make_summary_image' => 'makeSummaryImage',
                            'make_related_download' => 'makeRelatedDownload',
                            'make_related_image' => 'makeRelatedImage',
                            'article_selector' => 'articleSelector',
                            'update_videos_order' => 'updateVideosOrder',
                            'update_links_order' => 'updateLinksOrder',
                            'update_downloads_order' => 'updateDownloadsOrder',
                            ];

    public $title, $slug, $type, $lead, $subheading, $body, $alt_block_heading, $alt_block_text, $lower_body, $summary_heading, $summary_text;
    public $action;
    public $baseUrl;
    public $currentUrl;
    public $activeTab;
    public $isGlobal = 0;
    public $contentType = 'accordion';

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

    public $read_next_article = NULL;

    public $supportingImages;

    public $relatedVideosIteration = 1;
    public $relatedLinksIteration = 1;
    public $relatedDownloadsIteration = 1;
    public $relatedImagesIteration = 1;
    public $relatedVideos = [];
    public $relatedLinks = [];
    public $relatedDownloads = [];
    public $relatedImages = [];
    public $relatedQuestions = [];

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
    public $allYears, $allTerms;

    public $canMakeContentLive;

    public $tempImagePath;

    protected $rules = [
        'title' => 'required',

        'banner' => 'required|file_exists',

        'summary_image_type' => 'required',
        'summary_heading'=> 'required',
        'summary_text' => 'required',
        'summary' => 'requiredIf:summary_image_type,Custom|file_exists',

        'supportingImages.*.url' => 'required',
        'relatedLinks.*.title' => 'required',
        'relatedLinks.*.url' => 'required',
        'relatedDownloads.*.title' => 'required',
        'relatedDownloads.*.url' => 'required|file_exists',
        'relatedImages.*.alt' => 'required',
        'relatedImages.*.url' => 'required|file_exists',

    ];


    protected $messages = [
        'slug.unique' => 'This URL has already been taken',

        'banner.file_exists' =>  'The banner image file you selected does not exist anymore. Please select another file or find the same file if it has been moved.',

        'relatedLinks.*.title.required' => 'The title is required',
        'relatedLinks.*.url.required' => 'The URL is required',

        'relatedDownloads.*.title.required' => 'The title is required',
        'relatedDownloads.*.url.required' => 'The URL is required',
        'relatedDownloads.*.url.file_exists' => 'The file you selected does not exist anymore at this location. Please select another file or find the same file if it has been moved.',

        'relatedImages.*.alt.required' => 'The ALT Tag is required',
        'relatedImages.*.url.required' => 'The URL is required',
        'relatedImages.*.url.file_exists' => 'The image you selected does not exist anymore at this location. Please select another file or find the same file if it has been moved.',

        'summary.required_if' => "The summary image is required when your summary image type is set to 'Custom'",
        'summary.file_exists' => 'The summary image file you selected does not exist anymore. Please select another file or find the same file if it has been moved.',
    ];


    //setup of the component
    public function mount(String $action, String $contentUuid)
    {

        $this->action = $action;

        if ($action == 'add'){
            $content = new Content;
            $this->authorize('create', $content);
        } else {
            $content = Content::where('uuid', $this->contentUuid)->firstOrFail();
            $this->authorize('update', $content);
        }

        $this->baseUrl = get_base_article_url();


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
            $this->summary_heading = $content->summary_heading;
            $this->summary_text = $content->summary_text;
            $this->summary_image_type = $content->summary_image_type;

            if (!empty($content->read_next_article_id))
            {
                $readNextContent = Content::select('uuid', 'title')->where('id', $content->read_next_article_id)->firstOrFail();
                $this->read_next_article = $readNextContent->uuid;
            }

            $banner = $content->getMedia('banner')->first();
            if ($banner)
            {
                $bannerUrl = parse_encode_url($banner->getUrl());
                $this->banner = $banner->getCustomProperty('folder'); //relative path in field
                $this->bannerOriginal =  $bannerUrl;
                $this->banner_alt = $banner->getCustomProperty('alt');
                $this->bannerImagePreview =  $bannerUrl;
                /* if ($this->summary_image_type == 'Automatic')
                {
                    $this->summaryImageSlotPreview = $bannerUrl;
                } */
            }

            $summary = $content->getMedia('summary')->first();
            if ($summary)
            {
                $summaryUrl = parse_encode_url($summary->getUrl());
                $this->summary = $summary->getCustomProperty('folder'); //relative path in field
                $this->summaryOriginal = $summaryUrl;
                $this->summaryImageSlot1Preview = $summary->getUrl('summary_slot1'); // retrieves URL of converted image
                $this->summaryImageSlot23Preview = $summary->getUrl('summary_slot2-3'); // retrieves URL of converted image
                $this->summaryImageSlot456Preview = $summary->getUrl('summary_slot4-5-6'); // retrieves URL of converted image
                $this->summaryImageYouMightLikePreview = $summary->getUrl('summary_you_might_like'); // retrieves URL of converted image
                $this->summaryImageSearchPreview =  $summary->getUrl('search'); // retrieves URL of converted image
                /* if ($this->summary_image_type != 'Automatic')
                {
                    $this->summaryImageSlotPreview = $summaryUrl;
                } */
            }

        } else {

            $this->summary_image_type = 'Automatic';
            $this->allYears = $this->allTerms = 1;

        }




        if ($this->summary_image_type == 'Automatic')
        {
            $this->summaryImageIsVisible = False;
        } else {
            $this->summaryImageIsVisible = True;
        }


        $this->tagsYearGroups = SystemTag::select('uuid', 'name')->where('type', 'year')->where('live', 'Y')->get()->toArray();
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

            if ( count($this->tagsYearGroups) == count($contentYearGroupsTags) )
            {
                $this->allYears = 1;
            }
        }


        $this->tagsLscs = SystemTag::select('uuid', 'name')->where('type', 'career_readiness')->where('live', 'Y')->get()->toArray();
        if ($action == 'add')
        {
            foreach($this->tagsLscs as $key => $value){
                //$this->contentLscsTags[] = $value['name'][ app()->getLocale() ];
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

            if ( count($this->tagsTerms) == count($contentTermsTags) )
            {
                $this->allTerms = 1;
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


        $this->relatedQuestions = $content->relatedQuestions->toArray();
        foreach($this->relatedQuestions as $key => $value)
        {
            $this->relatedQuestions[$key]['key_id'] = Str::random(32);
            $this->relatedQuestions[$key]['deleted'] = False;
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
     * Add a question
     */
    public function addRelatedQuestion()
    {
        $this->relatedQuestions[] = ['key_id' => Str::random(32), 'title' => '', 'text' => '', 'deleted' => False];

        //converts the textarea to timymce
        $this->dispatchBrowserEvent('componentUpdated');

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
     * Remove a question
     */
    public function removeRelatedQuestion($id)
    {
        //unset($this->relatedQuestions[$id]);
        $this->relatedQuestions[$id]['deleted'] = True;
    }


    public function articleSelector($data)
    {
        if ($data[1] == NULL){
            $this->{$data[0]} = NULL;
        } else {
            $this->{$data[0]} = $data[1];
        }
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
                            $this->generateSlugUniqueRule(),
                        ]

                    ]

            );


        }elseif ($propertyName == "lead"){

            $this->summary_text = $this->lead;


        } elseif ($propertyName == "banner"){
            /*
            $this->validateOnly('banner', [
                'slug' => [ 'required',
                            'alpha_dash',
                            //search the `contents` table for the slug name, ignores our current content
                            Rule::unique('contents')->whereNot('uuid', $content->uuid),
                        ]

                    ]

            );

*/
    //        $this->bannerOriginal = 'E:\rfmedia projects\ckcorp\website_platform\ckcorp\public\storage\ck\images\business_consulting.jpg';//public_path('/storage/ck/images/business_consulting.jpgl');
    //        $this->validateOnly('bannerOriginal');


        } elseif ($propertyName == "summary"){


        } elseif ($propertyName == "allYears"){
            if ($this->allYears == 1){
                $this->AllYearsOn();
            }

        } elseif ($propertyName == "allTerms"){
            if ($this->allTerms == 1){
                $this->AllTermsOn();
            }

        } elseif ($propertyName == "summary_image_type"){

            if ($this->summary_image_type == 'Automatic')
            {
                if (!empty($this->banner))
                {
                    $this->makeSummaryImage($this->banner);
                }
            } else {
                if (!empty($this->summary))
                {
                    $this->makeSummaryImage($this->summary);
                }
            }

        } else {
            $this->validateOnly($propertyName);
        }

    }


/*
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

        try {

            $contentService = new ContentAccordionService();
            $contentService->storeAndMakeLive($this);

            $this->removeTempImagefolder();


            $routeSegment = ($this->isGlobal == 1) ? '.global' : '';

            return redirect()->route('admin'.$routeSegment.'.contents.index');

        } catch (\Exception $e) {

            Session::flash('fail', 'Content not Created Successfully');

        }
    }
*/

    public function removeTempImagefolder()
    {
        Storage::disk('public')->deleteDirectory($this->tempImagePath);
    }



    public function store($param)
    {

        //The slug must be checked against global and client content
        $this->rules['slug'] = [ 'required',
                                 'alpha_dash',
                                 $this->generateSlugUniqueRule(),
                                ];

        $this->validate($this->rules, $this->messages);

        $verb = ($this->action == 'add') ? 'Created' : 'Updated';

        DB::beginTransaction();

        try {

            $contentService = new ContentAccordionService();
            //if the 'live' action needs to be processed
            if (strpos($param, 'live') !== false) {
                $contentService->storeAndMakeLive($this);
            } else {
                $newContent = $contentService->store($this);

                //this line is required when creating an article
                //after saving the article, the contentUuid variable is set and the article can now be edited
                $this->contentUuid = $newContent->uuid;
                $this->action = 'edit';
            }

            DB::commit();

            Session::flash('success', 'Content '.$verb.' Successfully');

        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('fail', 'Content not be '.$verb.' Successfully');

        }


        //if the 'exit' action needs to be processed
        if (strpos($param, 'exit') !== false)
        {

            $this->removeTempImagefolder();

            $routeSegment = ($this->isGlobal == 1) ? '.global' : '';

            return redirect()->route('admin'.$routeSegment.'.contents.index');

        }

    }


    public function makeRelatedDownload($field, $url)
    {

        $relatedDownloadId = Str::between($field, 'file_relatedDownloads[', "]['url']");
        $this->relatedDownloads[$relatedDownloadId]['url'] = $url;
        $this->relatedDownloads[$relatedDownloadId]['open_link'] = '/storage' . $url;

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
        $this->resetErrorBag('summary');

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

            //split the string, encode the parts and join the string together again.
            $this->bannerOriginal = implode('/', array_map('rawurlencode', explode('/', $image)));//relative path of image selected. displays the image


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
                $this->summaryOriginal = implode('/', array_map('rawurlencode', explode('/', $image))); //relative path of image selected. displays the image

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

        return view('livewire.admin.content-accordion-form');

    }

}
