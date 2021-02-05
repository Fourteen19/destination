<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\SystemTag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddEditClientUsers extends Component
{

    use AuthorizesRequests;

    public $activeTab;
    public $action;
    public $userRef;

    public $system_id, $first_name, $last_name, $birth_date, $school_year, $postcode, $email, $personal_email;
    public $roni, $rodi;

    public $tagsNeet;
    public $userNeetTags = [];
/*
    public $tagsSubjects, $tagsLscs, $tagsRoutes, $tagsSectors;
    public $userSubjectTags = [];
    public $userLscsTags = [];
    public $userRoutesTags = [];
    public $userSectorsTags = [];
*/


    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'personal_email' => 'email',
       // 'institution_id' => 'required|numeric',
        'birth_date' => 'date_format:d/m/Y',
        'school_year' => 'numeric',
        'postcode' => 'string|max:10',
        'rodi' => 'numeric',
        'roni' => 'numeric',
        'tagsNeet' => '',
    ];


    protected $messages = [

    ];

    //setup of the component
    public function mount(String $action, String $userRef)
    {

        $this->action = $action;

        if ($action == "add")
        {

            $user = new User;

            $this->system_id = '';
            $this->first_name = '';
            $this->last_name = '';
            $this->birth_date = '';
            $this->school_year = '';
            $this->postcode = '';
            $this->email = '';
            $this->personal_email = '';
            $this->roni = '';
            $this->rodi = '';

        } else {



            if (isGlobalAdmin()){
                $user = User::select('system_id', 'first_name', 'last_name', 'birth_date', 'school_year', 'postcode', 'email', 'personal_email', 'roni', 'rodi')->where('uuid', '=', $userRef)->get()->first();
            } else if ( (isClientAdmin()) || (isClientAdvisor()) ) {
                $user = User::select('system_id', 'first_name', 'last_name', 'birth_date', 'school_year', 'postcode', 'email', 'personal_email', 'roni', 'rodi')->where('uuid', '=', $userRef)->BelongsToClientScope()->get()->first();
            } else {
                abort(401);
            }


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

        }

        $this->tagsNeet = SystemTag::where('type', 'neet')->get()->toArray();
        $userNeetTags = $user->tagsWithType('neet');
        foreach($userNeetTags as $key => $value){
            $this->userNeetTags[] = $value['name'][ app()->getLocale() ];
        }

/*
        $this->tagsLscs = SystemTag::where('type', 'career_readiness')->get()->toArray();
        $userLscsTags = $user->tagsWithType('route');
        foreach($userLscsTags as $key => $value){
            $this->userLscsTags[] = $value['name'][ app()->getLocale() ];
        }

        $this->tagsRoutes = SystemTag::where('type', 'route')->get()->toArray();
        $userRoutesTags = $user->tagsWithType('route');
        foreach($userRoutesTags as $key => $value){
            $this->userRoutesTags[] = $value['name'][ app()->getLocale() ];
        }

        $this->tagsSectors = SystemTag::where('type', 'sector')->get()->toArray();
        $userSectorsTags = $user->tagsWithType('sector');
        foreach($userSectorsTags as $key => $value){
            $this->userSectorsTags[] = $value['name'];
        }

        $this->tagsSubjects = SystemTag::where('type', 'subject')->get()->toArray();
        $userSubjectTags = $user->tagsWithType('subject');
        foreach($userSubjectTags as $key => $value){
            $this->userSubjectTags[] = $value['name'];
        }
*/

        $this->activeTab = "user-details";

    }




    public function store()
    {

        $this->validate($this->rules, $this->messages);

        try {

            $this->contentService = new ContentArticleService();
            $this->contentService->store($this);

            Session::flash('success', 'User Created Successfully');


        } catch (exception $e) {

            Session::flash('fail', 'Content not Created Successfully');

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
        return view('livewire.admin.add-edit-client-users');
    }
}
