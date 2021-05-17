<?php

namespace App\Services\Admin;

use App\Models\Client;
use App\Models\VacancyRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Class VacancyRoleService
{


    /**
     * createVacancyRole
     *
     * @param  mixed $validatedData
     * @return void
     */
    public function createVacancyRole($validatedData)
    {
        dd($validatedData);

        $resourceData = ['filename' => $validatedData['filename'],
                         'description' => $validatedData['description'],
                        ];


        $vacancyRole = VacancyRole::create($resourceData);


    }




    /**
     * updateResource
     *
     * @param  mixed $validatedData
     * @return void
     */
    public function updateResource(VacancyRole $vacancyRole, $validatedData)
    {

        $vacancyRoleData = ['name' => $validatedData['name'],
                         'display' => $validatedData['display'],
                        ];

        //update record
        $vacancyRole->update($vacancyRoleData);

    }



    public function show(VacancyRole $vacancyRole)
    {

        try
        {

            //set the display flag
            $vacancyRole->display = 'N';
            $vacancyRole->save();

        } catch (\Exception $e) {

            return false;

        }

        return true;

    }


    public function hide(VacancyRole $vacancyRole)
    {

        try
        {

            //set the display flag
            $vacancyRole->display = 'Y';
            $vacancyRole->save();

        } catch (\Exception $e) {

            return false;

        }

        return true;

    }


    public function delete(VacancyRole $vacancyRole)
    {

        try
        {

            //removes the page
            $vacancyRole->delete();

        } catch (\Exception $e) {

            return false;

        }

        return true;

    }

}
