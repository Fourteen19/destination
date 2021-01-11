<?php

namespace App\Http\Livewire\Admin;

use App\Models\Role;
use App\Models\Client;
use Livewire\Component;
use App\Models\Institution;

class ClientInstitutionAdminTypeFilter extends Component
{

    public $client;
    public $institutions = [];
    public $institution;

    public $rolesList;
    public $role;
    
    //setup of the component
    public function mount($client, $institution)
    {

        //loads the roles
        //if global admin
        if (session()->get('adminAccessLevel') == 3){
            $this->rolesList = Role::orderBy('name','asc')->pluck('name','name')->all();
        } else {
            $this->rolesList = Role::wherein('level', [1,2])->orderBy('name','asc')->pluck('name','name')->all();
        }

        $this->client = $client;
        $this->institution = $institution;
    }

    //renders the component
    public function render()
    {
    
        //if a client option is selected in the dropdown 
        if (!empty($this->client)) {

            //we get the client from the DB using the uuid passed from the dropdown
            $client = Client::select('id')->where('uuid', '=', $this->client)->get()->first();
           
            //finds the institutions filtering by client
            $this->institutions = Institution::select('uuid', 'name')->where('client_id', '=', $client->id)->orderBy('name')->get();
        }

        return view('livewire.admin.client-institution-admin-type-filter')
            ->withClients(Client::orderBy('name')->get());

    }
}
