<?php

namespace App\Exports;

use App\Models\User;
use App\Models\SystemTag;
use App\Models\Admin\Admin;
use App\Services\Admin\ReportingService;
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
    protected $sectorTags;
    protected $subjectTags;


    public function __construct(int $clientId, int $institutionId, int $year, $activity)
    {

        $this->clientId = $clientId;
        $this->institutionId = $institutionId;
        $this->year = $year;

        if ($activity)
        {
            $this->activities = [];
        }
    }



    /**
     * @return array
     */
    public function headings(): array
    {

        //creates CSV Headings for Tags
        $activitiesList = [];//app('reportingService')->compileTagsHeading($this->routeTags);

        return array_merge([
            'First Name',
            'Last Name',
            'School Year',
        ],
        $activitiesList,
        );

    }


    /**
    * @var User $user
    */
    public function map($user): array
    {

        $activitiesCompleted = array_fill(0, count($this->activities), 'N');

        /* if ($selfAssessment)
        {
            $crsScore = $selfAssessment->career_readiness_average;

            if ($selfAssessment->tags)
            {

                //loops through the tags in the self assessment
                foreach($selfAssessment->tags as $tag)
                {

                    if ($tag->type == 'route')
                    {

                        $key = array_search($tag->id, array_column($this->routeTags, 'id'));
                        $userRoutesSelected[$key] = ($tag->pivot->score == 0) ? '0' : $tag->pivot->score;

                    } elseif ($tag->type == 'sector') {

                        $key = array_search($tag->id, array_column($this->sectorTags, 'id'));
                        $userSectorsSelected[$key] = ($tag->pivot->score == 0) ? '0' : $tag->pivot->score;

                    } elseif ($tag->type == 'subject') {

                        $key = array_search($tag->id, array_column($this->subjectTags, 'id'));
                        $userSubjectsSelected[$key] = ($tag->pivot->score == 0) ? '0' : $tag->pivot->score;
                    }

                }

            }

        } */

        return array_merge([
            $user->first_name,
            $user->last_name,
            $user->school_year,
            ],
            $activitiesCompleted,
        );
    }



    public function query()
    {
        return User::query()->select('id', 'first_name', 'last_name', 'school_year')
                            ->where('school_year', $this->year)
                            ->where('institution_id', $this->institutionId);

    }
}
