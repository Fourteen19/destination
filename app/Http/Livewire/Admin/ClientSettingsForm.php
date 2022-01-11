<?php

namespace App\Http\Livewire\Admin;


use Livewire\Component;
use Spatie\Image\Image;
use App\Models\ClientSettings;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\ClientService;
use Illuminate\Support\Facades\Session;



class ClientSettingsForm extends Component
{

    protected $listeners = ['make_banner_image' => 'makeBannerImage'];

    public $activeTab;
    public $chat_app;
    public $colour_bg1, $colour_bg2, $colour_bg3, $colour_txt1, $colour_txt2, $colour_txt3, $colour_txt4, $colour_link1, $colour_link2, $colour_button1, $colour_button2, $colour_button3, $colour_button4;

    public $banner;
    public $banner_alt;
    public $bannerOriginal;

    //used in the javascript
    public $js_colour_picker_names = ['bg1', 'bg2', 'bg3', 'txt1', 'txt2', 'txt3', 'txt4', 'link1', 'link2', 'button1', 'button2', 'button3', 'button4',];
    public $font;

    protected $rules = [

        'banner' => 'required|file_exists',

        'colour_bg1' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_bg2' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_bg3' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],

        'colour_txt1' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_txt2' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_txt3' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_txt3' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],

        'colour_link1' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_link2' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],

        'colour_button1' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_button2' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_button3' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_button4' => ['required', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
    ];


    protected $messages = [
        'banner.file_exists' =>  'The banner image file you selected does not exist anymore. Please select another file or find the same file if it has been moved.',
    ];



    public function mount()
    {

        $clientSettings = ClientSettings::select(
            'id',
            'colour_bg1', 'colour_bg2', 'colour_bg3',
            'colour_txt1', 'colour_txt2', 'colour_txt3', 'colour_txt4',
            'colour_link1', 'colour_link2',
            'colour_button1', 'colour_button2', 'colour_button3', 'colour_button4',
            'chat_app',
            'font',
            'logo_path', 'logo_alt',
            )
            ->where('client_id', session()->get('adminClientSelectorSelected') )
            ->first();


        $this->chat_app = $clientSettings->chat_app;
        $this->font = $clientSettings->font;

        $this->colour_bg1 = $clientSettings->colour_bg1;
        $this->colour_bg2 = $clientSettings->colour_bg2;
        $this->colour_bg3 = $clientSettings->colour_bg3;
        $this->colour_txt1 = $clientSettings->colour_txt1;
        $this->colour_txt2 = $clientSettings->colour_txt2;
        $this->colour_txt3 = $clientSettings->colour_txt3;
        $this->colour_txt4 = $clientSettings->colour_txt4;
        $this->colour_link1 = $clientSettings->colour_link1;
        $this->colour_link2 = $clientSettings->colour_link2;
        $this->colour_button1 = $clientSettings->colour_button1;
        $this->colour_button2 = $clientSettings->colour_button2;
        $this->colour_button3 = $clientSettings->colour_button3;
        $this->colour_button4 = $clientSettings->colour_button4;

        $this->logo_path = $clientSettings->logo_path;
        $this->logo_alt = $clientSettings->logo_alt;

        $this->activeTab = "colours";

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
     * store
     * $param contains the actions that need to be done by the store function
     *
     * @param  mixed $param
     * @return void
     */
    public function store($param)
    {

        $this->validate($this->rules, $this->messages);

       /*  try { */

            $clientService = new ClientService();

            $clientService->storeSettings($this);

            Session::flash('success', 'Settings updated Successfully');

        /* } catch (\Exception $e) {

            Log::error($e);

            Session::flash('fail', 'Settings could not be updated Successfully');

        } */

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

        return FALSE;
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
            $this->bannerOriginal = implode('/', array_map('rawurlencode', explode('/', $image)));

            //generates preview filename
            $imageName = "preview_banner.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( $image ) )
                ->save( public_path( 'storage/'.$imageName ));

            //assigns the preview filename
            $this->bannerImagePreview = '/storage/'.$imageName.'?'.$version;//versions the file to prevent caching

        }

    }


    public function render()
    {
        return view('livewire.admin.client-settings-form');
    }
}
