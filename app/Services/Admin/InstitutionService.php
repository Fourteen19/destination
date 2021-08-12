<?php

namespace App\Services\Admin;

use App\Models\Institution;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Class InstitutionService
{


    /**
     * delete
     *
     * @param  mixed $institution
     * @return void
     */
    public function delete($institutionId)
    {

        //load the institution
        $institution = Institution::findorfail($institutionId);

        //update the record of users. set users as orphans
        $institution->users()->update(['institution_id' => NULL]);

        //set the institution to deleted
        $institution->delete();

    }



}
