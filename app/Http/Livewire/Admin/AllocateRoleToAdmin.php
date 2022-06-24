<?php

namespace App\Http\Livewire\Admin;

use App\Models\Role;
use App\Models\Client;
use Livewire\Component;
use App\Models\Employer;
use App\Models\Admin\Admin;
use App\Models\Institution;
use Illuminate\Support\Facades\DB;
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
    public $displayEmployersDropdown;
    public $displayContactMe;

    public $client;
    public $clientsList = [];

    public $institutions;
    public $institutionsList = [];
    public $adminInstitutionUuid;

    public $employer;
    public $employersList = [];

    public $contactMe;
    public $uuid; //user Uuid

    protected $rules = [
        'institutions' => '',
    ];

    //setup of the component
    public function mount($roleParam, $clientParam, $institutionsParam, $contactMeParam, $adminUuid, $employerParam)
    {

        $this->contactMe = ($contactMeParam == 'Y') ? 1 : NULL;

        //initialises
        $this->displayContactMe = 0;

        //loads the roles
        if (session()->get('adminAccessLevel') == 3){
            $this->rolesList = Role::orderBy('name','asc')->pluck('name','name')->all();
            $this->employersList = Employer::orderBy('name','asc')->pluck('name','uuid')->all();
        } else {
            $this->rolesList = Role::wherein('level', [0,1,2])->orderBy('name','asc')->pluck('name','name')->all();
            $this->employersList = Employer::orderBy('name','asc')->pluck('name','uuid')->all();
        }

        //loads the clients
        $this->clientsList = Client::orderBy('name','asc')->pluck('name','uuid')->all();

        //Detects if we 'create' or 'edit'
        if (in_array('create', Request::segments() ) ){

            $this->action = "create";

            //hides the client and institutions
            $this->displayClientsDropdown = 0;
            $this->displayInstitutionsDropdown = 0;
            $this->displayEmployersDropdown = 0;

        } else if (in_array('edit', Request::segments() ) ){

            $this->action = "edit";
            $this->institutions = $institutionsParam;


             $this->uuid = $adminUuid;

            //if the creator is system admin level
            if (isGlobalAdmin())
            {

                //loads data about the admin being edited
                $admin = Admin::select('id', 'client_id')->with('institutions:uuid')->where('uuid', $this->uuid)->first();

                //if the admin has a client
                if ($admin->client_id)
                {
                    //lods the institution
                    if ($admin->institutions->first())
                    {
                        //loads the institution uuid
                        $this->adminInstitutionUuid = $admin->institutions->first()->uuid;
                    }
                }



            //if the creator is client admin level
            } elseif (isClientAdmin()){

                $admin = Admin::select('id', 'client_id')->where('uuid', $this->uuid)->where('client_id', Auth::guard('admin')->user()->client_id)->with('institutions:uuid')->first();

                if ($admin->institutions->first())
                {
                    $this->adminInstitutionUuid = $admin->institutions->first()->uuid;
                }

            }

        } else {

            abort(404);
        }


        $this->role = $roleParam;
        $this->client = $clientParam;

        //if a collection (when we create)
        if (!is_array($institutionsParam)){
            if ($institutionsParam->count() > 0)
            {
                $this->institutions = $institutionsParam->pluck('uuid');
            }
        } else {
            $this->institutions = $institutionsParam;
        }


        //if employer, reset the dropdown
        if (in_array($this->role, [ config('global.admin_user_type.Employer') ] ))
        {
            $this->employer = $employerParam;

        }


        //if editing a client admin
        if (in_array($this->role, [
            config('global.admin_user_type.Client_Admin'),
            config('global.admin_user_type.Client_Content_Admin'),
            config('global.admin_user_type.Advisor'),
            config('global.admin_user_type.Teacher'),
            config('global.admin_user_type.Careers_Leader'),
            config('global.admin_user_type.Third_Party_Admin'),
            config('global.admin_user_type.Employer'),
        ] ))
        {

            //if the user is a Client Admin
            $this->isClientAdmin();

        //when editing, if editing a global admin
        } else {

            $this->hasNoClient();
        }

    }



    /**
     * isClientAdmin
     * if the Admin we are creating is of a client type
     *
     *
     * @param  mixed $resetInstitutions
     * @return void
     */
    public function isClientAdmin()
    {

        //if the admin logged in is a Global admin
        if (isGlobalAdmin()){

            //display the client dropdown
            $this->displayClientsDropdown = 1;

        } else {

            $this->displayClientsDropdown = 0;
            $this->client =  Session::get('adminClientSelectorSelection');
        }


        $this->displayEmployersDropdown = 0;

        //if the role selected is NOT Advisor or teacher , hide institutions
        if (!in_array($this->role, [ config('global.admin_user_type.Advisor'), config('global.admin_user_type.Teacher'), config('global.admin_user_type.Careers_Leader'), ] ))
        {
            $this->displayInstitutionsDropdown = 0;
            $this->displayContactMe = 0;

            if (in_array($this->role, [ config('global.admin_user_type.Employer') ] ))
            {
                $this->displayEmployersDropdown = 1;

            }

        } elseif (in_array($this->role, [ config('global.admin_user_type.Teacher'), config('global.admin_user_type.Careers_Leader'), ] ))
        {

            $this->displayContactMe = 0;

            //if a client has been selected, we load the institutions and display them
            if ($this->client){

                $this->displayInstitutionsDropdown = 1;
                $this->loadClientsInstitutions();

            }

        //else if the role selected is advisor
        } else {

            $this->displayContactMe = 1;

            //if a client has been selected, we load the institutions and display them
            if ($this->client){

                $this->displayInstitutionsDropdown = 1;
                $this->loadClientsInstitutions();

            }
        }

    }

    /**
     * hasNoClient
     * if the user created is a global admin
     * @return void
     */
    public function hasNoClient()
    {

        //hides HTML elements
        $this->displayClientsDropdown = 0;
        $this->displayInstitutionsDropdown = 0;
        $this->displayEmployersDropdown = 0;
        $this->displayContactMe = 0;

        //reset values
        $this->client = '';
        $this->institutions = [];
    }



    public function isEmployerAdmin()
    {

        $this->displayEmployersDropdown = 1;

    }


    /**
     * Validate single a field
     */
    public function updated($propertyName)
    {
        //if the role is changed
        if ($propertyName == "role"){

            //if client admin
            if (in_array($this->role, [
                            config('global.admin_user_type.Client_Admin'),
                            config('global.admin_user_type.Client_Content_Admin'),
                            config('global.admin_user_type.Advisor'),
                            config('global.admin_user_type.Teacher'),
                            config('global.admin_user_type.Careers_Leader'),
                            config('global.admin_user_type.Third_Party_Admin'),
                            config('global.admin_user_type.Employer')
                            ]
            ))
            {

                //if the user created/edited is a Client Admin
                $this->isClientAdmin();

            //if employer admin
/*             } elseif (in_array($this->role, [
                    config('global.admin_user_type.Employer'),
                    ])) {

                //$this->hasNoClient();
                $this->isEmployerAdmin();
 */
            //if global admins
            } else {

                $this->hasNoClient();

            }

        } elseif ($propertyName == "client"){

            if (in_array($this->role, [
                config('global.admin_user_type.Client_Admin'),
                config('global.admin_user_type.Client_Content_Admin'),
                config('global.admin_user_type.Advisor'),
                config('global.admin_user_type.Teacher'),
                config('global.admin_user_type.Careers_Leader'),
                config('global.admin_user_type.Third_Party_Admin'),
                config('global.admin_user_type.Employer'), ]
            ))
            {

                $this->isClientAdmin();

            } else {

                $this->hasNoClient();

            }

        } elseif ( ($propertyName == "institutions") || (($propertyName == "contactMe")) ){

            if (in_array($this->role, [ config('global.admin_user_type.Advisor') ] ))
            {

                $this->loadClientsInstitutions();

            }

        }

    }


    public function loadClientsInstitutions()
    {
        //if a client is selected
        if ($this->client)
        {

            //we get the client from the DB using the uuid passed from the dropdown
            $client = Client::select('id')->where('uuid', '=', $this->client)->first();

            //finds the institutions filtering by client
            $institutionsList = Institution::select('id', 'uuid', 'name')
                                            ->where('client_id', '=', $client->id)
                                            ->with('admins:first_name,last_name,uuid')
                                            ->with('admins.roles:name')
                                            ->orderBy('name')
                                            ->get();

            $this->institutionsList = [];
            foreach($institutionsList as $key => $institution)
            {

                //if the role selected in the dropdown is `advisor`
                if (in_array($this->role, [ config('global.admin_user_type.Advisor')]) )
                {

                    $institutionAdminUuid = [];

                    // dd($institution);
                    if ($institution->id == 1){
                       //dd($institution->adminsWithRoles);
                    }

                    //foreach($institution->advisors as $keyAdmin => $valueAdmin)
                    foreach($institution->adminsWithRoles as $keyAdmin => $valueAdmin)
                    {
                        //if the admin is an advisor
                        if ($valueAdmin->hasRole(config('global.admin_user_type.Advisor')))
                        {
                            $institutionAdminUuid[] = $valueAdmin->uuid;
                        }
                    }

                    $temp = array(
                        'uuid' => $institution['uuid'],
                        'name' => $institution['name'],
                        'admin_uuid' => $institutionAdminUuid, //gets the admins UUID allocated to the institution
                        'current_nb_allocation' => count($institutionAdminUuid), //gets the number of admin allocated fo this institution
                        'advisor_name' => ''
                    );

                    //gets the name of the advisors. compiled in string
                    if (count($institution['admins']) > 0)
                    //if (count($institution->advisors) > 0)
                    {
                        $advisors = [];
                        //dd($institution['admins']);
                        foreach($institution['admins'] as $key => $admin)
                        {
                            if ($admin->hasRole(config('global.admin_user_type.Advisor')))
                            {
                                $advisors[] = $admin['first_name'].' '.$admin['last_name'];
                            }
                        }
                        $temp['advisor_name'] = implode(", ", $advisors);
                    }

                //if the role selected in the dropdown is `teacher`
                } elseif (in_array($this->role, [config('global.admin_user_type.Teacher'), config('global.admin_user_type.Careers_Leader'),]) )
                {

                    $institutionAdminUuid = [];
                    foreach($institution->admins as $keyAdmin => $valueAdmin)
                    {
                        if ( $valueAdmin->hasAnyRole([config('global.admin_user_type.Teacher'), config('global.admin_user_type.Careers_Leader')]) )
                        {
                            $institutionAdminUuid[] = $valueAdmin->uuid;
                        }
                    }

                    $temp = array(
                        'uuid' => $institution['uuid'],
                        'name' => $institution['name'],
                        'admin_uuid' => $institutionAdminUuid, //gets the admins UUID allocated to the institution
                        'current_nb_allocation' => count($institutionAdminUuid), //gets the number of admin allocated fo this institution
                        'advisor_name' => ''
                    );


                }

                $this->institutionsList[] = $temp;
            }

        }

    }


    public function render()
    {
        return view('livewire.admin.allocate-role-to-admin');
    }

}
