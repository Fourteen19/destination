<?php

namespace App\Http\Livewire\Admin;


use Livewire\Component;
use Spatie\Image\Image;
use App\Models\ClientSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\ClientService;
use Illuminate\Support\Facades\Session;



class ClientSettingsForm extends Component
{

    protected $listeners = ['make_logo_image' => 'makeLogoImage'];

    public $activeTab;
    public $chat_app;
    public $colour_bg1, $colour_bg2, $colour_bg3, $colour_txt1, $colour_txt2, $colour_txt3, $colour_txt4, $colour_link1, $colour_link2, $colour_button1, $colour_button2, $colour_button3, $colour_button4;

    public $logo;
    public $logo_alt;
    public $logoOriginal;

    //used in the javascript
    public $js_colour_picker_names = ['bg1', 'bg2', 'bg3', 'txt1', 'txt2', 'txt3', 'txt4', 'link1', 'link2', 'button1', 'button2', 'button3', 'button4',];
    public $font_url, $font_family;

    protected $rules = [

        'logo' => 'file_exists',

        'colour_bg1' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_bg2' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_bg3' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],

        'colour_txt1' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_txt2' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_txt3' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_txt3' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],

        'colour_link1' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_link2' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],

        'colour_button1' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_button2' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_button3' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
        'colour_button4' => ['regex:/^#(?:[0-9a-fA-F]{3}){1,2}[0-9a-fA-F]{2}$/'],
    ];


    protected $messages = [
        'logo.file_exists' =>  'The logo image file you selected does not exist anymore. Please select another file or find the same file if it has been moved.',
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
            'font_url', 'font_family',
            )
            ->where('client_id', session()->get('adminClientSelectorSelected') )
            ->first();


        $this->chat_app = $clientSettings->chat_app;
        $this->font_url = $clientSettings->font_url;
        $this->font_family = $clientSettings->font_family;

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


        $logo = $clientSettings->getMedia('logo')->first();

        if ($logo)
        {
            $logoUrl = parse_encode_url($logo->getUrl());
            $this->logo = $logo->getCustomProperty('folder'); //relative path in field
            $this->logoOriginal = $logoUrl;//$logo->getCustomProperty('folder'); //$logo->getFullUrl();
            $this->logo_alt = $logo->getCustomProperty('alt');
            $this->logoImagePreview = $logoUrl; // retrieves URL of converted image
        }



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

        DB::beginTransaction();

        try {

            $clientService = new ClientService();

            $clientService->storeSettings($this);

            DB::commit();

            Session::flash('success', 'Settings updated Successfully');

        } catch (\Exception $e) {

            DB::rollback();

            Log::error($e);

            Session::flash('fail', 'Settings could not be updated Successfully');

        }

    }



    /**
     * Validation
     * Custom validation
     *
     * @param  mixed $image
     * @return void
     */
    public function logoValidation($image)
    {

        $this->resetErrorBag('logo');

        return FALSE;
    }


    public function makeLogoImage($image)
    {

        //Returns information about a file path
        $fileDetails = pathinfo($image);

        if ($this->logoValidation($image) == FALSE)
        {

            $this->resetErrorBag('logo');

            $version = date("YmdHis");

            $this->logo = $image; //relative path in field

            //split the string, encode the parts and join the string together again.
            $this->logoOriginal = implode('/', array_map('rawurlencode', explode('/', $image)));

            //generates preview filename
            $imageName = "preview_logo.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( $image ) )
                ->save( public_path( 'storage/'.$imageName ));

            //assigns the preview filename
            $this->logoImagePreview = '/storage/'.$imageName.'?'.$version;//versions the file to prevent caching

        }

    }


    public function render()
    {
        return view('livewire.admin.client-settings-form');
    }
}
