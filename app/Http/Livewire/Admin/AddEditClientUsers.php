<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Client;
use Livewire\Component;
use App\Models\SystemTag;
use App\Models\Institution;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddEditClientUsers extends Component
{

    use AuthorizesRequests;

    public $activeTab;
    public $action;
    public $userRef;

    public $system_id, $first_name, $last_name, $birth_date, $school_year, $postcode, $email, $personal_email, $password, $confirmPassword;
    public $roni, $rodi;

    public $tagsNeet;
    public $userNeetTags = [];

    public $displayClientsDropdown;
    public $clientsList = [];
    public $client;

    public $institutionsList = [];
    public $institution = "";

    public $advisers = [];

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'institution' => 'required|uuid|exists:institutions,uuid',
        'birth_date' => 'nullable|date_format:d/m/Y',
        'school_year' => 'required|numeric',
        'postcode' => 'nullable|string|max:10',
        'rodi' => 'numeric',
        'roni' => 'numeric',
        'userNeetTags' => '',
    ];

    protected $messages = [

    ];

    //setup of the component
    public function mount()
    {

         //Detects if we 'create' or 'edit'
        if (in_array('create', Request::segments() ) )
        {
            $this->action = "create";

            $this->system_id = 'To be allocated';
            $this->first_name = '';
            $this->last_name = '';
            $this->birth_date = '';
            $this->school_year = '';
            $this->postcode = '';
            $this->email = '';
            $this->personal_email = '';
            $this->roni = 0;
            $this->rodi = 0;

        } elseif (in_array('edit', Request::segments() ) ){

            $this->action = "edit";

            $this->userRef = Request::segments()[2];
            $user = $this->getUserDetails( $this->userRef );

            $this->system_id = $user->system_id;
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->birth_date = $user->birth_date;

            $this->school_year = $user->school_year;
            $this->postcode = $user->postcode;
            $this->email = $user->email;
            $this->personal_email = $user->personal_email;
            $this->roni = $user->roni;
            $this->rodi = $user->rodi;


            if (isGlobalAdmin()){
                $clientId = $user->client_id;
                $institutionId  = $user->institution_id;
            } else {
                $clientId = session()->get('adminClientSelectorSelected'); // id
                $institutionId  = $user->institution_id;
            }

            $client =  Client::select('uuid')->where('id', '=', $clientId)->get()->first();  //'1da867a0-396f-4bf9-a881-bbabf2fef232';//$user->client_id;
            $this->client = $client->uuid;

            $institution = Institution::select('uuid')->where('id', '=', $institutionId)->get()->first();//'cabb22ba-d8c6-4375-935e-c2eb71fab848';
            $this->institution = $institution->uuid;

        //if not 'edit' and not 'create'
        } else {
            abort(404);
        }


        if (isGlobalAdmin()){
            $this->displayClientsDropdown = 1;

            //loads the clients
            $this->clientsList = Client::orderBy('name','asc')->pluck('name','uuid')->all();

        } else if (isClientAdmin()){
            $this->displayClientsDropdown = 0;
        } else if (isClientAdvisor() ) {
            $this->displayClientsDropdown = 0;
        }

        $this->advisers = [];


        $this->tagsNeet = SystemTag::select('uuid', 'name')->where('type', 'neet')->get()->toArray();
        if ($this->action == "edit")
        {
            $userNeetTags = $user->tagsWithType('neet');
            foreach($userNeetTags as $key => $value){
                $this->userNeetTags[] = $value['name'];
            }
        }

        $this->activeTab = "user-details";

    }


    public function getUserDetails()
    {
        $userService = new UserService();
        $user = $userService->getUserDetails($this->userRef);

        return $user;

    }


    /**
     * Validate single a field
     */
    public function updated($propertyName)
    {

        if ($propertyName == "client"){

            $this->validateOnly($propertyName);

            $this->institution = "";
            $this->advisers = [];

        }


        if ($propertyName == "institution"){

            $this->validateOnly($propertyName);
        }

    }



    public function loadClientsInstitutions()
    {
        //if a client is selected
        if ( ($this->client) || (isClientAdmin()) || (isClientAdvisor()) )
        {

            if (isGlobalAdmin()){
                $clientUuid = $this->client; //uuid passed by dropdown
            } elseif ( (isClientAdmin()) || isClientAdvisor() ) {
                $clientUuid = session()->get('adminClientSelectorSelection'); // uuid
            }

            //we get the client from the DB using the uuid passed from the dropdown
            $client = Client::select('id')->where('uuid', '=', $clientUuid)->get()->first();

            //finds the institutions filtering by client
            //$this->institutionsList = Institution::select('uuid', 'name')->CanOnlySeeClientInstitutions($client->id)->orderBy('name')->get();
            $institutionsList = Institution::select('uuid', 'name')->CanOnlySeeClientInstitutions($client->id);

            //if the admin is an advisor, they can only see the institutions they manage
            if (isClientAdvisor())
            {
                //creates a CSV string fromthe list of the admin's institutions
                $inInstitutions = implode(',', Auth::guard('admin')->user()->compileInstitutionsToArray() );

                $this->institutionsList = $institutionsList->whereIn('institutions.id', [$inInstitutions]);
            }

            $this->institutionsList = $institutionsList->orderBy('name')->get();



            //if an institution is selected
            if ($this->institution)
            {

                //if the Uuid passed is valid
                if ( Uuid::isValid( $this->institution ))
                {

                    $institution = Institution::where('uuid', '=', $this->institution)->CanOnlySeeClientInstitutions($client->id)->with('admins')->get()->first();

                    $this->advisers = $institution->admins()->select('admins.first_name', 'admins.last_name')->get();

                 } else {
                    $this->institution = "";
                    $this->advisers = [];
                }

            } else {
                $this->institution = "";
                $this->advisers = [];
            }

        } else {

            $this->institutionsList = [];
            $this->institution = "";
            $this->advisers = [];

        }

    }




    public function store()
    {

        if ($this->action == "create"){

            $this->rules['email'] = 'required|email|max:255|unique:users,email,personal_email';
            $this->rules['personal_email'] = 'nullable|email|max:255|unique:users,email,personal_email';
            $this->rules['password'] = 'required|same:confirmPassword|min:8';

            $msg_action = "created";

        } else {

            $user = $this->getUserDetails();

            $this->rules['email'] = 'required|email|max:255|unique:users,email,'.$user->id;
            $this->rules['personal_email'] = 'nullable|email|max:255|unique:users,personal_email,'.$user->id;
            $this->rules['password'] = 'nullable|same:confirmPassword|min:8';

            $msg_action = "updated";

        }

        if (isGlobalAdmin()){
            $this->rules['client'] = 'required|uuid';
        }

        $this->validate($this->rules, $this->messages);

        DB::beginTransaction();

        try {

            $this->userService = new UserService();
            $this->userService->store($this);

            DB::commit();

            Session::flash('success', 'You user has been '.$msg_action.' successfully');

        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('error', 'You user could not be '.$msg_action.' successfully');

        }

        if ($this->action == "create")
        {
            return redirect()->route('admin.users.index');
        }


    }



    /**
     * Keeps track of the active Tab
     *
     */
    public function updateTab($tabName)
    {
        $this->activeTab = $tabName;
    }




    public function render()
    {
        //dd(Session::all());
        $this->loadClientsInstitutions();

        return view('livewire.admin.add-edit-client-users');

    }
}
