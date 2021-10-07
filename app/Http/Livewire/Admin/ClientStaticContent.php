<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Image\Image;

use App\Models\VacancyLive;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\DB;
use App\Models\StaticClientContent;
use App\Services\Admin\PageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Services\Frontend\VacanciesService;
use Spatie\ValidationRules\Rules\Delimited;

class ClientStaticContent extends Component
{

    protected $listeners = ['make_login_box_banner_image' => 'makeLoginBlockBannerImage'];


    public StaticClientContent $staticClientContent;

    public $activeTab;

    public $tel, $email;
    public $terms, $privacy, $cookies;
    public $pre_footer_heading, $pre_footer_body, $pre_footer_button_text, $pre_footer_link;
    public $login_intro, $welcome_intro, $careers_intro, $subjects_intro, $routes_intro, $sectors_intro, $assessment_completed_txt;
    public $support_block_heading, $support_block_body, $support_block_button_text, $support_block_link, $get_in_right_heading, $get_in_right_body;
    public $login_box_title, $login_box_intro;
    public $free_articles_message;
    public $no_event;

    public $we_intro, $we_dashboard_intro, $we_button_text, $we_button_link;

    public $loginBoxBanner;
    public $loginBoxBannerOriginal;
    public $loginBoxBannerImagePreview;

    public $clientPages;

    public $tempImagePath;

    public $featured_vacancy_1, $featured_vacancy_2, $featured_vacancy_3, $featured_vacancy_4;
    public $vacanciesList = [];
    public $vacancy_email_notification;
    public $event_email_notification;

    protected $rules = [
        'tel' => 'nullable',
        'email' => 'nullable|email',

        'terms' => 'nullable',
        'privacy' => 'nullable',
        'cookies' => 'nullable',

        'pre_footer_heading' => 'nullable',
        'pre_footer_body' => 'nullable',
        'pre_footer_button_text' => 'nullable',
        'pre_footer_link' => 'nullable',

        'login_intro' => 'nullable',
        'welcome_intro' => 'nullable',
        'careers_intro' => 'nullable',
        'subjects_intro' => 'nullable',
        'routes_intro' => 'nullable',
        'sectors_intro' => 'nullable',
        'assessment_completed_txt' => 'nullable',

        'support_block_heading' => 'nullable',
        'support_block_body' => 'nullable',
        'support_block_button_text' => 'nullable',
        'support_block_link' => 'nullable',
        'get_in_right_heading' => 'nullable',
        'get_in_right_body' => 'nullable',

        'loginBoxBanner' => 'file_exists',
        'login_box_title' => 'nullable',
        'login_box_intro' => 'nullable',

        'free_articles_message' => 'nullable',

        'no_event' => 'nullable',
        'we_intro' => 'nullable',
        'we_dashboard_intro' => 'nullable',

        'vacancy_email_notification' => 'nullable|email_delimited:;',
        'event_email_notification' => 'nullable|email_delimited:;',

    ];

    protected $messages = [
        'loginBoxBanner.file_exists' =>  'The image file you selected does not exist anymore. Please select another file or find the same file if it has been moved.',
        'vacancy_email_notification.email_delimited' => 'Please make sure all your email addresses are valid and separated with semicolons',
        'event_email_notification.email_delimited' => 'Please make sure all your email addresses are valid and separated with semicolons',
    ];


