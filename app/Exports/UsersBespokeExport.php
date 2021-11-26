<?php

namespace App\Exports;

use App\Models\User;
use App\Models\SystemTag;
use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersBespokeExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

    protected $clientId;
    protected $institutionId;
    protected $filters;
    protected $routeTags;
    protected $sectorTags;
    protected $subjectTags;


    public function __construct(int $clientId, $institutionId, $filters)
    {

        $this->clientId = $clientId;
        $this->institutionId = (array)$institutionId;
        $this->filters = $filters;

        //$institutionId = (array)$institutionId;
        //dd($institutionId);
        foreach($this->institutionId as $institution)
        {
            $this->adviserNames[$institution] = app('reportingService')->getInstitutionAdvisers($institution);//->get()->sortby('name')->pluck('name', 'id');
        }

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

        if ($this->filters['extendedVersion'] == 1)
        {

            //creates CSV Headings for Tags
            $routesList = app('reportingService')->compileTagsHeading($this->routeTags);
            $sectorsList = app('reportingService')->compileTagsHeading($this->sectorTags);
            $subjectsList = app('reportingService')->compileTagsHeading($this->subjectTags);

            return [

                ['Filters summary'],
                ['Year Groups', implode(", ", $this->filters['yearGroupSelected']) ],
                ['Careers Readiness Score', implode(", ", $this->filters['tagsCrsSelected']) ],
                ['Subjects', implode(", ", $this->filters['tagsSubjectsSelected']) ],
                ['Routes', implode(", ", $this->filters['tagsRoutesSelected']) ],
                ['Sectors', implode(", ", $this->filters['tagsSectorsSelected']) ],
                ['CV Builder Completed', ($this->filters['cvCompleted'] == 0) ? "N/A" : $this->filters['cvCompleted'] ],
                ['Red Flag', ($this->filters['redFlag'] == 0) ? "N/A" : $this->filters['redFlag'] ],
                [''],
                [''],

                array_merge(
                [
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
                )
            ];

        } else {

            return [

                ['Filters summary'],
                ['Year Groups', implode(", ", $this->filters['yearGroupSelected']) ],
                ['Careers Readiness Score', implode(", ", $this->filters['tagsCrsSelected']) ],
                ['Subjects', implode(", ", $this->filters['tagsSubjectsSelected']) ],
                ['Routes', implode(", ", $this->filters['tagsRoutesSelected']) ],
                ['Sectors', implode(", ", $this->filters['tagsSectorsSelected']) ],
                ['CV Builder Completed', ($this->filters['cvCompleted'] == 0) ? "N/A" : $this->filters['cvCompleted'] ],
                ['Red Flag', ($this->filters['redFlag'] == 0) ? "N/A" : $this->filters['redFlag'] ],
                [''],
                [''],
                [
                'First Name',
                'Last Name',
                'School Year',
                'Postcode',
                'School/Client Email Address', // (Primary)
                'Times Logged in',
                ]
            ];
        }

    }


    /**
    * @var User $user
    */
    public function map($user): array
    {

        if ($this->filters['extendedVersion'] == 1)
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
                $this->adviserNames[$user->institution_id] ?? "",
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

        } else {

            return array_merge([
                $user->first_name,
                $user->last_name,
                $user->school_year,
                $user->postcode,
                $user->email,
                ($user->nb_logins == 0) ? '0' : $user->nb_logins,
            ]);

        }
    }



    public function query()
    {

        $filters = $this->filters;


        $institutionId = $this->institutionId;

        $query = User::query()->select('id', 'first_name', 'last_name', 'birth_date', 'school_year', 'postcode', 'email', 'personal_email',
                                     'institution_id', 'roni', 'rodi', 'nb_logins','nb_red_flag_articles_read', 'cv_builder_completed')
                            ->with('tags');

        $query = $query->where('type', 'user');

        $query = $query->whereIn('institution_id', $institutionId);

        $query = $query->whereIn('school_year', $filters['yearGroupSelected']);

        $query = $query->wherehas('selfAssessment', function ($query) use ($filters) {

            //CRS
            if (count($filters['tagsCrsSelected']) > 0)
            {

                $query = $query->where(function (Builder $query) use ($filters) {
                    foreach ($filters['tagsCrsSelected'] as $key => $value)
                    {
                        $tmp = explode("-", $value);
                        $query->orwhere(function (Builder $query) use ($tmp) {
                            $query = $query->where('career_readiness_average', '>=', $tmp[0]);
                            $query = $query->where('career_readiness_average', '<', $tmp[1]);
                        });
                    }
                });

            }

            //the assessment Must have the same year as the user's school year
            $query->whereRaw('self_assessments.year = users.school_year');

            if (count($filters['tagsRoutesSelected']) > 0)
            {
                $query->withAllTags($filters['tagsRoutesSelected'], 'route');
            }

            if (count($filters['tagsSectorsSelected']) > 0)
            {
                $query->withAllTags($filters['tagsSectorsSelected'], 'sector');
            }

            if (count($filters['tagsSubjectsSelected']) > 0)
            {
                $query->withAllSelectedSubjectTags($filters['tagsSubjectsSelected'], 'subject');
            }

        });

        if ($filters['cvCompleted'] != 0)
        {
            $query = $query->where('cv_builder_completed', $filters['cvCompleted']);
        }

        if ($filters['redFlag'] == 'Y')
        {
            $query = $query->where('nb_red_flag_articles_read', '>', 0);
        } elseif ($filters['redFlag'] == 'N') {
            $query = $query->where('nb_red_flag_articles_read',  0);
        }

        return $query;

    }

}