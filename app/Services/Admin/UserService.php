<?php

namespace App\Services\Admin;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Client;
use App\Models\Admin\Admin;
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
            if (isGlobalAdmin())
            {
                //, 'personal_email'
                $user = User::select('id', 'system_id', 'client_id', 'institution_id', 'first_name', 'last_name', 'birth_date', 'school_year', 'postcode', 'email', 'roni', 'rodi')->where('uuid', '=', $userRef)->with('tags')->get()->first();

            //else if client user
            } else if ( (isClientAdmin()) || (isClientAdvisor()) ) {
                //, 'personal_email'
                $user = User::select('id', 'system_id', 'client_id', 'institution_id', 'first_name', 'last_name', 'birth_date', 'school_year', 'postcode', 'email', 'roni', 'rodi')->where('uuid', '=', $userRef)->with('tags')->CanOnlySeeClient(Auth::user()->client_id)->get()->first();

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


        $user->system_id = $this->getSystemId();

        //$user->personal_email = NULL;

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
        /* if (isset($data->personal_email)){
            if (empty($data->personal_email)){
                $user->personal_email = NULL;
            } else {
                $user->personal_email = $data->personal_email;
            }
        } */

        if (isset($data->password)){$user->password = Hash::make($data->password);}
        if (isset($data->roni)){$user->roni = $data->roni;}
        if (isset($data->rodi)){$user->rodi = $data->rodi;}

        $user->remember_token = Str::random(10);
        $user->email_verified_at = Carbon::now();

        if (isGlobalAdmin())
        {
            $client = Client::select('id')->where('uuid', '=', $data->client)->get()->first();
            $user->client_id = $client->id;

        } elseif ( (isClientAdmin()) || (isClientAdvisor()) )
        {
            $user->client_id = Auth::user()->client_id;
        }


        if (isGlobalAdmin())
        {
            $institution = Institution::select('id')->where('uuid', '=', $data->institution)->get()->first();
        } elseif ( (isClientAdmin()) || (isClientAdvisor()) )
        {
            $institution = Institution::select('id')->where('uuid', '=', $data->institution)->CanOnlySeeClientInstitutions(Auth::user()->client_id)->get()->first();
        }

        if ($institution)
        {
            $user->institution_id = $institution->id;

        }

        $user->save();

        if (isset($data->usertagsNeet)){
            $user->attachTags( !empty($data->usertagsNeet) ? $data->usertagsNeet : [] , 'neet' );
        }

    }



    public function storeAdminAsUser($adminID, $password){

        $admin = Admin::find($adminID);

        $user = new User();
        $user->type = 'admin';
        $user->school_year = 10;


        $user->first_name = $admin->first_name;
        $user->last_name = $admin->last_name;

        $user->email = $admin->email;
        $user->password = Hash::make($password);

        $user->client_id = $admin->client_id;
        $user->admin_id = $adminID;

        $user->save();

        return $user;

    }



    public function updateAdminAsUser($adminID, $password){

        $admin = Admin::find($adminID);

        $user = $admin->frontendUser;

        if ($user)
        {

            $user->first_name = $admin->first_name;
            $user->last_name = $admin->last_name;

            $user->email = $admin->email;

            if (!empty($password))
            {
                $user->password = Hash::make($password);
            }

            $user->save();
        }
    }

    /**
     * createBlankAssessmentForAdmin
     * When creating a user for an admin, we also create an assessement with everything blanked
     * Career readiness is set to an avergae of 3. range 2-3
     * No route
     * No subject
     * No sector
     *
     * @param  mixed $user
     * @return void
     */
    public function createBlankAssessmentForAdmin($user)
    {

        $selfAssessmentService = new SelfAssessmentService();

        $selfAssessment = $selfAssessmentService->getSelfAssessmentForUser($user);

        $selfAssessmentService->allocateSubjectTagsForAssessment($selfAssessment, []);

        $selfAssessmentService->AllocateRouteTagsForAssessment($selfAssessment, []);

        $selfAssessmentService->AllocateSectorTagsForAssessment($selfAssessment, []);

        $selfAssessment->syncTagsWithType(['2-3'], 'career_readiness');
        $selfAssessment->career_readiness_average = 3;
        $selfAssessment->career_readiness_score_1 = 3;
        $selfAssessment->career_readiness_score_2 = 3;
        $selfAssessment->career_readiness_score_3 = 3;
        $selfAssessment->career_readiness_score_4 = 3;
        $selfAssessment->career_readiness_score_5 = 3;
        $selfAssessment->save();

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
                $client = Client::select('id')->where('uuid', '=', $data->client)->get()->first();
                $user->client_id = $client->id;

            } elseif ( (isClientAdmin()) || (isClientAdvisor()) )
            {
                $user->client_id = Auth::user()->client_id;
            }



            if (isGlobalAdmin())
            {
                $institution = Institution::select('id')->where('uuid', '=', $data->institution)->get()->first();
            } elseif ( (isClientAdmin()) || (isClientAdvisor()) )
            {
                $institution = Institution::select('id')->where('uuid', '=', $data->institution)->CanOnlySeeClientInstitutions(Auth::user()->client_id)->get()->first();
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
    public function store($data)
    {

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
            $data['currentSelfAssessment']['tags']['subjects'] = $selfAssessment->tagsWithSubjectTypeAndAssessmentScoreLessThan('subject', 2);
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


        //gets user's activities
        $activities = $user->userActivitiesCompleted()->get();

        $data['activities'] = [];
        if (count($activities) > 0)
        {

            foreach($activities as $key => $value)
            {
                $tmp = [];

                $tmp['title'] = $value->title;
                $tmp['completed'] = $value->pivot->completed;

                //gets the activity answers
                $answers = $user->activityAnswers($value->id)->get();

                if (count($answers) > 0)
                {
                    foreach($answers as $key_question => $value_question)
                    {
                        $tmp_answers = [];
                        $tmp_answers['text'] = $value_question->text;
                        $tmp_answers['answer'] = $value_question->pivot->answer;

                        $tmp['answers'][] = $tmp_answers;
                    }

                }

                $data['activities'][] = $tmp;

            }
        }

/* dd($data['activities']); */

        return $data;

    }

}
