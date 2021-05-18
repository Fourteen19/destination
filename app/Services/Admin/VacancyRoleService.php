<?php

namespace App\Services\Admin;

use App\Models\VacancyRole;
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

        $vacancyRoleData = ['name' => $validatedData['name'],
                            'display' => $validatedData['display'],
                        ];

        $vacancyRole = VacancyRole::create($vacancyRoleData);

    }





    /**
     * updateVacancyRole
     *
     * @param  mixed $vacancyRole
     * @param  mixed $validatedData
     * @return void
     */
    public function updateVacancyRole(VacancyRole $vacancyRole, $validatedData)
    {

        $vacancyRoleData = ['name' => $validatedData['name'],
                            'display' => $validatedData['display'],
                        ];

        //update record
        $vacancyRole->update($vacancyRoleData);

    }



    /**
     * show
     *
     * @param  mixed $vacancyRole
     * @return void
     */
    public function show(VacancyRole $vacancyRole)
    {

        try
        {
            $vacancyRole->update( ['display' => 'Y' ] );

        } catch (\Exception $e) {

            return false;

        }

        return true;

    }


    /**
     * hide
     *
     * @param  mixed $vacancyRole
     * @return void
     */
    public function hide(VacancyRole $vacancyRole)
    {

        try
        {

            $vacancyRole->update( ['display' => 'N' ] );

        } catch (\Exception $e) {

            return false;

        }

        return true;

    }


}
