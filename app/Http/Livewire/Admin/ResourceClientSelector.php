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
    public function mount($allClientsParam, $clientsParam)
    {

        $this->clientsList = Client::select('uuid', 'name')->orderBy('name', 'ASC')->get()->toArray();

        if (count($this->clientsList) > 0)
        {
            foreach($this->clientsList as $key => $value)
            {
                $this->clientsListUuid[] = $value['uuid'];

            }
        }



        $this->all_clients = ($allClientsParam == 'Y') ? True : False;


        if (count($clientsParam) > 0)
        {
            foreach($clientsParam as $key => $value)
            {
                if (isset($value['uuid']))
                {
                    $this->clients[] = $value['uuid'];
                } else {
                    $this->clients[] = $value;
                }
            }
        }

    }


    public function render()
    {

        return view('livewire.admin.resource-client-selector');
    }
}
