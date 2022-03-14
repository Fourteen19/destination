<?php

namespace App\Services\Admin;

use App\Models\Client;
use App\Models\Admin\Admin;
use App\Models\ClientSettings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Class AdminService
{

    /**
     * getAdminsWithRoleAndInstitution
     *
     * @param  mixed $role
     * @param  mixed $institutionId
     * @return void
     */
    public function getAdminsWithRoleAndInstitution($role, $institutionId)
    {

        return Admin::role($role)
                    ->with('institutions:id')
                    ->whereHas('institutions', function($query) use ($institutionId){
                        $query->where('institutions.id', $institutionId);
                    })
            ->get();

    }


    /**
     * delete an admin
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {

        //loads the admin to be deleted
        $admin = Admin::where('id', $id)->firstorfail();

        //rename the email address
        $admin->email = $admin->email."-deleted";
        $admin->save();

        //delete all institutions related to the admin
        $admin->institutions()->detach();

        $frontendUser = $admin->frontendUser;

        $frontendUser->email = $frontendUser->email."-deleted";
        $frontendUser->save();

        //soft delete
        $frontendUser->delete();

        //soft delete
        $admin->delete();

    }



}
