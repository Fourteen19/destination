<?php

namespace App\Http\Livewire\Admin;

use App\Models\Client;
use Livewire\Component;
use App\Models\Institution;

class AdminClientInstitution extends Component
{

    public $roles;
    public $adminRole;
    public $client;
    public $clients;
    public $institutions = [];
    public $institution;
    public $displayClientDropdown = 0;
    public $displayInstitutionDropdown = 0;

    //setup of the component
    public function mount($roles, $client)
    {
        $this->roles = $roles;
        $this->client = $client;
    }

    public function render()
    {

        //if a client option is selected in the dropdown
        if (!empty($this->adminRole)) {

            $adminLevel = getAdminLevelByRole($this->adminRole);

            if ($adminLevel == 3){
                $this->displayClientDropdown = 0;
                $this->displayInstitutionDropdown = 0;

            } elseif ($adminLevel == 2){
                $this->displayClientDropdown = 1;
                $this->displayInstitutionDropdown = 0;

            } elseif ($adminLevel == 1){
                $this->displayClientDropdown = 1;
                $this->displayInstitutionDropdown = 1;

            } else {


            }

            //if we need to display the list of clients
            if ($this->displayClientDropdown == 1){

                if (!empty($this->client)) {

                    //we get the client from the DB using the uuid passed from the dropdown
                    $this->client_selected = Client::select('id')->where('uuid', '=', $this->client)->get()->first();

                    $this->clients = Client::orderBy('name')->get();

                } else {

                    $this->clients = Client::orderBy('name')->get();

                }

            }


            if ($this->displayInstitutionDropdown == 1){

                if (!empty($this->client)) {



                    //finds the institutions filtering by client
                    $this->institutions = Institution::select('uuid', 'name')->where('client_id', '=', $client->id)->orderBy('name')->get();

                }
            }

        } else {

            $this->displayClientDropdown = 0;
            $this->displayInstitutionDropdown = 0;

        }


        return view('livewire.admin.admin-client-institution')
            ->withClients($this->clients);


        //->withClients(Client::orderBy('name')->get());
    }
}
