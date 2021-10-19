<?php

namespace App\Exports;

use App\Models\SystemTag;
use App\Models\Institution;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SectorAllInstitutionsExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

    protected $clientId;
    protected $institutionId;

    public function __construct(int $clientId, int $institutionId)
    {

        $this->clientId = $clientId;
        $this->institutionId = $institutionId;

        $this->tags = SystemTag::withType('sector')->get()->sortby('name')->pluck('name', 'id');

    }



    /**
     * @return array
     */
    public function headings(): array
    {

        $titles = [];
        foreach($this->tags as $tag)
        {
            $titles[] = $tag . '(Number of users in year group)';
        }
        foreach($this->tags as $tag)
        {
            $titles[] = $tag . '(Percentage of year group)';
        }

        return array_merge([
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

            $timesTagSelected = [];
            foreach($this->tags as $key => $tag)
            {
                $timesTagSelected[$key] = $nbTimesSelected = app('reportingService')->countNbTimesTagIsSelected($this->clientId, $this->institutionId, $nbCompletedAssessment, $i, $key);
                array_push($data[$i], $nbTimesSelected);
            }


            foreach($this->tags as $key => $tag)
            {

                if ($nbCompletedAssessment == 0)
                {

                    $percentageSelected = "N/A";

                } else {

                    $percentageSelected = round(($timesTagSelected[$key] * 100) / $nbCompletedAssessment, 2) . "%";

                }

                array_push($data[$i], $percentageSelected);
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

        return Institution::query()->select('id')->where('id', $this->institutionId);

    }


}
