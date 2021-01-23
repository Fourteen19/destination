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
        'client' => 'required|numeric',
    ];

    //setup of the component
    public function mount()
    {
        $this->routeName = Route::currentRouteName();

        //loads the clients from the DB
        $this->clientsList = Client::orderBy('name','asc')->pluck('name','id')->all();

        //inititalises the client selected
        $this->client = (!empty(Session::get('adminClientSelector'))) ? Session::get('adminClientSelector') : NULL;

    }



    public function updatedClient()
    {
        //dd( session()->get('adminClientSelector') );
        $validatedData = $this->validate();

        $this->client = $validatedData['client'];

        session()->put('adminClientSelector', $this->client);

        redirect()->route($this->routeName);

    }


    public function render()
    {
        return view('livewire.admin.client-selector');
    }
}