    public function mount()
    {

        $vacancyService = new VacanciesService();

        $staticClientContent = StaticClientContent::select(
                    'id',
                    'tel', 'email',  //contact details

                    'terms', 'privacy', 'cookies', //legal

                    'pre_footer_heading', 'pre_footer_body', 'pre_footer_button_text', 'pre_footer_link', //public content

                    'login_intro', 'welcome_intro',
                    'careers_intro', 'subjects_intro', 'routes_intro', 'sectors_intro', 'assessment_completed_txt', //self assessment

                    'support_block_heading', 'support_block_body', 'support_block_button_text', 'support_block_link',
                    'get_in_right_heading', 'get_in_right_body',

                    'login_block_heading', 'login_block_body',

                    'free_articles_message',

                    'we_intro', 'we_dashboard_intro', 'we_button_text', 'we_button_link',

                    'no_event',

                    'featured_vacancy_1', 'featured_vacancy_2', 'featured_vacancy_3', 'featured_vacancy_4',

                    'vacancy_email_notification', 'event_email_notification',
                    )  //logged in content
                    ->where('client_id', session()->get('adminClientSelectorSelected') )
                    ->first();


        $this->tel = $staticClientContent->tel;
        $this->email = $staticClientContent->email;

        $this->terms = $staticClientContent->terms;
        $this->privacy = $staticClientContent->privacy;
        $this->cookies = $staticClientContent->cookies;

        $this->pre_footer_heading = $staticClientContent->pre_footer_heading;
        $this->pre_footer_body = $staticClientContent->pre_footer_body;
        $this->pre_footer_button_text = $staticClientContent->pre_footer_button_text;

        $this->login_intro = $staticClientContent->login_intro;
        $this->welcome_intro = $staticClientContent->welcome_intro;
        $this->careers_intro = $staticClientContent->careers_intro;
        $this->subjects_intro = $staticClientContent->subjects_intro;
        $this->routes_intro = $staticClientContent->routes_intro;
        $this->sectors_intro = $staticClientContent->sectors_intro;
        $this->assessment_completed_txt = $staticClientContent->assessment_completed_txt;

        $this->support_block_heading = $staticClientContent->support_block_heading;
        $this->support_block_body = $staticClientContent->support_block_body;
        $this->support_block_button_text = $staticClientContent->support_block_button_text;
        $this->get_in_right_heading = $staticClientContent->get_in_right_heading;
        $this->get_in_right_body = $staticClientContent->get_in_right_body;

        $this->login_box_title = $staticClientContent->login_block_heading;
        $this->login_box_intro = $staticClientContent->login_block_body;

        $this->free_articles_message = $staticClientContent->free_articles_message;

        $this->we_intro = $staticClientContent->we_intro;
        $this->we_dashboard_intro = $staticClientContent->we_dashboard_intro;
        $this->we_button_text = $staticClientContent->we_button_text;

        $this->no_event = $staticClientContent->no_event;
        $this->featured_vacancy_1 = $vacancyService->getLiveVacancyUuidById($staticClientContent->featured_vacancy_1);
        $this->featured_vacancy_2 = $vacancyService->getLiveVacancyUuidById($staticClientContent->featured_vacancy_2);
        $this->featured_vacancy_3 = $vacancyService->getLiveVacancyUuidById($staticClientContent->featured_vacancy_3);
        $this->featured_vacancy_4 = $vacancyService->getLiveVacancyUuidById($staticClientContent->featured_vacancy_4);

        $this->vacancy_email_notification = $staticClientContent->vacancy_email_notification;
        $this->event_email_notification = $staticClientContent->event_email_notification;

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

        //gets pages related to the client for the dropdown
        $this->clientPages = $pageService->getLivePagesForDropDown();

        //gets the Uuid of the link
        $this->pre_footer_link = $pageService->getLivePageUuidById($staticClientContent->pre_footer_link);

        //gets the Uuid of the link
        $this->support_block_link = $pageService->getLivePageUuidById($staticClientContent->support_block_link);

        //gets the Uuid of the link
        $this->we_button_link = $pageService->getLivePageUuidById($staticClientContent->we_button_link);


        //get the login block banner
        $loginBoxBanner = $staticClientContent->getFirstMedia('login_block_banner');
        if ($loginBoxBanner)
        {
            $loginBoxBannerUrl = parse_encode_url($loginBoxBanner->getUrl());
            $this->loginBoxBanner = $loginBoxBanner->getCustomProperty('folder'); //relative path in field
            $this->loginBoxBannerOriginal = $loginBoxBannerUrl; //$banner->getFullUrl();
            $this->loginBoxBannerImagePreview = $loginBoxBannerUrl; // retrieves URL of converted image
        }

        //gets list of live vacancies
        $this->vacanciesList = VacancyLive::where('deleted_at', NULL)->pluck('title', 'uuid')->toArray();

        $this->activeTab = "contact-details";

    }


    /**
     * Keeps track of the active Tab
     *
     */
    public function updateTab($tabName)
    {
        $this->activeTab = $tabName;
    }


    public function updatedEmail()
    {
        $this->validateOnly('email',
                        ['email' => 'nullable|email']
        );
    }

