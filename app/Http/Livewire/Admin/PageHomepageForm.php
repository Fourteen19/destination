<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Image\Image;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\DB;
use App\Models\StaticClientContent;
use App\Services\Admin\PageService;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\EventService;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\ContentService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Services\Admin\PageHomepageService;

class PageHomepageForm extends Component
{

    protected $listeners = ['make_banner_image' => 'makeBannerImage',
                            'article_selector' => 'articleSelector',
                            'event_selector' => 'eventSelector',
                            ];

    public $baseUrl;
    public $action = 'edit';
    public $activeTab;

    public $banner;
    public $bannerOriginal;
    public $bannerImagePreview;

    public $pageRef; //uuid

    public $bannerTitle;
	public $bannerText;
	public $bannerLink1Text;
	public $bannerLink1Page;
	public $bannerLink2Text;
	public $bannerLink2Page;
	public $freeArticlesBlockHeading;
	public $freeArticlesBlockText;
	public $freeArticlesSlot1Page;
	public $freeArticlesSlot2Page;
	public $freeArticlesSlot3Page;

    public $eventSlot1Page;
	public $eventSlot2Page;

    public $login_box_heading;
    public $login_box_body;
    public $login_box_banner_url;

    public $pageList = []; //for dropdown
    public $contentList = []; //for dropdown

    public $tempImagePath;

    public $previewBannerButtons = [];
    public $previewFreeArticles = [];
    public $previewEvents = [];

    protected $rules = [
        'banner' => 'file_exists',
        'bannerTitle' => 'required',

    ];

    protected $messages = [

        'banner.file_exists' =>  'The banner image file you selected does not exist anymore. Please select another file or find the same file if it has been moved.',

    ];


    public function mount()
    {

        //preview images are saved a temp folder
        if (!empty(Auth::guard('admin')->user()->client))
        {
            $this->tempImagePath = Auth::guard('admin')->user()->client->subdomain;
        } else {
            $this->tempImagePath = "global";
        }
        $this->tempImagePath = $this->tempImagePath.'/preview_images/'.Str::random(32);
        Storage::disk('public')->makeDirectory($this->tempImagePath);


        $pageService = new PageService();
        $page = $pageService->getHomepageDetails();

        $contentService = new ContentService();
        $eventService = new EventService();

        $this->pageRef = $page->uuid;
        $this->bannerTitle = $page->pageable->banner_title;
        $this->bannerText = $page->pageable->banner_text;
        $this->bannerLink1Text = $page->pageable->banner_link1_text;
        $this->bannerLink1Page = $pageService->getLivePageUuidById($page->pageable->banner_link1_page_id);
        $this->bannerLink2Text = $page->pageable->banner_link2_text;
        $this->bannerLink2Page = $pageService->getLivePageUuidById($page->pageable->banner_link2_page_id);
        $this->freeArticlesBlockHeading = $page->pageable->free_articles_block_heading;
        $this->freeArticlesBlockText = $page->pageable->free_articles_block_text;
        $this->freeArticlesSlot1Page = $contentService->getLiveContentUuidById($page->pageable->free_articles_slot1_page_id);
        $this->freeArticlesSlot2Page = $contentService->getLiveContentUuidById($page->pageable->free_articles_slot2_page_id);
        $this->freeArticlesSlot3Page = $contentService->getLiveContentUuidById($page->pageable->free_articles_slot3_page_id);

        $this->eventSlot1Page = $eventService->getLiveEventUuidById($page->pageable->featured_event_slot1_id);
        $this->eventSlot2Page = $eventService->getLiveEventUuidById($page->pageable->featured_event_slot2_id);

        $this->pageList = ['' => 'Please Select'] + $pageService->getAllClientPagesforDropdown();
        $this->contentList = ['' => 'Please Select'] + $contentService->getAllLiveClientArticlesforDropdown();


        //for Preview
        $this->updateArticlesFreeSlots();
        $this->updateEventsSlots();
        $this->updateBannerButtons();


        $banner = $page->getMedia('banner')->first();
        if ($banner)
        {
            $bannerUrl = parse_encode_url($banner->getUrl());
            $this->banner = $banner->getCustomProperty('folder'); //relative path in field
            $this->bannerOriginal =  $bannerUrl; //$banner->getFullUrl();
            $this->bannerImagePreview = $bannerUrl; // retrieves URL of converted image
        }



        $staticClientContent = StaticClientContent::where('client_id', session()->get('adminClientSelectorSelected') )
            ->first();
        $this->login_box_heading = $staticClientContent->login_block_heading;
        $this->login_box_body = $staticClientContent->login_block_body;
        $this->login_box_banner_url = $staticClientContent->getFirstMediaUrl('login_block_banner', 'small');

        $this->activeTab = "welcome-banner";
    }



