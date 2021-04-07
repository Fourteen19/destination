<?php

namespace App\Http\Livewire\Admin;


use Livewire\Component;
use App\Models\ClientSettings;
use App\Services\Admin\ClientService;
use Illuminate\Support\Facades\Session;



class ClientSettingsForm extends Component
{

    public $activeTab;
    public $chat_app;
    public $font;

    protected $rules = [
    ];


    protected $messages = [
    ];



    public function mount()
    {

        $clientSettings = ClientSettings::select(
            'id',
            'chat_app', 'font',
            )
            ->where('client_id', session()->get('adminClientSelectorSelected') )
            ->first();


        $this->chat_app = $clientSettings->chat_app;
        $this->font = $clientSettings->font;


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

        //$this->validate($this->rules, $this->messages);

        /* try { */

            $this->clientService = new ClientService();

            $this->clientService->storeSettings($this);

            Session::flash('success', 'Settings updated Successfully');

        /* } catch (\Exception $e) {

            Session::flash('fail', 'Settings could not be updated Successfully');

        } */

    }


    public function render()
    {
        return view('livewire.admin.client-settings-form');
    }
}
