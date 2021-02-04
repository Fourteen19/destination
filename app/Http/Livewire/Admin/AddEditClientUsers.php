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

    public $systemId, $firstName, $lastName, $birthDate, $schoolYear, $postcode, $email, $personalEmail, $password, $confirmPassword;
    public $roni, $rodi;

    public $tagsKeywords, $tagsSubjects, $tagsYearGroups, $tagsTerms, $tagsLscs, $tagsRoutes, $tagsSectors, $tagsFlags;
    public $userSubjectTags = [];
    public $userTermsTags = [];
    public $userYearGroupsTags = [];
    public $userLscsTags = [];
    public $userRoutesTags = [];
    public $userSectorsTags = [];
    public $userFlagTags = [];



    //setup of the component
    public function mount(String $action)
    {

        $this->action = $action;

        $this->user = new User;


        if ($action == "edit")
        {

        }


        $this->tagsLscs = SystemTag::where('type', 'career_readiness')->get()->toArray();
        $userLscsTags = $this->user->tagsWithType('route');
        foreach($userLscsTags as $key => $value){
            $this->userLscsTags[] = $value['name'][ app()->getLocale() ];
        }

        $this->tagsRoutes = SystemTag::where('type', 'route')->get()->toArray();
        $userRoutesTags = $this->user->tagsWithType('route');
        foreach($userRoutesTags as $key => $value){
            $this->userRoutesTags[] = $value['name'][ app()->getLocale() ];
        }

        $this->tagsSectors = SystemTag::where('type', 'sector')->get()->toArray();
        $userSectorsTags = $this->user->tagsWithType('sector');
        foreach($userSectorsTags as $key => $value){
            $this->userSectorsTags[] = $value['name'];
        }

        $this->tagsSubjects = SystemTag::where('type', 'subject')->get()->toArray();
        $userSubjectTags = $this->user->tagsWithType('subject');
        foreach($userSubjectTags as $key => $value){
            $this->userSubjectTags[] = $value['name'];
        }


        $this->activeTab = "user-details";

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
