<?php

namespace App\Http\Livewire\Admin;


use App\Models\Client;
use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class ClientSelector extends Component
{

    public $clientsList;
    public $client;
    public $routeName;

    protected $rules = [
        'client' => 'sometimes|uuid',
    ];

    protected $messages = [
        'client.uuid' => 'The slug has already been taken. Please modify your title',
    ];

    //setup of the component
    public function mount()
    {
        $this->routeName = Route::currentRouteName();

        //loads the clients from the DB
        $this->clientsList = session()->get('all_clients');

        //inititalises the client selected
        $this->client = (!empty(Session::get('adminClientSelectorSelection'))) ? Session::get('adminClientSelectorSelection') : NULL;

    }



    public function updatedClient()
    {

        //dd( session()->get('adminClientSelector') );
        $validatedData = $this->validate();

        $this->client = $validatedData['client'];

        //saves in the session the UUID of the client selected
        session()->put('adminClientSelectorSelection', $this->client);

        $selectedClient = Client::where('uuid', $this->client )->select('id')->first()->toArray();

        //saves in the session the ID of the client selected
        session()->put('adminClientSelectorSelected', $selectedClient['id']);

        redirect()->route($this->routeName);

    }


    public function render()
    {

        return view('livewire.admin.client-selector');
    }
}
