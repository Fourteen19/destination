<?php

namespace App\Exports;

use App\Models\User;
use App\Models\ContentLive;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivitiesExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

    protected $clientId;
    protected $institutionId;
    protected $activities;
    protected $activity;

    public function __construct(int $clientId, int $institutionId, int $year, $activity)
    {

        $this->clientId = $clientId;
        $this->institutionId = $institutionId;
        $this->year = $year;
        $this->activity = $activity;

        if ($activity == 'all')
        {

            //loads all the activities
            $this->activitiesList = ContentLive::where('template_id', 3)
                                                ->select('id', 'title')
                                                ->get()
                                                ->toArray();

        } else {

            //loads a specific activity
            $this->activitiesList = ContentLive::where('id', $activity)
                                                ->where('template_id', 3)
                                                ->select('id', 'title')
                                                ->limit(1)
                                                ->get()
                                                ->toArray();
        }
    }



    /**
     * @return array
     */
    public function headings(): array
    {

        //creates CSV Headings for Tags
        $titles = [];
        foreach($this->activitiesList as $activity)
        {
            $titles[] = $activity['title'];
        }

        return array_merge([
            'First Name',
            'Last Name',
            'School Year',
        ],
        $titles,
        );

    }


    /**
    * @var User $user
    */
    public function map($user): array
    {
        //fills array with default values for all activities
        $activitiesStatus = array_fill(0, count($this->activitiesList), 'N');

        //if the relation is not empty
        if ($user->userActivities)
        {
            //loop through relation
            foreach ($user->userActivities as $userActivity)
            {
                //if the pivot indicates the activity has been completed
                if ($userActivity->pivot->completed == 'Y')
                {

                    //update the $activitiesStatus array
                    $key = array_search($userActivity->id, array_column($this->activitiesList, 'id'));
                    if (is_numeric($key))
                    {
                        $activitiesStatus[$key] = 'Y';
                    }

                }

            }

        }

        return array_merge([
            $user->first_name,
            $user->last_name,
            $user->school_year,
            ],
            $activitiesStatus,
        );
    }



    public function query()
    {

        $activity = $this->activity;

        return User::query()->select('id', 'first_name', 'last_name', 'school_year')
                            ->where('school_year', $this->year)
                            ->where('institution_id', $this->institutionId)
                            ->with('userActivities', function ($query) use ($activity){
                                if ($activity != 'all')
                                {
                                    $query->where('content_live_id', $activity);
                                }
                            });


    }

}
