<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Image\Image;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\DB;
use App\Models\StaticClientContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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

    public $loginBoxBanner;
    public $loginBoxBannerOriginal;
    public $loginBoxBannerImagePreview;

    public $tempImagePath;

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

        'login_box_title' => 'nullable',
        'login_box_intro' => 'nullable',

    ];

    protected $messages = [

    ];


    public function mount()
    {

        $staticClientContent = StaticClientContent::select(
                    'id',
                    'tel', 'email',  //contact details

                    'terms', 'privacy', 'cookies', //legal

                    'pre_footer_heading', 'pre_footer_body', 'pre_footer_button_text', 'pre_footer_link', //public content

                    'login_intro', 'welcome_intro',
                    'careers_intro', 'subjects_intro', 'routes_intro', 'sectors_intro', 'assessment_completed_txt', //self assessment

                    'support_block_heading', 'support_block_body', 'support_block_button_text', 'support_block_link',
                    'get_in_right_heading', 'get_in_right_body',

                    'login_block_heading', 'login_block_body'
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
        $this->pre_footer_link = $staticClientContent->pre_footer_link;

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
        $this->support_block_link = $staticClientContent->support_block_link;
        $this->get_in_right_heading = $staticClientContent->get_in_right_heading;
        $this->get_in_right_body = $staticClientContent->get_in_right_body;

        $this->login_box_title = $staticClientContent->login_block_heading;
        $this->login_box_intro = $staticClientContent->login_block_body;



        //preview images are saved a temp folder
        if (!empty(Auth::guard('admin')->user()->client))
        {
            $this->tempImagePath = Auth::guard('admin')->user()->client->subdomain;
        } else {
            $this->tempImagePath = "global";
        }
        $this->tempImagePath = $this->tempImagePath.'\preview_images\\'.Str::random(32);
        Storage::disk('public')->makeDirectory($this->tempImagePath);



        //get the login block banner
        $loginBoxBanner = $staticClientContent->getFirstMedia('login_block_banner');

        if ($loginBoxBanner)
        {
            $this->loginBoxBanner = $loginBoxBanner->getCustomProperty('folder'); //relative path in field
            $this->loginBoxBannerOriginal = $loginBoxBanner->getCustomProperty('folder'); //$banner->getFullUrl();
            $this->loginBoxBannerImagePreview = $loginBoxBanner->getUrl('small'); // retrieves URL of converted image
        }


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

            $modelId = StaticClientContent::select('id')->where('client_id', session()->get('adminClientSelectorSelected') )->first()->toArray();

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
                 'support_block_link' => $this->support_block_link,
                 'get_in_right_heading' => $this->get_in_right_heading,
                 'get_in_right_body' => $this->get_in_right_body,

                 'pre_footer_heading' => $this->pre_footer_heading,
                 'pre_footer_body' => $this->pre_footer_body,
                 'pre_footer_button_text' => $this->pre_footer_button_text,
                 'pre_footer_link' => $this->pre_footer_link,

                 'login_intro' => $this->login_intro,
                 'welcome_intro' => $this->welcome_intro,
                 'careers_intro' => $this->careers_intro,
                 'subjects_intro' => $this->subjects_intro,
                 'routes_intro' => $this->routes_intro,
                 'sectors_intro' => $this->sectors_intro,
                 'assessment_completed_txt' => $this->assessment_completed_txt,

                 'login_block_heading' => $this->login_box_title,
                 'login_block_body' => $this->login_box_intro,
                ]

            );


            $statiContent = StaticClientContent::find($modelId)->first();

            $statiContent->clearMediaCollection('login_block_banner');

            $statiContent->addMedia( public_path($this->loginBoxBanner) )
                         ->preservingOriginal()
                         ->withCustomProperties(['folder' => $this->loginBoxBanner ])
                         ->toMediaCollection('login_block_banner');

            DB::commit();

            Session::flash('success', 'Your content has been updated Successfully');
        }
        catch (\Exception $e) {

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

            $version = date("YmdHis");

            $this->loginBoxBanner = $image; //relative path in field
            $this->loginBoxBannerOriginal = $image; //relative path of image selected. displays the image

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
