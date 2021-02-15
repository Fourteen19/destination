<?php

namespace App\Services\Admin;

use App\Models\Page;
use Ramsey\Uuid\Uuid;
use App\Models\Institution;



Class PageService{


    public function getPageDetails($pageRef)
    {

        //if the Uuid passed is valid
        if ( Uuid::isValid( $pageRef ))
        {
            //if global admin
            if (isGlobalAdmin()){
                $page = Page::select('id', 'title', 'lead', 'body')->where('uuid', '=', $pageRef)->get()->first();

            //else if client page
            } else if ( (isClientAdmin()) || (isClientAdvisor()) ) {
                $page = Page::select('id', 'title', 'lead', 'body')->where('uuid', '=', $pageRef)->BelongsToClientScope()->get()->first();

            //else
            } else {
                abort(401);
            }

        } else {
            abort(404);
        }

        return $page;

    }



/*
    public function addPage($data){

        $page = new Page;

        //system Id
        $page->system_id = $this->getSystemId();

        if (isset($data->first_name)){$page->first_name = $data->first_name;}
        if (isset($data->last_name)){$page->last_name = $data->last_name;}
        if (isset($data->birth_date))
        {
            if (!empty($data->birth_date))
            {
                $page->birth_date = $data->birth_date;
            }
        }

        if (isset($data->postcode)){$page->postcode = $data->postcode;}
        if (isset($data->email)){$page->email = $data->email;}
        if (isset($data->personal_email)){$page->personal_email = $data->personal_email;}
        if (isset($data->password)){$page->password = $data->password;}
        if (isset($data->roni)){$page->roni = $data->roni;}
        if (isset($data->rodi)){$page->rodi = $data->rodi;}

        if (isGlobalAdmin())
        {
            $institution = Institution::select('id')->where('uuid', '=', $data->institution)->get()->first();
        } elseif ( (isClientAdmin()) || (isClientAdvisor()) )
        {
            $institution = Institution::select('id')->where('uuid', '=', $data->institution)->BelongsToSpecificClientScope(Auth::page()->client_id)->get()->first();
        }

        if ($institution)
        {
            $page->institution_id = $institution->id;

            $page->save();

            if (isset($data->pagetagsNeet)){
                $page->attachTags( !empty($data->pagetagsNeet) ? $data->pagetagsNeet : [] , 'neet' );
            }

        }

    }



    public function updatePage($data){

        $page = $this->getPageDetails($data->pageRef);

        if ($page)
        {

            if (isset($data->first_name)){$page->first_name = $data->first_name;}
            if (isset($data->last_name)){$page->last_name = $data->last_name;}
            if (isset($data->birth_date))
            {
                if (!empty($data->birth_date))
                {
                    $page->birth_date = $data->birth_date;
                }
            }

            if (isset($data->postcode)){$page->postcode = $data->postcode;}
            if (isset($data->email)){$page->email = $data->email;}
            if (isset($data->personal_email)){$page->personal_email = $data->personal_email;}
            if (isset($data->password)){$page->password = $data->password;}
            if (isset($data->roni)){$page->roni = $data->roni;}
            if (isset($data->rodi)){$page->rodi = $data->rodi;}

            if (isGlobalAdmin())
            {
                $institution = Institution::select('id')->where('uuid', '=', $data->institution)->get()->first();
            } elseif ( (isClientAdmin()) || (isClientAdvisor()) )
            {
                $institution = Institution::select('id')->where('uuid', '=', $data->institution)->BelongsToSpecificClientScope(Auth::page()->client_id)->get()->first();
            }

            if ($institution)
            {
                $page->institution_id = $institution->id;

                $page->update();


                $page->syncTagsWithType([], 'neet');
                if (isset($data->pageNeetTags)){
                    $page->attachTags( !empty($data->pageNeetTags) ? $data->pageNeetTags : [] , 'neet' );
                }

            }

        }

        return False;
    }




    public function getSystemId()
    {

        return 123;

    }

    public function store($data){

        if ($data->action == "create")
        {
            $this->addPage($data);
        } elseif ($data->action == "edit"){
            $this->updatePage($data);
        }

    }
*/

}
