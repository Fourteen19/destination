<?php

namespace App\Services\Admin;

use App\Models\Institution;
use App\Services\Admin\AdminService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Class InstitutionService
{

    protected $adminService;

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct(AdminService $adminService) {

        $this->adminService = $adminService;

    }


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

        //update the record of frontend users. set users as orphans
        $institution->users()->update(['institution_id' => NULL]);

        //gets admins
        $admins = $this->adminService->getAdminsWithRoleAndInstitution([config('global.admin_user_type.Advisor'), config('global.admin_user_type.Teacher')], $institutionId);

        if ($admins)
        {

            foreach($admins as $admin)
            {
                $admin->institutions()->detach( $institutionId );
            }

        }

        //set the institution to deleted
        $institution->delete();

    }



}