    public function storeAndMakeLive()
    {

        $validatedData = $this->validate($this->rules, $this->messages);

        DB::beginTransaction();

        try {

            $pageService = new PageService();
            $vacancyService = new VacanciesService();

            $modelId = StaticClientContent::select('id')->where('client_id', session()->get('adminClientSelectorSelected') )->first()->toArray();

            //gets page details
            $support_block_link = $pageService->getLivePageDetailsByUuid($this->support_block_link);

            //gets page details
            $pre_footer_link = $pageService->getLivePageDetailsByUuid($this->pre_footer_link);

            //gets page details
            $we_button_link = $pageService->getLivePageDetailsByUuid($this->we_button_link);

            $featured_vacancy_1 = $vacancyService->getLiveVacancyDetailsByUuid($this->featured_vacancy_1);
            $featured_vacancy_2 = $vacancyService->getLiveVacancyDetailsByUuid($this->featured_vacancy_2);
            $featured_vacancy_3 = $vacancyService->getLiveVacancyDetailsByUuid($this->featured_vacancy_3);
            $featured_vacancy_4 = $vacancyService->getLiveVacancyDetailsByUuid($this->featured_vacancy_4);




            $statiContent = StaticClientContent::where('id', '=', $modelId['id'] )->update(
                ['tel' => $this->tel,
                 'email' => $this->email,

                 'terms' => $this->terms,
                 'privacy' => $this->privacy,
                 'cookies' => $this->cookies,
                 'show_terms' => (!empty($this->terms)) ? 'Y' : 'N',
                 'show_privacy' => (!empty($this->privacy)) ? 'Y' : 'N',
                 'show_cookies' => (!empty($this->cookies)) ? 'Y' : 'N',

                 'support_block_heading' => $this->support_block_heading,
                 'support_block_body' => $this->support_block_body,
                 'support_block_button_text' => $this->support_block_button_text,
                 'support_block_link' => (!is_null($support_block_link)) ? $support_block_link->id : NULL,
                 'get_in_right_heading' => $this->get_in_right_heading,
                 'get_in_right_body' => $this->get_in_right_body,

                 'pre_footer_heading' => $this->pre_footer_heading,
                 'pre_footer_body' => $this->pre_footer_body,
                 'pre_footer_button_text' => $this->pre_footer_button_text,
                 'pre_footer_link' => (!is_null($pre_footer_link)) ? $pre_footer_link->id : NULL,

                 'login_intro' => $this->login_intro,
                 'welcome_intro' => $this->welcome_intro,
                 'careers_intro' => $this->careers_intro,
                 'subjects_intro' => $this->subjects_intro,
                 'routes_intro' => $this->routes_intro,
                 'sectors_intro' => $this->sectors_intro,
                 'assessment_completed_txt' => $this->assessment_completed_txt,

                 'login_block_heading' => $this->login_box_title,
                 'login_block_body' => $this->login_box_intro,

                 'free_articles_message' => $this->free_articles_message,

                 'we_intro' => $this->we_intro,
                 'we_dashboard_intro' => $this->we_dashboard_intro,
                 'we_button_text' => $this->we_button_text,
                 'we_button_link' => (!is_null($we_button_link)) ? $we_button_link->id : NULL,

                 'no_event' => $this->no_event,

                 'featured_vacancy_1' => $featured_vacancy_1,
                 'featured_vacancy_2' => $featured_vacancy_2,
                 'featured_vacancy_3' => $featured_vacancy_3,
                 'featured_vacancy_4' => $featured_vacancy_4,

                 'vacancy_email_notification' => $this->vacancy_email_notification,
                 'event_email_notification' => $this->event_email_notification,
                ]

            );


            $statiContent = StaticClientContent::find($modelId)->first();

            $statiContent->clearMediaCollection('login_block_banner');

            if ($this->loginBoxBanner)
            {
                $statiContent->addMedia( public_path($this->loginBoxBanner) )
                            ->preservingOriginal()
                            ->withCustomProperties(['folder' => $this->loginBoxBanner ])
                            ->toMediaCollection('login_block_banner');
            }




            $statiContent = StaticClientContent::where('client_id', session()->get('adminClientSelectorSelected') )->with('media')->first();
            Redis::set('client:'.session()->get('adminClientSelectorSelected').':static-content', serialize($statiContent));


            //Cache::put('client:'.session()->get('adminClientSelectorSelected').':static-content', json_encode($statiContent));


            DB::commit();

            Session::flash('success', 'Your content has been updated Successfully');

        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('fail', 'Your content could not be been updated');

        }

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


    public function makeLoginBlockBannerImage($image)
    {

        //Returns information about a file path
        $fileDetails = pathinfo($image);

        if ($this->bannerValidation($image) == FALSE)
        {

            $this->resetErrorBag('loginBoxBanner');

            $version = date("YmdHis");

            $this->loginBoxBanner = $image; //relative path in field
            $this->loginBoxBannerOriginal = implode('/', array_map('rawurlencode', explode('/', $image))); //relative path of image selected. displays the image

            //generates preview filename
            $imageName = "preview_banner.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( $image ) )
                ->crop(Manipulations::CROP_CENTER, 2074, 798)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageName ));

            //assigns the preview filename
            $this->loginBoxBannerImagePreview = '/storage/'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

        }

    }


    public function render()
    {

        return view('livewire.admin.client-static-content');

    }

}
