<?php

namespace App\Services\Admin;

use App\Models\Admin\Admin;

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
        $admin->email = $admin->email."-deleted-".date('YmdHis');
        $admin->save();

        //delete all institutions related to the admin
        $admin->institutions()->detach();

        $frontendUser = $admin->frontendUser;

        $frontendUser->email = $frontendUser->email."-deleted-".date('YmdHis');
        $frontendUser->save();

        //removes all login access
        $frontendUser->searchedKeywordsName()->detach();

        //deletes user's activities answers (pivot table)
        $frontendUser->allActivityAnswers()->detach();

        //deletes user's activities (pivot table)
        $frontendUser->userActivities()->detach();

        //deletes user's self-assessments
        $frontendUser->selfAssessment()->forceDelete();

        //deletes user's dashboard
        $frontendUser->dashboard()->forceDelete();

        //deletes user's cv
        $frontendUser->cv()->forceDelete();

        //hard delete
        $frontendUser->delete();

        //soft delete as we need to keep the relationship for edited content
        $admin->delete();

    }



}
