<?php

namespace App\Services\Admin;

use App\Models\VacancyRegion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
Class VacancyRegionService
{

    /**
     * createVacancyRegion
     *
     * @param  mixed $validatedData
     * @return void
     */
    public function createVacancyRegion($validatedData)
    {

        $vacancyRegionData = ['name' => $validatedData['name'],
                              'display' => $validatedData['display'],
                              'client_id' => Session::get('adminClientSelectorSelected'),
                            ];


        $vacancyRegion = VacancyRegion::create($vacancyRegionData);


    }




    /**
     * updateResource
     *
     * @param  mixed $validatedData
     * @return void
     */
    public function updateVacancyRegion(VacancyRegion $vacancyRegion, $validatedData)
    {

        $vacancyRegionData = ['name' => $validatedData['name'],
                              'display' => $validatedData['display'],
                              'client_id' => Session::get('adminClientSelectorSelected'),
                            ];

        //update record
        $vacancyRegion->update($vacancyRegionData);

    }



    public function show(VacancyRegion $vacancyRegion)
    {

        try
        {
            $vacancyRegion->update( ['display' => 'Y' ] );

        } catch (\Exception $e) {

            Log::error($e);

            return false;

        }

        return true;

    }


    public function hide(VacancyRegion $vacancyRegion)
    {

        try
        {

            $vacancyRegion->update( ['display' => 'N' ] );

        } catch (\Exception $e) {

            Log::error($e);

            return false;

        }

        return true;

    }


}
