<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventsExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
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
            'Event Title',
            'Owner',
            'Total views',
            'Status',
        ];

    }


    /**
    * @var Events $event
    */
    public function map($event): array
    {

        $total = 0;

        //if the relationship is not null
        if ($event->eventTotalStats)
        {
            //if these are any items in the relationship
            if (count($event->eventTotalStats) > 0)
            {
                //loop items
                foreach($event->eventTotalStats as $stat)
                {
                    $total += $stat->total;
                }
            }
        }



        $owner = "";
        if ($event->client)
        {

            $owner .= $event->client->name . " / ";

            if ($event->institutions)
            {
                $owner .= $event->institutions->pluck('name')->implode(', ');
            }

        } else {
            $owner = "ALL Clients / All institutions";
        }


        $eventStatus = "";
        if ($event->live == null)
        {
            $eventStatus = "not live";

            if (Carbon::parse($event->date)->format('Ymd') < Carbon::today()->format('Ymd') )
            {
                $eventStatus = "passed";
            }

        } else {

            if ($event->live->deleted_at != null)
            {
                $eventStatus = "not live";
            } else {
                $eventStatus = "live";
            }

            if ($event->date != NULL)
            {
                if (Carbon::parse($event->date)->format('Ymd') < Carbon::today()->format('Ymd') )
                {
                    $eventStatus = "passed";
                }
            }

        }

        return [
            $event->title,
            $owner,
            ($total == 0) ? "0" : $total,
            $eventStatus,
        ];

    }


    public function query()
    {

        $institutionId = $this->institutionId;
        $clientId = $this->clientId;
        $year = $this->year;
        $adminUserId = $this->adminUserId;

        return Event::select('id', 'title', 'date', 'client_id', 'all_clients')
                        //->whereDate('date', '>=', Carbon::today()->toDateString())
                        ->where(function ($query) use ($institutionId, $clientId) {

                            $query->where('all_clients', 'Y');

                            $query->orWhere(function (Builder $query) use ($institutionId, $clientId) {
                                $query->where('all_clients', 'N');
                                $query->where('institution_specific', 'Y');
                                $query->where('client_id', $clientId );
                                //$query->current();
                                //if all institutions and public access
                                if ($institutionId == -1)
                                {
                                    //do nothing, and select all

                                //if Public Access only
                                } elseif ($institutionId == -2) {


                                //if All Institutions Access only
                                } elseif ($institutionId == -3) {

                                //if a specific institution
                                } else {

                                    $query->wherehas('institutions', function (Builder $query) use ($institutionId) {
                                        $query->where('institution_id', $institutionId);
                                    });

                                }

                            });

                            $query->orWhere(function (Builder $query) use ($clientId) {
                                $query->Where(function (Builder $query) {
                                    $query->where('all_clients', 'N');
                                    $query->where('institution_specific', 'N');
                                });
                                $query->where('client_id', $clientId );
                            });

                        })
                        ->with('live')
                        ->with('eventTotalStats', function ($query) use ($institutionId, $year, $adminUserId){
                            $query->where('year_id', $year);
                            $query->select('event_id', 'total');

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



                        })
                        ->with('client', function ($query)  {
                            $query->select('id', 'name');
                        })
                        ->with('institutions', function ($query)  {
                            $query->select('id', 'name')->orderBy('name', 'asc');
                        })
                        ->whereNull('deleted_at')
                        ->orderBy('title', 'asc');

    }

}
