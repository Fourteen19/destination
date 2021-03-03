<?php

namespace App\Services\Admin;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Client;
use App\Models\ContentLive;
use App\Models\Institution;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Frontend\SelfAssessmentService;



Class UserService{


    public function getUserDetails($userRef)
    {

        //if the Uuid passed is valid
        if ( Uuid::isValid( $userRef ))
        {
            //if global admin
            if (isGlobalAdmin()){
                $user = User::select('id', 'system_id', 'client_id', 'institution_id', 'first_name', 'last_name', 'birth_date', 'school_year', 'postcode', 'email', 'personal_email', 'roni', 'rodi')->where('uuid', '=', $userRef)->with('tags')->get()->first();

            //else if client user
            } else if ( (isClientAdmin()) || (isClientAdvisor()) ) {
                $user = User::select('id', 'system_id', 'client_id', 'institution_id', 'first_name', 'last_name', 'birth_date', 'school_year', 'postcode', 'email', 'personal_email', 'roni', 'rodi')->where('uuid', '=', $userRef)->with('tags')->BelongsToClientScope()->get()->first();

            //else
            } else {
                abort(401);
            }

        } else {
            abort(404);
        }

        return $user;

    }




    public function addUser($data){

        $user = new User();

        //system Id
        $user->system_id = $this->getSystemId();

        if (isset($data->first_name)){$user->first_name = $data->first_name;}
        if (isset($data->last_name)){$user->last_name = $data->last_name;}
        if (isset($data->birth_date))
        {
            if (!empty($data->birth_date))
            {
                $user->birth_date = $data->birth_date;
            }
        }
        if (isset($data->school_year)){$user->school_year = $data->school_year;}
        if (isset($data->postcode)){$user->postcode = $data->postcode;}
        if (isset($data->email)){$user->email = $data->email;}
        if (isset($data->personal_email)){$user->personal_email = $data->personal_email;}
        if (isset($data->password)){$user->password = Hash::make($data->password);}
        if (isset($data->roni)){$user->roni = $data->roni;}
        if (isset($data->rodi)){$user->rodi = $data->rodi;}

        $user->remember_token = Str::random(10);
        $user->email_verified_at = Carbon::now();

        if (isGlobalAdmin())
        {
            $client = Client::select('id')->where('uuid', '=', $data->client)->get()->first();
        } elseif ( (isClientAdmin()) || (isClientAdvisor()) )
        {
            $client = Client::select('id')->where('uuid', '=', $data->client)->BelongsToSpecificClientScope(Auth::user()->client_id)->get()->first();
        }

        if ($client)
        {
            $user->client_id = $client->id;
        }



        if (isGlobalAdmin())
        {
            $institution = Institution::select('id')->where('uuid', '=', $data->institution)->get()->first();
        } elseif ( (isClientAdmin()) || (isClientAdvisor()) )
        {
            $institution = Institution::select('id')->where('uuid', '=', $data->institution)->BelongsToSpecificClientScope(Auth::user()->client_id)->get()->first();
        }

        if ($institution)
        {
            $user->institution_id = $institution->id;


            $user->save();

            if (isset($data->usertagsNeet)){
                $user->attachTags( !empty($data->usertagsNeet) ? $data->usertagsNeet : [] , 'neet' );
            }

        }

    }



    public function updateUser($data){

        $user = $this->getUserDetails($data->userRef);

        if ($user)
        {

            if (isset($data->first_name)){$user->first_name = $data->first_name;}
            if (isset($data->last_name)){$user->last_name = $data->last_name;}
            if (isset($data->birth_date))
            {
                if (!empty($data->birth_date))
                {
                    $user->birth_date = $data->birth_date;
                }
            }
            if (isset($data->school_year)){$user->school_year = $data->school_year;}
            if (isset($data->postcode)){$user->postcode = $data->postcode;}
            if (isset($data->email)){$user->email = $data->email;}
            if (isset($data->personal_email)){$user->personal_email = $data->personal_email;}
            if (isset($data->password)){$user->password = Hash::make($data->password);}
            if (isset($data->roni)){$user->roni = $data->roni;}
            if (isset($data->rodi)){$user->rodi = $data->rodi;}

            if (isGlobalAdmin())
            {
                $institution = Institution::select('id')->where('uuid', '=', $data->institution)->get()->first();
            } elseif ( (isClientAdmin()) || (isClientAdvisor()) )
            {
                $institution = Institution::select('id')->where('uuid', '=', $data->institution)->BelongsToSpecificClientScope(Auth::user()->client_id)->get()->first();
            }

            if ($institution)
            {
                $user->institution_id = $institution->id;

                $user->update();


                $user->syncTagsWithType([], 'neet');
                if (isset($data->userNeetTags)){
                    $user->attachTags( !empty($data->userNeetTags) ? $data->userNeetTags : [] , 'neet' );
                }

            }

        }

        return False;
    }




    public function getSystemId()
    {

        return 123;

    }


    /**
     * store
     * used in backend. add edit user. fed by livewire
     *
     * @param  mixed $data
     * @return void
     */
    public function store($data){

        if ($data->action == "create")
        {
            $this->addUser($data);
        } elseif ($data->action == "edit"){
            $this->updateUser($data);
        }

    }





    public function getUserdata($user)
    {

        $data = [];

        $data['full_name'] = $user->FullName;
        $data['institution'] = $user->institution->name;

        $selfAssessmentService = new SelfAssessmentService;

        foreach( config('global.school_year') as $key => $value)
        {
            $data['selfAssessment'][$key] = $selfAssessmentService->getSelfAssessmentCareerReadinessForUser($user, $key);
        }

        //get current self assessment
        $selfAssessment = $user->getSelfAssessment($user->school_year);

        //gets the tags associated for the year
        if ($selfAssessment)
        {

            $data['currentSelfAssessment']['tags']['routes'] = $selfAssessment->tagsWithType('route');
            $data['currentSelfAssessment']['tags']['subjects'] = $selfAssessment->tagsWithType('subject');
            $data['currentSelfAssessment']['tags']['sectors'] = $selfAssessment->tagsWithType('sector');

        } else {

            $data['currentSelfAssessment']['tags']['routes'] = NULL;
            $data['currentSelfAssessment']['tags']['subjects'] = NULL;
            $data['currentSelfAssessment']['tags']['sectors'] = NULL;
        }


        //gets the articles read by a user in the current year
        $data['articlesReadThisYear'] = $user->articlesReadThisYear($user->school_year)->select('content_live_user.content_live_id', 'title')->get()->toArray();
        $articleReadIds = [];
        foreach($data['articlesReadThisYear'] as $key => $value)
        {
            $articleReadIds[] = $value['content_live_id'];
        }

        //select keywords used in searches by user
        $data['keywords'] = $user->searchedKeywordsName()->get()->toArray();


        $data['lastLoginDate'] = $user->last_login_date;
        $data['nbLogins'] = $user->nb_logins;

        //gets the number of red flag articles read
        $data['nbRedFlagsArticlesRead'] = ContentLive::withAnyTags(['red flag'], 'flag')->withAnyTags([$user->school_year], 'year')->whereIn('id', $articleReadIds)->count();

//dd($data);

        return $data;

    }

}