    public function updateBannerLeftButtons()
    {
        $pageService = new PageService();
        $this->previewBannerButtons[0] = (!empty($this->bannerLink1Page)) ? $pageService->getLivePageDetailsByUuid($this->bannerLink1Page) : NULL;
    }


    public function updateBannerRightButtons()
    {
        $pageService = new PageService();
        $this->previewBannerButtons[1] = (!empty($this->bannerLink2Page)) ? $pageService->getLivePageDetailsByUuid($this->bannerLink2Page) : NULL;
    }


    public function updateBannerButtons()
    {
        $this->updateBannerLeftButtons();
        $this->updateBannerRightButtons();
    }


    public function articleSelector($data)
    {
        $this->{$data[0]} = $data[1];
    }

    public function eventSelector($data)
    {
        $this->{$data[0]} = $data[1];
    }


    public function updateFreeArticleSlotOne()
    {
        $contentService = new ContentService();
        $this->previewFreeArticles[0] = (!empty($this->freeArticlesSlot1Page)) ? $contentService->getSummaryPageDetailsForPreview($this->freeArticlesSlot1Page) : NULL;
    }


    public function updateFreeArticleSlotTwo()
    {
        $contentService = new ContentService();
        $this->previewFreeArticles[1] = (!empty($this->freeArticlesSlot2Page)) ? $contentService->getSummaryPageDetailsForPreview($this->freeArticlesSlot2Page) : NULL;
    }


    public function updateFreeArticleSlotThree()
    {
        $contentService = new ContentService();
        $this->previewFreeArticles[2] = (!empty($this->freeArticlesSlot3Page)) ? $contentService->getSummaryPageDetailsForPreview($this->freeArticlesSlot3Page) : NULL;
    }


    public function updateArticlesFreeSlots()
    {
        $this->updateFreeArticleSlotOne();
        $this->updateFreeArticleSlotTwo();
        $this->updateFreeArticleSlotThree();
    }




    public function updateEventSlotOne()
    {
        $eventService = new EventService();
        $this->previewEvents[0] = (!empty($this->eventSlot1Page)) ? $eventService->getSummaryEventDetailsForPreview($this->eventSlot1Page) : NULL;
    }


    public function updateEventSlotTwo()
    {
        $eventService = new EventService();
        $this->previewEvents[1] = (!empty($this->eventSlot2Page)) ? $eventService->getSummaryEventDetailsForPreview($this->eventSlot2Page) : NULL;
    }

    public function updateEventsSlots()
    {
        $this->updateEventSlotOne();
        $this->updateEventSlotTwo();
    }


    /**
     * Keeps track of the active Tab
     *
     */
    public function updateTab($tabName)
    {
        $this->activeTab = $tabName;
    }



    public function updated($propertyName)
    {

        if ($propertyName == 'bannerLink1Page')
        {
            $this->updateBannerLeftButtons();
        } elseif ($propertyName == 'bannerLink2Page')
        {
            $this->updateBannerRightButtons();
         }

    }





    public function storeAndMakeLive()
    {

        $this->validate($this->rules, $this->messages);

        DB::beginTransaction();

        try {

            $pageService = new PageHomepageService();

            $pageService->storeAndMakeLive($this);

            DB::commit();

            $message = "Your Page has been edited Successfully";

            Session::flash('success', $message);

        } catch (\Exception $e) {

            DB::rollback();

            Log::error($e);

            Session::flash('fail', "Your Page could not be edited");

        }

        $this->removeTempImagefolder();

        return redirect()->route('admin.pages.index');

    }


    public function removeTempImagefolder()
    {
        Storage::disk('public')->deleteDirectory($this->tempImagePath);
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
   /*     list($width, $height, $type, $attr) = getimagesize( public_path($image) );
        //list($width, $height, $type, $attr) = getimagesize( $image );
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
*/
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
            $this->bannerOriginal = implode('/', array_map('rawurlencode', explode('/', $image))); //relative path of image selected. displays the image

            //generates preview filename
            $imageName = "preview_banner.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( $image ) )
                ->crop(Manipulations::CROP_CENTER, 1041, 528)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageName ));

            //assigns the preview filename
            $this->bannerImagePreview = '/storage/'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

        }

    }




    public function render()
    {
        return view('livewire.admin.page-homepage-form');
    }
}
