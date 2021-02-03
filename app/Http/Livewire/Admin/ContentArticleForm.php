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
                            'make_related_download' => 'makeRelatedDownload',
                            'make_related_image' => 'makeRelatedImage',
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
    public $tagsKeywords, $tagsSubjects, $tagsYearGroups, $tagsTerms, $tagsLscs, $tagsRoutes, $tagsSectors, $tagsFlags;
    public $contentKeywordTags = [];
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
//            dd( public_path() ); "C:\rfmedia_projects\projects\ckcorp\public"
//            dd( resource_path() );// "C:\rfmedia_projects\projects\ckcorp\resources"
//            dd( asset('testfile.txt') );// "http://ck.platformbrand.com:8000/testfile.txt"
//            dd( storage_path('app/file.txt') ); //"C:\rfmedia_projects\projects\ckcorp\storage\app/file.txt"
//            dd( app_path('app/file.txt') ); //"C:\rfmedia_projects\projects\ckcorp\app\app/file.txt"
            if ($banner)
            {
                $this->banner = $banner->getCustomProperty('folder'); //relative path in field
                $this->bannerOriginal =  '/storage' . $banner->getCustomProperty('folder'); //$banner->getFullUrl();
                $this->bannerImagePreview = $banner->getUrl('banner'); // retrieves URL of converted image
            }


            $summary = $this->content->getMedia('summary')->first();
            if ($summary)
            {
                $this->summary = $summary->getCustomProperty('folder'); //relative path in field
                $this->summaryOriginal = '/storage' . $summary->getCustomProperty('folder');
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

        $this->tagsKeywords = SystemTag::where('type', 'keyword')->get()->toArray();
        $contentKeywordTags = $this->content->tagsWithType('keyword');
        foreach($contentKeywordTags as $key => $value){
            $this->contentKeywordTags[] = $value['name'];
        }

        $this->relatedVideos = $this->content->relatedVideos->toArray();

        $this->relatedLinks = $this->content->relatedLinks->toArray();



        $relatedDownloads = $this->content->getMedia('supporting_downloads');
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


        $relatedImages = $this->content->getMedia('supporting_images');
        if (count($relatedImages) > 0)
        {
            foreach($relatedImages as $key => $value)
            {
                //gets the URL of the conversion
                $previewPath = parse_url($value->getUrl('supporting_images'));

                $this->relatedImages[] = [
                    'title' => $value->getCustomProperty('title'),
                    'url' => $value->getCustomProperty('folder'),
                    'open_link' => '/storage' . $value->getCustomProperty('folder'),
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
        $this->relatedImages[] = ['title' => '', 'url' => '', 'open_link' => '', 'preview' => ''];
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
            $this->slug = Str::slug($this->title);

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

        //extracts the ID of image
        $relatedImageId = Str::between($field, 'file_relatedImages[', "]['url']");
        $this->relatedImages[$relatedImageId]['url'] = $url;
        $this->relatedImages[$relatedImageId]['open_link'] = '/storage' . $url;

        //generates preview filename
        $imageName = "preview_supp_image_".$relatedImageId.".".$fileDetails['extension'];

        //generates Image conversion
        Image::load (public_path( 'storage' . $url ) )
            ->crop(Manipulations::CROP_CENTER, 2074, 798)
            ->save( public_path( 'storage\\'.$this->tempImagePath.'/'.$imageName ));

        //stores the preview filename in array
        $this->relatedImages[$relatedImageId]['preview'] = '\storage\\'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

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
        list($width, $height, $type, $attr) = getimagesize( public_path('/storage' . $image) );
        if ($width < 0)
        {
            $error = 1;
            $this->addError('banner', 'Yay width issue');
        }

        if ($height < 0)
        {
            $error = 1;
            $this->addError('banner', 'Yay height issue');
        }

        return $error;
    }


    public function makeBannerImage($image)
    {

        //Returns information about a file path
        $fileDetails = pathinfo($image);

        if ($this->bannerValidation($image) == FALSE)
        {

            $version = date("YmdHis");

            $this->banner = $image; //relative path in field
            $this->bannerOriginal = '/storage' . $image; //relative path of image selected. displays the image

            //generates preview filename
            $imageName = "preview_banner.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( 'storage' . $image ) )
                ->crop(Manipulations::CROP_CENTER, 2074, 798)
                ->save( public_path( 'storage\\'.$this->tempImagePath.'/'.$imageName ));

            //assigns the preview filename
            $this->bannerImagePreview = '\storage\\'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

            //i automatic
            if ($this->summary_image_type == 'Automatic')
            {
                //generates the summary image
                $this->makeSummaryImage($image);
            }

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

        //Returns information about a file path
        $fileDetails = pathinfo($image);

        //assigns the preview filename
        $imageNameSlot1 = "preview_summary_slot_1.".$fileDetails['extension'];
        $imageNameSlot23 = "preview_summary_slot_23.".$fileDetails['extension'];
        $imageNameSlot456 = "preview_summary_slot_456.".$fileDetails['extension'];
        $imageNameYouMightLike = "preview_summary_you_might_like.".$fileDetails['extension'];
        $imageNameSearch = "preview_summary_search.".$fileDetails['extension'];

        //generates image conversions
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

        Image::load (public_path( 'storage' . $image ) )
            ->crop(Manipulations::CROP_CENTER, 1274, 536)
            ->save( public_path( 'storage\\'.$this->tempImagePath.'/'.$imageNameSearch ));

        //assigns preview images
        $this->summaryImageSlot1Preview = '\storage\\'.$this->tempImagePath.'/'.$imageNameSlot1.'?'.$version;//versions the file to prevent caching
        $this->summaryImageSlot23Preview = '\storage\\'.$this->tempImagePath.'/'.$imageNameSlot23.'?'.$version;//versions the file to prevent caching
        $this->summaryImageSlot456Preview = '\storage\\'.$this->tempImagePath.'/'.$imageNameSlot456.'?'.$version;//versions the file to prevent caching
        $this->summaryImageYouMightLikePreview = '\storage\\'.$this->tempImagePath.'/'.$imageNameYouMightLike.'?'.$version;//versions the file to prevent caching
        $this->summaryImageSearchPreview = '\storage\\'.$this->tempImagePath.'/'.$imageNameSearch.'?'.$version;//versions the file to prevent caching

    }



    public function render()
    {

        return view('livewire.admin.content-article-form');

    }

}
