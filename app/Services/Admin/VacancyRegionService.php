<?php

namespace App\Services\Admin;

use App\Models\Client;
use App\Models\VacancyRegion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Class VacancyRegionService
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


        $vacancyRole = VacancyRegion::create($resourceData);


    }




    /**
     * updateResource
     *
     * @param  mixed $validatedData
     * @return void
     */
    public function updateResource(VacancyRegion $vacancyRegion, $validatedData)
    {

        $vacancyRegionData = ['name' => $validatedData['name'],
                         'display' => $validatedData['display'],
                        ];

        //update record
        $vacancyRegion->update($vacancyRegionData);

    }



    public function show(VacancyRegion $vacancyRegion)
    {

        try
        {

            //set the display flag
            $vacancyRegion->display = 'N';
            $vacancyRegion->save();

        } catch (\Exception $e) {

            return false;

        }

        return true;

    }


    public function hide(VacancyRegion $vacancyRegion)
    {

        try
        {

            //set the display flag
            $vacancyRegion->display = 'Y';
            $vacancyRegion->save();

        } catch (\Exception $e) {

            return false;

        }

        return true;

    }


    public function delete(VacancyRegion $vacancyRegion)
    {

        try
        {

            //removes the page
            $vacancyRegion->delete();

        } catch (\Exception $e) {

            return false;

        }

        return true;

    }

}
