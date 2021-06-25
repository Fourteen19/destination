<?php

namespace App\Services\Frontend;

use App\Models\VacancyLive;

Class VacanciesService
{

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct() {
        //
    }


    public function getLatestVacancies()
    {

        return VacancyLive::select('id', 'title', 'lead_para', 'slug')
                            ->orderBy('updated_at', 'DESC')
                            ->with('media')
                            ->limit(2)
                            ->get();

    }



    /**
     * getRelatedVacancy
     * gets related vacancies
     *
     * @param  mixed $vacancyId
     * @return void
     */
    public function getRelatedVacancy($vacancyId)
    {

        return VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                            ->orderBy('updated_at', 'DESC')
                            ->with('media')
                            ->with('region:id,name')
                            ->with('role:id,name')
                            ->with('employer:id,name')
                            ->limit(3)
                            ->get();



    }





    /**
     * getFeaturedVacancies
     * gets featured vacancies
     *
     * @param  mixed $vacancyId
     * @return void
     */
    public function getFeaturedVacancies()
    {

        return VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                            ->orderBy('updated_at', 'DESC')
                            ->with('media')
                            ->with('region:id,name')
                            ->with('role:id,name')
                            ->with('employer:id,name')
                            ->limit(4)
                            ->get();



    }

}
