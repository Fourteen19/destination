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



}
