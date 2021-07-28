<?php

namespace App\Exports;

use App\Models\Vacancy;
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

        //counts the number of articles using the tag
        //$nbArticles = ContentLive::withAnyTags([$tag->name], 'keyword')->count();

        return [
            $vacancy->title,
            $vacancy->employer->name,
            2,
        ];
    }


    public function query()
    {
        return Vacancy::query()->where('institution_id', )->orderBy('title', 'asc');
    }
}
