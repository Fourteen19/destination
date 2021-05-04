<?php

namespace App\Http\Livewire\Admin;

use App\Models\Client;
use Livewire\Component;

class ResourceClientSelector extends Component
{

    public $clientsList;
    public $clientsListUuid;

    public $all_clients;
    public $clients;

    //setup of the component
    public function mount($uuid, $allClientsParam, $clientsParam)
    {

        $this->clientsList = Client::select('uuid', 'name')->orderBy('name', 'ASC')->get()->toArray();

        foreach($this->clientsList as $key => $value)
        {
            $this->clientsListUuid[] = $value['uuid'];

        }

        $this->all_clients = ($allClientsParam == 'Y') ? True : False;




        foreach($clientsParam as $key => $value)
        {
            $this->clients[] = $value['uuid'];
        }

    }


    public function render()
    {

        return view('livewire.admin.resource-client-selector');
    }
}
