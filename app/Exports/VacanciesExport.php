<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Vacancy;
use App\Models\Admin\Admin;
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
    protected $year;
    protected $adminUserId;

    public function __construct(int $clientId, int $institutionId, int $year, int $adminUserId)
    {

        $this->clientId = $clientId;
        $this->institutionId = $institutionId;
        $this->year = $year;
        $this->adminUserId = $adminUserId;

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
            'Date created',
            'Closing date',
            'Role type',
            'Area',
            'Status',
        ];

    }


    /**
    * @var Vacancies $vacancy
    */
    public function map($vacancy): array
    {

        $total = 0;



        //if the relationship is not null
        if ($vacancy->vacancyTotalStats)
        {
            //if these are any items in the relationship
            if (count($vacancy->vacancyTotalStats) > 0)
            {
                //loop items
                foreach($vacancy->vacancyTotalStats as $stat)
                {
                    $total += $stat->total;
                }
            }
        }




        $vacancyStatus = "";
        if ($vacancy->live == null)
        {
            $vacancyStatus = "not live";

            if (Carbon::parse($vacancy->display_until)->format('Ymd') < Carbon::today()->format('Ymd') )
            {
                $vacancyStatus = "passed";
            }

        } else {

            if ($vacancy->live->deleted_at != null)
            {
                $vacancyStatus = "not live";
            } else {
                $vacancyStatus = "live";
            }

            if ($vacancy->display_until != NULL)
            {
                if (Carbon::parse($vacancy->display_until)->format('Ymd') < Carbon::today()->format('Ymd') )
                {
                    $vacancyStatus = "passed";
                }
            }

        }




        return [
            $vacancy->title,
            $vacancy->employer->name,
            ($total == 0) ? "0" : $total,
            Carbon::parse($vacancy->created_at)->format('d/m/Y'),
            (!empty($vacancy->display_until)) ? Carbon::parse($vacancy->display_until)->format('d/m/Y') : '',
            $vacancy->role->name,
            $vacancy->region->name,
            $vacancyStatus,
        ];

    }


    public function query()
    {

        $institutionId = $this->institutionId;
        $clientId = $this->clientId;
        $year = $this->year;
        $adminUserId = $this->adminUserId;

        return Vacancy::select('id', 'title', 'employer_id', 'created_at', 'display_until', 'role_id', 'region_id')
                                    ->where('all_clients', 'Y')
                                    ->orWhere(function ($query) use ($clientId) {
                                        $query->where('all_clients', 'N');
                                        $query->wherehas('clients', function ($query)  use ($clientId) {
                                            $query->where('client_id', $clientId );
                                        });
                                    })
                                    //->current()
                                    //->with('live')
                                    ->with('vacancyTotalStats', function ($query) use ($institutionId, $year, $adminUserId){
                                        $query->where('year_id', $year);
                                        $query->select('vacancy_id', 'total');

                                        //if all institutions and public access
                                        if ($institutionId == -1)
                                        {
                                            //Need to filter to get only visible institution depending on user type
                                            $admin = Admin::find($adminUserId);

                                            //checks the admin level
                                            if (getAdminLevel($admin) < 2)
                                            {
                                                $institutions = $admin->getAdminInstitutionsIds();

                                                if (count($institutions) > 0)
                                                {
                                                    $query->where(function($query1) use ($institutions) {
                                                        $query1->wherein('institution_id', $institutions );
                                                        $query1->orwhereNULL('institution_id');
                                                    });

                                                } else {
                                                    $query->wherein('institution_id', $institutions );
                                                }

                                            }

                                        //if Public Access only
                                        } elseif ($institutionId == -2) {
                                            $query->whereNULL('institution_id');

                                        //if All institutions Access only
                                        } elseif ($institutionId == -3) {

                                            //Need to filter to get only visible institution depending on user type
                                            $admin = Admin::find($adminUserId);

                                            //checks the admin level
                                            if (getAdminLevel($admin) < 2)
                                            {
                                                $institutions = $admin->getAdminInstitutionsIds();

                                                if (count($institutions) > 0)
                                                {
                                                    $query->wherein('institution_id', $institutions);
                                                }

                                            } else {
                                                $query->where('institution_id', '!=', NULL);
                                            }

                                        //if a specific institution
                                        } else {
                                            $query->where('institution_id', $institutionId);
                                        }
                                        $query->get();

                                    })
                                    ->with('employer', function ($query) {
                                        $query->select('id', 'name');
                                    })
                                    ->with('role', function ($query) {
                                        $query->select('id', 'name');
                                    })
                                    ->with('region', function ($query) {
                                        $query->select('id', 'name');
                                    })
                                    ->orderBy('title', 'asc');
    }

}
