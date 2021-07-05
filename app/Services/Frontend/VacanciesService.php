<?php

namespace App\Services\Frontend;

use App\Models\Vacancy;
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



    public function getUserVacancies($limit = 1, $exclude = [])
    {

        $selfAssessmentService = new SelfAssessmentService();

        //gets allocated `sector` tags
        $selfAssessmentSectorTags = $selfAssessmentService->getAllocatedSectorTagsName();

        $vacancies = VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                                    ->orderBy('created_at', 'DESC')
                                    ->with('media')
                                    ->with('region:id,name')
                                    ->with('role:id,name')
                                    ->with('employer:id,name')
                                    ->withAnyTags($selfAssessmentSectorTags, 'sector')
                                    ->limit($limit);


        if (count($exclude) > 0)
        {
            $vacancies = $vacancies->whereNotIn('id', $exclude);
        }

        return $vacancies->get();

    }



    /**
     * getVacancies
     * get vacancies ordered by dat
     *
     * @param  mixed $limit
     * @param  mixed $exclude
     * @return void
     */
    public function getVacancies($limit = 1, $exclude=[])
    {

        $vacancies = VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                                        ->with('media')
                                        ->with('region:id,name')
                                        ->with('role:id,name')
                                        ->with('employer:id,name')
                                        ->limit($limit)
                                        ->orderBy('created_at', 'DESC');

        if (count($exclude) > 0)
        {
            $vacancies = $vacancies->whereNotIn('id', $exclude);
        }

        return $vacancies->get();

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

            $userVacancies = $this->getUserVacancies(2, []);

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
        $excludeIds = [$vacancyId];

        if ($vacancyId)
        {

            //get the vacancy
            $vacancy = VacancyLive::findOrFail($vacancyId);

            //collects the vacancy sectors
            $sectors = $vacancy->tagsWithType('sector')->pluck('name');

            //query to select the live vancancy and related data
            $query = VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                                ->whereNotIn('id', [$vacancyId])
                                ->orderBy('created_at', 'DESC')
                                ->with('media')
                                ->with('region:id,name')
                                ->with('role:id,name')
                                ->with('employer:id,name')
                                ->limit(3);

            //if a sector is allocated to, vacancy then update the query
            if (!empty($sectors))
            {
                $query = $query->withAnyTags($sectors, 'sector');
            }

            //query the DB
            $result = $query->get();

            //counts the number of results
            $nbResult = count($result);

            if ($nbResult < 3)
            {

                $nbFetch = 3 - $nbResult;

                $excludeIds = array_merge($excludeIds, $result->pluck('id')->toArray());

                $genericVacancies = $this->getVacancies($nbFetch, $excludeIds);

                $result = $result->merge($genericVacancies);

            }

            return $result;

        }

        return NULL;

    }




    /**
     * getMoreVacancies
     *
     * @param  mixed $nb_events
     * @return void
     */
    public function getMoreVacancies($offset=0, $limit, $exclude)
    {

        //if logged in
        if (Auth::guard('web')->check())
        {

            //get vacancies related to the user's sector
            return $this->getUserVacancies(3, $exclude);


        } else {

            //returns generic vacancies
            $vacancies = VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                                ->with('media')
                                ->with('region:id,name')
                                ->with('role:id,name')
                                ->with('employerImage:id,name')
                                ->limit($limit)
                                ->offset($offset)
                                ->orderBy('created_at', 'DESC');

            if (count($exclude) > 0)
            {
                $vacancies = $vacancies->whereNotIn('id', $exclude);
            }

            return $vacancies->get();

        }

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

/* dd(
    VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
    ->whereIn('id', $featured)
    ->orderBy('created_at', 'DESC')
    ->with('media')
    ->with('region:id,name')
    ->with('role:id,name')
    ->with('employer:id,name')
    ->toSql()

); */

            $featuredVacancies = VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                                            ->whereIn('id', $featured)
                                            ->orderBy('created_at', 'DESC')
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
                $userVacanciesIds = $userVacancies->pluck('id');

                //counts the number of features vacancies
                $nbFeatured = count($featuredVacancies);

                //if less than four
                if ($nbFeatured < 4)
                {

                    $nbFetch = 4 - $nbFeatured;

                    //get more vacancies
                    $extraFeaturedVacancies = $this->getVacancies($nbFetch, $userVacanciesIds->toArray());

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
//dd($featuredVacancies);
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
