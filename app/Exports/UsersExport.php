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

class UsersExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

    protected $clientId;
    protected $institutionId;
    protected $routeTags;
    protected $sectorTags;
    protected $subjectTags;


    public function __construct(int $clientId, int $institutionId)
    {

        $this->clientId = $clientId;
        $this->institutionId = $institutionId;

        $this->adviserNames = app('reportingService')->getInstitutionAdvisers($institutionId);//->get()->sortby('name')->pluck('name', 'id');

        //selects the System Tags
        $this->routeTags = SystemTag::select('id', 'name')->where('type', 'route')->where('live', 'Y')->get()->sortby('name')->toArray();
        $this->sectorTags = SystemTag::select('id', 'name')->where('type', 'sector')->where('live', 'Y')->get()->sortby('name')->toArray();
        $this->subjectTags = SystemTag::select('id', 'name')->where('type', 'subject')->where('live', 'Y')->get()->sortby('name')->toArray();

    }



    /**
     * @return array
     */
    public function headings(): array
    {

        //creates CSV Headings for Tags
        $routesList = app('reportingService')->compileTagsHeading($this->routeTags);
        $sectorsList = app('reportingService')->compileTagsHeading($this->sectorTags);
        $subjectsList = app('reportingService')->compileTagsHeading($this->subjectTags);

        return array_merge([
            'First Name',
            'Last Name',
            'Date of Birth',
            'School Year',
            'Postcode',
            'School/Client Email Address', // (Primary)
            'Alternate Email Address',
            'RONI',
            'RODI',
            'NEET 16-18',
            'NEET 18+',
            'Below Level 2',
            'Adviser(s)',
            'Times Logged in',
            'No of articles read',
            'No of red flag articles read',
            'CV Builder Accessed',
            'CRS Score',
        ],
        $routesList,
        $sectorsList,
        $subjectsList,
        );

    }


    /**
    * @var User $user
    */
    public function map($user): array
    {

        $selfAssessment = $user->getSelfAssessment($user->school_year);
        $crsScore = "N/A";
        $userRoutesSelected = array_fill(0, count($this->routeTags), '0');
        $userSectorsSelected = array_fill(0, count($this->sectorTags), '0');
        $userSubjectsSelected = array_fill(0, count($this->subjectTags), '0');

        if ($selfAssessment)
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

        }

        return array_merge([
            $user->first_name,
            $user->last_name,
            $user->birth_date,
            $user->school_year,
            $user->postcode,
            $user->email,
            $user->personal_email,
            ($user->roni == 0) ? '0' : $user->roni,
            ($user->rodi == 0) ? '0' : $user->rodi,
            ($user->tags->contains('name', "NEET 18+")) ? "Y" : "N",
            ($user->tags->contains('name', "NEET 16-18")) ? "Y" : "N",
            ($user->tags->contains('name', "Below Level 2")) ? "Y" : "N",
            $this->adviserNames,
            ($user->nb_logins == 0) ? '0' : $user->nb_logins,
            $user->articlesReadForYear($user->school_year)->count(),
            ($user->nb_red_flag_articles_read == 0) ? '0' : $user->nb_red_flag_articles_read,
            $user->cv_builder_completed,
            $crsScore,
            ],
            $userRoutesSelected,
            $userSectorsSelected,
            $userSubjectsSelected,
        );
    }



    public function query()
    {

        return User::query()->select('id', 'first_name', 'last_name', 'birth_date', 'school_year', 'postcode', 'email', 'personal_email',
                                     'roni', 'rodi', 'nb_logins','nb_red_flag_articles_read', 'cv_builder_completed')
                            ->with('tags')
<<<<<<< HEAD
                            ->where('institution_id', $this->institutionId);
=======
                            ->where('institution_id', $this->institutionId)
                            ->where('type', 'user');
>>>>>>> 321-bespoke-report

    }

}
