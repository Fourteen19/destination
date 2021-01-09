<?php

namespace App\Http\Livewire\Admin;

use App\Models\Role;
use App\Models\Client;
use Livewire\Component;
use App\Models\Institution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AllocateRoleToAdmin extends Component
{

    public $action; //create or edit

    public $role;
    public $rolesList = [];

    public $displayClientsDropdown ;
    public $displayInstitutionsDropdown;
    public $client;
    public $clientsList = [];

    public $institutions;
    public $institutionsList = [];


    protected $rules = [
        'institutions' => '',
    ];

    //setup of the component
    public function mount($role, $client, $institutions)
    {


        //loads the roles
        if (session()->get('adminAccessLevel') == 3){
            $this->rolesList = Role::orderBy('name','asc')->pluck('name','name')->all();
        } else {
            $this->rolesList = Role::wherein('level', [1,2])->orderBy('name','asc')->pluck('name','name')->all();
        }

        //loads the clients
        $this->clientsList = Client::orderBy('name','asc')->pluck('name','uuid')->all();

        //Detects if we 'create' or 'edit'
        if (in_array('create', Request::segments() ) ){
            $this->action = "create";
            $this->displayClientsDropdown = 0;
        } else {
            $this->action = "edit";
        }

        $this->role = $role;
        $this->client = $client;
        $this->institutions = $institutions->pluck('uuid')->toArray();

        if (in_array($this->role, [ config('global.admin_user_type.Client_Admin'), config('global.admin_user_type.Client_Content_Admin'), config('global.admin_user_type.Advisor'), config('global.admin_user_type.Third_Party_Admin') ] ))
        {

            $this->isClientAdmin();
            $this->hasClient();

            if (in_array($this->role, [ config('global.admin_user_type.Advisor') ] ))
            {
                $this->hasInstitutions();
            }

        } else {
            $this->hasNoClient();
        }


    }



    public function isClientAdmin()
    {

        if (in_array($this->role, [ config('global.admin_user_type.Client_Admin'), config('global.admin_user_type.Client_Content_Admin'), config('global.admin_user_type.Advisor'), config('global.admin_user_type.Third_Party_Admin') ] ))
        {
            //if a role is set, display the clients list
            if ($this->role){
                $this->displayClientsDropdown = 1;

                //if NOT Advisor, hide institutions
                if (!in_array($this->role, [ config('global.admin_user_type.Advisor') ] ))
                {
                    $this->displayInstitutionsDropdown = 0;
                } else {
                    $this->displayInstitutionsDropdown = 1;
                    $this->loadClientsInstitutions();
                }
            } else {
                $this->displayClientsDropdown = 0;
                $this->displayInstitutionsDropdown = 0;
            }

        }

    }


    public function hasClient($resetInstitutions = False)
    {

        if (in_array($this->role, [ config('global.admin_user_type.Client_Admin'), config('global.admin_user_type.Client_Content_Admin'), config('global.admin_user_type.Advisor'), config('global.admin_user_type.Third_Party_Admin') ] ))
        {

            $this->displayClientsDropdown = 1;

            if (in_array($this->role, [ config('global.admin_user_type.Advisor') ] ))
            {

                if ($resetInstitutions == True)
                {
                    $this->institutions = [];
                }

                //if a client is set, display the institutions list
                $this->loadClientsInstitutions();
                $this->displayInstitutionsDropdown = 1;

            }

        } else {

        }

    }



    public function hasNoClient()
    {

        //hides HTML elements
        $this->displayClientsDropdown = 0;
        $this->displayInstitutionsDropdown = 0;

        //reset values
        $this->client = '';
        $this->institutions = '';
    }


    public function hasInstitutions()
    {




    }



    /**
     * Validate single a field
     */
    public function updated($propertyName)
    {

        if ($propertyName == "role"){

            if (in_array($this->role, [ config('global.admin_user_type.Client_Admin'), config('global.admin_user_type.Client_Content_Admin'), config('global.admin_user_type.Advisor'), config('global.admin_user_type.Third_Party_Admin') ] ))
            {
                /*
                //if a role is set, display the clients list
                if ($this->role){
                    $this->displayClientsDropdown = 1;

                    //if NOT Advisor, hide institutions
                    if (!in_array($this->role, [ config('global.admin_user_type.Advisor') ] ))
                    {
                        $this->displayInstitutionsDropdown = 0;
                    } else {
                        $this->displayInstitutionsDropdown = 1;
                        $this->loadClientsInstitutions();
                    }
                } else {
                    $this->displayClientsDropdown = 0;
                    $this->displayInstitutionsDropdown = 0;
                }
                */
                $this->isClientAdmin();

            //if global admins
            } else {
/*
                $this->displayClientsDropdown = 0;
                $this->displayInstitutionsDropdown = 0;
            */

                $this->hasNoClient();

            }

        } elseif ($propertyName == "client"){


            if (in_array($this->role, [ config('global.admin_user_type.Client_Admin'), config('global.admin_user_type.Client_Content_Admin'), config('global.admin_user_type.Advisor'), config('global.admin_user_type.Third_Party_Admin') ] ))
            {

                $this->hasClient(True);

                /*
                $this->displayClientsDropdown = 1;

                if (in_array($this->role, [ config('global.admin_user_type.Advisor') ] ))
                {

                    //if a client is set, display the institutions list
                    $this->loadClientsInstitutions();
                    $this->displayInstitutionsDropdown = 1;

                }
                */

            } else {

                $this->hasNoClient();
/*
                $this->displayInstitutionsDropdown = 0;
                $this->displayClientsDropdown = 0;
            */
                }

            } elseif ($propertyName == "institutions"){

                if (in_array($this->role, [ config('global.admin_user_type.Client_Admin'), config('global.admin_user_type.Client_Content_Admin'), config('global.admin_user_type.Advisor'), config('global.admin_user_type.Third_Party_Admin') ] ))
                {
                    $this->hasClient(False);

                }

                //dd($this->institutions);
            }


    }


    public function loadClientsInstitutions()
    {
        //if a client is selected
        if ($this->client)
        {

            //we get the client from the DB using the uuid passed from the dropdown
            $client = Client::select('id')->where('uuid', '=', $this->client)->get()->first();

            //finds the institutions filtering by client
            $this->institutionsList = Institution::select('uuid', 'name')->where('client_id', '=', $client->id)->orderBy('name')->get();

        }

    }


    public function render()
    {

        return view('livewire.admin.allocate-role-to-admin');
    }
}
