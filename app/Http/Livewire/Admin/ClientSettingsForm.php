<?php

namespace App\Http\Livewire\Admin;


use Livewire\Component;
use App\Models\ClientSettings;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\ClientService;
use Illuminate\Support\Facades\Session;



class ClientSettingsForm extends Component
{

    public $activeTab;
    public $chat_app;
    public $colour_bg1, $colour_bg2, $colour_bg3, $colour_txt1, $colour_txt2, $colour_txt3, $colour_txt4, $colour_link1, $colour_link2, $colour_button1, $colour_button2, $colour_button3, $colour_button4;

    //used in the javascript
    public $js_colour_picker_names = ['bg1', 'bg2', 'bg3', 'txt1', 'txt2', 'txt3', 'txt4', 'link1', 'link2', 'button1', 'button2', 'button3', 'button4',];
    public $font;

    protected $rules = [
        'colour_bg1' => ['required', 'regex:/^#(?:[0-9a-fA-F]{4}){1,2}$/'],
    ];


    protected $messages = [
    ];



    public function mount()
    {

        $clientSettings = ClientSettings::select(
            'id',
            'colour_bg1', 'colour_bg2', 'colour_bg3',
            'colour_txt1', 'colour_txt2', 'colour_txt3', 'colour_txt4',
            'colour_link1', 'colour_link2',
            'colour_button1', 'colour_button2', 'colour_button3', 'colour_button4',
            'chat_app', 'font',
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

        try {

            $clientService = new ClientService();

            $clientService->storeSettings($this);

            Session::flash('success', 'Settings updated Successfully');

        } catch (\Exception $e) {

            Log::error($e);

            Session::flash('fail', 'Settings could not be updated Successfully');

        }

    }


    public function render()
    {
        return view('livewire.admin.client-settings-form');
    }
}
