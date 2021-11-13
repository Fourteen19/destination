<?php

namespace App\Exports;

use App\Models\SystemTag;
use App\Models\Institution;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubjectAllInstitutionsExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

    protected $clientId;

    public function __construct(int $clientId)
    {

        $this->clientId = $clientId;

        $this->tags = SystemTag::withType('subject')->get()->sortby('name')->pluck('name', 'id');

    }



    /**
     * @return array
     */
    public function headings(): array
    {

        $titles = [];
        foreach($this->tags as $tag)
        {
            $titles[] = $tag . '(Number of users in year group - Like it)';
/*             $titles[] = $tag . '(Number of users in year group - I don\'t mind it)';
            $titles[] = $tag . '(Number of users in year group - It\'s not for me)';
            $titles[] = $tag . '(Number of users in year group - Not applicable)'; */
        }
        foreach($this->tags as $tag)
        {
            $titles[] = $tag . '(Percentage of year group - Like it)';
/*             $titles[] = $tag . '(Percentage of year group - I don\'t mind it)';
            $titles[] = $tag . '(Percentage of year group - It\'s not for me)';
            $titles[] = $tag . '(Percentage of year group - Not applicable)'; */
        }

        return array_merge([
            'Institution',
            'Year',
            'Number of completed self assessments',
            'Number in year group',
            'Percentage of completed',
            ],
            $titles
        );

    }



    /**
    * @var Institution $institution
    */
    public function map($institution): array
    {

        $startYear = 7;
        $endYear = 14;

        for ($i=$startYear;$i<=$endYear;$i++)
        {
            //adds the year
            $data[$i] = [$institution->name, $i];

            //Number of completed self assessments
            $nbCompletedAssessment = app('reportingService')->countNumberOfCompletedSelfAssessment($this->clientId, $institution->id, $i);
            array_push($data[$i], ($nbCompletedAssessment == 0) ? "0" : $nbCompletedAssessment);

//////

            $nbUsers = app('reportingService')->countNumberOfUsersInYearGroup($this->clientId, $institution->id, $i);
            array_push($data[$i], ($nbUsers == 0) ? "0" : $nbUsers);

            //Percentage of completed assessments
            $percentageCompleted = app('reportingService')->calculatePercentageOfCompletedAssessment($nbUsers, $nbCompletedAssessment);

            array_push($data[$i], $percentageCompleted);

//////

            $timesTagSelected = [];
            foreach($this->tags as $key => $tag)
            {
                //for ($score=1;$score<=4;$score++)
                for ($score=1;$score<=1;$score++) // only display the "I like it" stats
                {
                    $timesTagSelected[$key]['assessment_score'][$score] = $nbTimesSelected = app('reportingService')->countNbTimesSubjectTagAnswerIsSelected($this->clientId, $institution->id, $nbCompletedAssessment, $i, $key, $score);
                    array_push($data[$i], $nbTimesSelected);
                }
            }


            foreach($this->tags as $key => $tag)
            {

                //for ($score=1;$score<=4;$score++)
                for ($score=1;$score<=1;$score++) // only display the "I like it" stats
                {

                    if ($nbCompletedAssessment == 0)
                    {

                        $percentageSelected = "N/A";

                    } else {

                        $percentageSelected = round(($timesTagSelected[$key]['assessment_score'][$score] * 100) / $nbCompletedAssessment, 2) . "%";

                    }

                    array_push($data[$i], $percentageSelected);

                }

            }

        }



        return [
            $data[7],
            $data[8],
            $data[9],
            $data[10],
            $data[11],
            $data[12],
            $data[13],
            $data[14],
        ];

    }



    public function query()
    {

        $clientId = $this->clientId;

        return Institution::query()->select('id', 'name')->where('client_id', $clientId)->orderBy('name');

    }


}
