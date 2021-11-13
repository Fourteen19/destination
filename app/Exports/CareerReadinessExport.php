<?php

namespace App\Exports;

use App\Models\Institution;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CareerReadinessExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

    protected $clientId;
    protected $institutionId;

    public function __construct(int $clientId, int $institutionId)
    {

        $this->clientId = $clientId;
        $this->institutionId = $institutionId;

    }



    /**
     * @return array
     */
    public function headings(): array
    {

        return [
            'Year',
            'Number of completed self assessments',
            'Number in year group (on system)',
            'Percentage of completed',
            'CRS 1-2',
            'CRS 2-3',
            'CRS 3-4',
            'CRS 4-5',
            'I feel confident about my future (Strongly agree)',
            'I feel confident about my future (Agree)',
            'I feel confident about my future (Neither agree or disagree)',
            'I feel confident about my future (Disagree)',
            'I feel confident about my future (Strongly disagree)',
            'I understand all the different career options and choices (Strongly agree)',
            'I understand all the different career options and choices (Agree)',
            'I understand all the different career options and choices (Neither agree or disagree)',
            'I understand all the different career options and choices (Disagree)',
            'I understand all the different career options and choices (Strongly disagree)',
            'I make good decisions and choices (Strongly agree)',
            'I make good decisions and choices (Agree)',
            'I make good decisions and choices (Neither agree or disagree)',
            'I make good decisions and choices (Disagree)',
            'I make good decisions and choices (Strongly disagree)',
            'I know what I need to do to achieve my career goals (Strongly agree)',
            'I know what I need to do to achieve my career goals (Agree)',
            'I know what I need to do to achieve my career goals (Neither agree or disagree)',
            'I know what I need to do to achieve my career goals (Disagree)',
            'I know what I need to do to achieve my career goals (Strongly disagree)',
            'I am worried I won\'t be able to achieve my career goals (Strongly disagree)',
            'I am worried I won\'t be able to achieve my career goals (Disagree)',
            'I am worried I won\'t be able to achieve my career goals (Neither agree or disagree)',
            'I am worried I won\'t be able to achieve my career goals (agree)',
            'I am worried I won\'t be able to achieve my career goals (Strongly agree)',
        ];

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
            $data[$i] = [$i];

            //Number of completed self assessments
            $nbCompletedAssessment = app('reportingService')->countNumberOfCompletedSelfAssessment($this->clientId, $this->institutionId, $i);
            array_push($data[$i], ($nbCompletedAssessment == 0) ? "0" : $nbCompletedAssessment);

//////

            $nbUsers = app('reportingService')->countNumberOfUsersInYearGroup($this->clientId, $this->institutionId, $i);
            array_push($data[$i], ($nbUsers == 0) ? "0" : $nbUsers);

            //Percentage of completed assessments
            $percentageCompleted = app('reportingService')->calculatePercentageOfCompletedAssessment($nbUsers, $nbCompletedAssessment);

            array_push($data[$i], $percentageCompleted);

//////

            //loops to get the CRS counts and then calculate the %
            for ($j=2;$j<6;$j++)
            {

                if ($j == 2)
                {
                    $min = 0;
                } else {
                    $min = $j-1;
                }

                if ($j == 5)
                {
                    $max = 5;
                } else {
                    $max = $j - 0.01;
                }


                //Number of completed self assessments with a CRS < $j
                $result = DB::table('self_assessments')
                            ->select(DB::raw('COUNT(completed) AS nb_completed_assessment_crs'))
                            ->join('users', 'users.id', '=', 'self_assessments.user_id')
                            ->where('users.type', '=', 'user')
                            ->where('users.client_id', '=', $this->clientId)
                            ->where('users.institution_id', '=', $this->institutionId)
                            ->where('users.school_year', '=', $i)
                            ->where('self_assessments.year', '=', $i)
                            ->where('self_assessments.completed', '=', 'Y')
                            ->whereBetween('self_assessments.career_readiness_average', [$min, $max])
                            ->where('users.deleted_at', '=', NULL)
                            ->first();


                $nbCompletedAssessmentCrs = $result->nb_completed_assessment_crs;

                //Percentage of completed self assessments with a CRS < 2
                if ($nbCompletedAssessmentCrs > 0)
                {
                    $percentageCompletedAssessmentCrs = round( ($nbCompletedAssessmentCrs * 100) / $nbCompletedAssessment, 2) ."%";
                } else {

                    if ($nbCompletedAssessment > 0)
                    {
                        $percentageCompletedAssessmentCrs = "0%";
                    } else {
                        $percentageCompletedAssessmentCrs = "N/A";
                    }

                }
                array_push($data[$i], $percentageCompletedAssessmentCrs);

            }

//////

            //for each question
            for ($j=1;$j<=5;$j++)
            {

                $CrsQuestions['question_'.$j] = ['1' => 0,
                                                '2' => 0,
                                                '3' => 0,
                                                '4' => 0,
                                                '5' => 0,
                                                ];

                for ($k=1;$k<=5;$k++)
                {

                    //Number of answers for each CRS question
                    $result = DB::table('self_assessments')
                                    ->select(DB::raw('COUNT(career_readiness_score_'.$j.') AS answer'))
                                    ->join('users', 'users.id', '=', 'self_assessments.user_id')
                                    ->where('users.type', '=', 'user')
                                    ->where('users.client_id', '=', $this->clientId)
                                    ->where('users.institution_id', '=', $this->institutionId)
                                    ->where('users.school_year', '=', $i)
                                    ->where('self_assessments.year', '=', $i)
                                    ->where('self_assessments.completed', '=', 'Y')
                                    ->where('self_assessments.career_readiness_score_'.$j, '=', $k)
                                    ->where('users.deleted_at', '=', NULL)
                                    ->first();

                    $answer = $result->answer;

                    $CrsQuestions['question_'.$j][$k] = $answer;

                    if ($answer > 0)
                    {
                        $percentageAnswer = round( ($answer * 100) / $nbCompletedAssessment, 2) ."%";
                    } else {

                        if ($nbCompletedAssessment > 0)
                        {
                            $percentageAnswer = "0%";
                        } else {
                            $percentageAnswer = "N/A";
                        }

                    }
                    array_push($data[$i], $percentageAnswer);

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

        $institutionId = $this->institutionId;
        $clientId = $this->clientId;

        return Institution::query()->select('id')
                                    ->where('client_id', $clientId)
                                    ->when($institutionId, function ($q) use ($institutionId) {
                                        return $q->where('id', $institutionId);
                                    });

    }


}
