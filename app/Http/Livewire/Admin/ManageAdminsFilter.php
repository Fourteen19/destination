<?php

namespace App\Http\Livewire\Admin;

use App\Models\Role;
use App\Models\Client;
use Livewire\Component;
use App\Models\Institution;

class ManageAdminsFilter extends Component
{

    public $institutions = [];
    public $institution;

    public $rolesList;
    public $role;

    //setup of the component
    public function mount($institution)
    {

        //loads the roles
        //if global admin
        if (session()->get('adminAccessLevel') == 3){
            $this->rolesList = Role::orderBy('name','asc')->pluck('name','name')->all();
        } else {
            $this->rolesList = Role::wherein('level', [1,2])->orderBy('name','asc')->pluck('name','name')->all();
        }

        $this->institution = $institution;
    }

    //renders the component
    public function render()
    {

        //finds the institutions filtering by client
        $this->institutions = Institution::select('uuid', 'name')->where('client_id', '=', session()->get('adminClientSelectorSelected'))->orderBy('name')->get();

        return view('livewire.admin.manage-admins-filter');
            //->withClients(Client::orderBy('name')->get());

    }
}
