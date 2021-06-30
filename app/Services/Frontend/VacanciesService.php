<?php

namespace App\Services\Frontend;

use App\Models\VacancyLive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Class VacanciesService
{

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct() {

    }



    public function getUserVacancies($limit = 1)
    {

        $selfAssessmentService = new SelfAssessmentService();

        //gets allocated `sector` tags
        $selfAssessmentSectorTags = $selfAssessmentService->getAllocatedSectorTagsName();

        return VacancyLive::select('id', 'title', 'lead_para', 'slug')
                                    ->orderBy('created_at', 'DESC')
                                    ->with('media')
                                    ->withAnyTags($selfAssessmentSectorTags, 'sector')
                                    ->limit($limit)
                                    ->get();

    }



    /**
     * getVacancies
     * get vacancies ordered by dat
     *
     * @param  mixed $limit
     * @param  mixed $exclude
     * @return void
     */
    public function getVacancies($limit = 1, $exclude = [])
    {

        return VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                                        ->whereNotIn('id', $exclude)
                                        ->orderBy('created_at', 'DESC')
                                        ->with('media')
                                        ->with('region:id,name')
                                        ->with('role:id,name')
                                        ->with('employer:id,name')
                                        ->limit($limit)
                                        ->get();
    }





    /**
     * getLatestVacancies
     *
     * @return void
     */
    public function getLatestVacancies()
    {

        if (Auth::guard('web')->check())
        {

            $userVacancies = $this->getUserVacancies(2);

            $nbVacancies = count($userVacancies);

            if ($nbVacancies < 2)
            {

                $nbRecords = 2 - $nbVacancies;

                $genericVacancies = VacancyLive::select('id', 'title', 'lead_para', 'slug')
                                    ->orderBy('created_at', 'DESC')
                                    ->with('media')
                                    ->limit($nbRecords)
                                    ->get();

                $vacancies = $userVacancies->merge($genericVacancies);

                return $vacancies;

            } else {

                return $userVacancies;

            }

        } else {

            return VacancyLive::select('id', 'title', 'lead_para', 'slug')
                                ->orderBy('created_at', 'DESC')
                                ->with('media')
                                ->limit(2)
                                ->get();

        }

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
        if ($vacancyId)
        {

            $vacancy = VacancyLive::findOrFail($vacancyId);

            $sectors = $vacancy->tagsWithType('sector')->pluck('name');

            $query = VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                                ->orderBy('created_at', 'DESC')
                                ->with('media')
                                ->with('region:id,name')
                                ->with('role:id,name')
                                ->with('employer:id,name')
                                ->limit(3);


            if (!empty($sectors))
            {
                $query = $query->withAnyTags($sectors, 'sector');
            }

            return $query->get();


        }

        return NULL;

    }




    /**
     * getMoreVacancies
     *
     * @param  mixed $nb_events
     * @return void
     */
    public function getMoreVacancies($offset=0, $limit)
    {
        return VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                            ->with('media')
                            ->with('region:id,name')
                            ->with('role:id,name')
                            ->with('employerImage:id,name')
                            ->Where(function($query) {
                                $query->where('client_id', NULL)
                                ->orWhere('client_id', Session::get('fe_client')->id);
                            })
                            ->limit($limit)
                            ->offset($offset)
                            ->orderBy('created_at', 'DESC')
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

        //gets the vacancies selected from the backend
        $clientFeaturedVacancies = app('clientContentSettigsSingleton')->getFeaturedVacancies();

        $featured = [];
        for($i=1;$i<=4;$i++)
        {
            if ( (!empty($clientFeaturedVacancies['featured_vacancy_'.$i])) && (!in_array($clientFeaturedVacancies['featured_vacancy_'.$i], $featured)) )
            {
                $featured[] = $clientFeaturedVacancies['featured_vacancy_'.$i];
            }

        }

        //counts the number of featured vacancies found
        $nbFeatured = count($featured);

        //inits collection
        $featuredVacancies = collect([]);

        if ($nbFeatured > 0)
        {

            $featuredVacancies = VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                                            ->whereIn('id', $featured)
                                            ->orderBy('updated_at', 'DESC')
                                            ->with('media')
                                            ->with('region:id,name')
                                            ->with('role:id,name')
                                            ->with('employer:id,name')
                                            ->get();

        }


        //if logged in
        if (Auth::guard('web')->check())
        {

            //if less than four
            if ($nbFeatured < 4)
            {

                $nbFetch = 4 - $nbFeatured;

                //get vacancies related to the user's sector
                $userVacancies = $this->getUserVacancies($nbFetch, $featured);

                //merge to features
                $featuredVacancies = $featuredVacancies->merge($userVacancies);

                //collects user vacancies Ids
                $userVacanciesIds = [];
                $userVacanciesuserVacanciesIds = $userVacancies->pluck('id');

                //counts the number of features vacancies
                $nbFeatured = count($featuredVacancies);

                //if less than four
                if ($nbFeatured < 4)
                {

                    $nbFetch = 4 - $nbFeatured;

                    //get more vacancies
                    $extraFeaturedVacancies = $this->getVacancies($nbFetch, $userVacanciesIds);

                    //merge
                    $featuredVacancies = $featuredVacancies->merge($extraFeaturedVacancies);

                }

            }

        } else {

            //if less than four
            if ($nbFeatured < 4)
            {

                $nbFetch = 4 - $nbFeatured;

                //get generic vacancies
                $extraFeaturedVacancies = $this->getVacancies($nbFetch, $featured);

                //merge collections
                $featuredVacancies = $featuredVacancies->merge($extraFeaturedVacancies);

            }

        }

        return $featuredVacancies;

    }




    /**
     * getLiveVacancyDetailsByUuid
     * get the ID of the vacancy selected
     *
     * @param  mixed $vacancyUuid
     * @return void
     */
    public function getLiveVacancyDetailsByUuid($uuid)
    {

        if (!empty($uuid))
        {
            $data = VacancyLive::select('id')->where('uuid', '=', $uuid)->first();
            if ($data)
            {
                return $data['id'];
            }

        }

        return NULL;

    }



    public function getLiveVacancyUuidById($id)
    {

        if (!empty($id))
        {
            $data = VacancyLive::select('uuid')->where('id', '=', $id)->first();
            if ($data)
            {
                return $data['uuid'];
            }
        }

        return NULL;
    }

}
