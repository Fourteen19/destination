<?php

namespace App\Exports;

use App\Models\User;
use App\Models\ContentLive;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivitiesAnswersExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
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
                                                ->with('relatedActivityQuestions', function ($query) {
                                                    $query->select('id', 'text', 'activquestionable_id', 'activquestionable_type');
                                                    $query->orderby('order_id', 'ASC');
                                                })
                                                ->get()
                                                ->toArray();

        } else {

            //loads a specific activity
            $this->activitiesList = ContentLive::where('id', $activity)
                                                ->where('template_id', 3)
                                                ->select('id', 'title')
                                                ->with('relatedActivityQuestions', function ($query) {
                                                    $query->select('id', 'text', 'activquestionable_id', 'activquestionable_type');
                                                    $query->orderby('order_id', 'ASC');
                                                })
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

            foreach($activity['related_activity_questions'] as $relatedActivityQuestion)
            {

                $titles[] = $relatedActivityQuestion['text'];

            }

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
        $activitiesAnswers = array_fill(0, count($this->activitiesList) * 4, '');

        //if the relation is not empty
        if ($user->allActivityAllAnswers)
        {
            //loop through relation
            foreach ($user->allActivityAllAnswers as $activityAnswer)
            {
                //update the $activitiesStatus array
                $key = array_search($activityAnswer->activquestionable_id, array_column($this->activitiesList, 'id'));
                if (is_numeric($key))
                {
                    $activitiesAnswers[ $key * 4 + $activityAnswer->order_id ] = (!empty($activityAnswer->answer)) ? $activityAnswer->answer : "";
                }

            }

        }

        return array_merge([
            $user->first_name,
            $user->last_name,
            $user->school_year,
            ],
            $activitiesAnswers,
        );
    }



    public function query()
    {

        $activity = $this->activity;

        return User::query()->select('id', 'first_name', 'last_name', 'school_year')
                            ->where('school_year', $this->year)
                            ->where('institution_id', $this->institutionId)
                            ->with('allActivityAllAnswers', function ($query) use ($activity){
                                if ($activity != 'all')
                                {
                                    $query->where('activquestionable_id', $activity);
                                }
                                $query->select('text', 'activquestionable_id', 'activquestionable_type', 'order_id', 'answer');
                                $query->withPivot('answer');
                            });


    }

}
