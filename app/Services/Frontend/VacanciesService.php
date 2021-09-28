<?php

namespace App\Services\Frontend;

use App\Models\Vacancy;
use App\Models\VacancyLive;
use Illuminate\Support\Facades\DB;
use App\Models\VacanciesTotalStats;
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

    public function getUserVacancies($limit, $exclude, $offset)
    {

        $selfAssessmentService = new SelfAssessmentService();

        //gets allocated `sector` tags
        $selfAssessmentSectorTags = $selfAssessmentService->getAllocatedSectorTagsName();

        //gets allocated `route` tags
        $selfAssessmentRouteTags = $selfAssessmentService->getAllocatedRouteTagsName();

        $vacancies = VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                                    ->orderBy('created_at', 'DESC')
                                    ->with('media')
                                    ->with('region:id,name')
                                    ->with('role:id,name')
                                    ->with('employer:id,name')
                                    ->current();

        if (count($exclude) > 0)
        {
            $vacancies = $vacancies->whereNotIn('id', $exclude);
        }

        if ($offset > 0)
        {
            $vacancies = $vacancies->offset($offset);
        }

        //MUST filters vacancies last to get the correct vacancies
        $vacancies = $vacancies->where(function($query) use ($selfAssessmentSectorTags) {
                                        $query->withAnyTags($selfAssessmentSectorTags, 'sector');
                                    })
                                    ->orwhere(function($query) use ($selfAssessmentRouteTags) {
                                        $query->withAnyTags($selfAssessmentRouteTags, 'route');
                                    })
                                    ->limit($limit);

        return $vacancies->get();

    }



    /**
     * getVacancies
     * get vacancies ordered by date
     *
     * @param  mixed $limit
     * @param  mixed $exclude
     * @return void
     */
    public function getVacanciesNumber()
    {

        $vacancies = VacancyLive::select(DB::raw('count(*) as number_of_vacancies'))->current()->first()->toArray();

        return $vacancies['number_of_vacancies'];

    }



    /**
     * getVacancies
     * get vacancies ordered by date
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
                                        ->current()
                                        ->limit($limit)
                                        ->orderBy('created_at', 'DESC');
//dd($vacancies->get());
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

            $userVacancies = $this->getUserVacancies(2, [], 0);

            $nbVacancies = count($userVacancies);

            if ($nbVacancies < 2)
            {

                $nbRecords = 2 - $nbVacancies;

                $genericVacancies = VacancyLive::select('id', 'title', 'lead_para', 'slug', 'region_id', 'display_until', 'role_id', 'employer_id', 'created_at')
                                    ->orderBy('created_at', 'DESC')
                                    ->with('media')
                                    ->with('region:id,name')
                                    ->with('role:id,name')
                                    ->with('employer:id,name')
                                    ->current()
                                    ->limit($nbRecords)
                                    ->get();

                $vacancies = $userVacancies->merge($genericVacancies);

                return $vacancies;

            } else {

                return $userVacancies;

            }

        } else {

            return VacancyLive::select('id', 'title', 'lead_para', 'slug', 'region_id', 'role_id', 'display_until', 'employer_id', 'created_at')
                                ->orderBy('created_at', 'DESC')
                                ->with('media')
                                ->with('region:id,name')
                                ->with('role:id,name')
                                ->with('employer:id,name')
                                ->current()
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
                                ->current()
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
    public function getMoreVacancies($offset, $limit, $exclude)
    {

/*         //if logged in
        if (Auth::guard('web')->check())
        {

            //get vacancies related to the user's sector
            return $this->getUserVacancies(3, $exclude, $offset);


        } else { */

            //returns generic vacancies
            $vacancies = VacancyLive::select('id', 'title', 'slug', 'region_id', 'role_id', 'employer_id', 'created_at')
                                ->with('media')
                                ->with('region:id,name')
                                ->with('role:id,name')
                                ->with('employerImage:id,name')
                                ->current()
                                ->limit($limit)
                                ->orderBy('created_at', 'DESC');

            if (count($exclude) > 0)
            {
                $vacancies = $vacancies->whereNotIn('id', $exclude);
            }

            if ($offset > 0)
            {
                $vacancies = $vacancies->offset($offset);
            }

            return $vacancies->get();

        /* } */

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
                                            ->orderBy('created_at', 'DESC')
                                            ->with('media')
                                            ->with('region:id,name')
                                            ->with('role:id,name')
                                            ->with('employer:id,name')
                                            ->current()
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
                $userVacancies = $this->getUserVacancies($nbFetch, $featured, 0);

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




    /**
     * incrementViewingCounter
     * incremnets the total stats
     *
     * @param  mixed $id
     * @return void
     */
    public function incrementViewingCounter($id)
    {
        DB::beginTransaction();

        try {

            $updateData = [];
            $keys = [];

            if (Auth::guard('web')->check())
            {

                $year = Auth::guard('web')->user()->school_year;
                $updateData['year_'.$year] = DB::raw('year_'.$year.' + 1');

                $keys['institution_id'] = Auth::guard('web')->user()->institution_id;

            } else {

                $keys['institution_id'] = NULL;

            }

            VacanciesTotalStats::updateorCreate(
                array_merge([
                'vacancy_id' => $id,
                'client_id' => Session::get('fe_client')['id'],
                'year_id' => app('currentYear'),
                ], $keys),
                array_merge(['total' =>  DB::raw('total + 1')], $updateData)
                );

                DB::commit();

        } catch (\Exception $e) {

            DB::rollback();

        }

    }



    /**
     * userAccessVacancies
     * When a user accesses a vacancy, the folowing actions are processed
     *
     * @param  mixed $id
     * @return void
     */
    public function userAccessVacancies($id)
    {
        //if logged in
        if (Auth::guard('web')->check())
        {

            //if user type
            if (Auth::guard('web')->user()->type == 'user')
            {

                $this->incrementViewingCounter($id);

            }

        } else {

            $this->incrementViewingCounter($id);

        }

    }

}
