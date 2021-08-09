<?php

namespace App\Exports;

use App\Models\VacancyLive;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VacanciesExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

    protected $clientId;
    protected $institutionId;

    public function __construct(int $clientId, int $institutionId)
    {

        $this->clientId = $clientId;
        $this->institutionId = $institutionId;

        //If All Institutions & Public access
        if ($this->institutionId == -1)
        {

        //If Only Public access
        } elseif ($this->institutionId == -2 ){


        }


    }


    /**
     * @return array
     */
    public function headings(): array
    {

        return [
            'Vacancy Title',
            'Employer',
            'Total views',
        ];

    }


    /**
    * @var Vacancies $vacancy
    */
    public function map($vacancy): array
    {

        $total = 0;

        //loops through the totals
        foreach($vacancy->vacancyTotalStats as $stat)
        {
            $total += $stat->total;
        }


        return [
            $vacancy->title,
            $vacancy->employer->name,
            ($total == 0) ? "0" : $total,
        ];

    }


    public function query()
    {

        $institutionId = $this->institutionId;
        $clientId = $this->clientId;

        return VacancyLive::query()->select('id', 'title', 'employer_id')
                                    ->where('all_clients', 'Y')
                                    ->orWhere(function (Builder $query) use ($clientId) {
                                        $query->where('all_clients', 'N');
                                        $query->wherehas('clients', function (Builder $query)  use ($clientId) {
                                            $query->where('client_id', $clientId );
                                        });
                                    })
                                    ->with('vacancyTotalStats', function ($query) use ($institutionId){
                                        $query->where('year_id', app('currentYear'));
                                        $query->select('vacancy_id', 'total');

                                        //if all institutions and public access
                                        if ($institutionId == -1)
                                        {
                                            //do nothing, and select all

                                        //if Public Access only
                                        } elseif ($institutionId == -2) {
                                            $query->where('institution_id', NULL);

                                        //if a specific institution
                                        } else {
                                            $query->where('institution_id', $institutionId);
                                        }
                                    })
                                    ->with('employer', function ($query) {
                                        $query->select('id', 'name');
                                    })
                                    ->orderBy('title', 'asc');
    }
}
