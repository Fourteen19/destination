<?php

namespace App\Services\Admin;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Institution;



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

        $user = new User;

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

        if (isset($data->postcode)){$user->postcode = $data->postcode;}
        if (isset($data->email)){$user->email = $data->email;}
        if (isset($data->personal_email)){$user->personal_email = $data->personal_email;}
        if (isset($data->password)){$user->password = $data->password;}
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

            if (isset($data->postcode)){$user->postcode = $data->postcode;}
            if (isset($data->email)){$user->email = $data->email;}
            if (isset($data->personal_email)){$user->personal_email = $data->personal_email;}
            if (isset($data->password)){$user->password = $data->password;}
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


}
