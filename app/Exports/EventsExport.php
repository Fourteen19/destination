<?php

namespace App\Exports;

use App\Models\EventLive;
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

    public function __construct(int $clientId, int $institutionId, int $year)
    {

        $this->clientId = $clientId;
        $this->institutionId = $institutionId;
        $this->year = $year;

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
            'Event Title',
            'Owner',
            'Total views',
        ];

    }


    /**
    * @var Events $event
    */
    public function map($event): array
    {

        $total = 0;
        foreach($event->eventTotalStats as $ev)
        {
            $total += $ev->total;
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



        return [
            $event->title,
            $owner,
            ($total == 0) ? "0" : $total,
        ];

    }


    public function query()
    {

        $institutionId = $this->institutionId;
        $clientId = $this->clientId;
        $year = $this->year;

        return EventLive::select('id', 'title', 'client_id', 'all_clients')
                        ->current()
                        ->where('all_clients', 'Y')
                        ->orWhere(function (Builder $query)  use ($institutionId, $clientId) {
                            $query->where('all_clients', 'N');
                            $query->where('institution_specific', 'Y');
                            $query->where('client_id', $clientId );
                            $query->current();
                            //if all institutions and public access
                            if ($institutionId == -1)
                            {
                                //do nothing, and select all

                            //if Public Access only
                            } elseif ($institutionId == -2) {


                            //if a specific institution
                            } else {

                                $query->wherehas('institutions', function (Builder $query) use ($institutionId) {
                                            $query->where('institution_id', $institutionId);
                                        });

                            }

                        })
                        ->with('eventTotalStats', function ($query) use ($institutionId, $year){
                            $query->where('year_id', $year);
                            $query->select('event_id', 'total');

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
                        ->with('client', function ($query)  {
                            $query->select('id', 'name');
                        })
                        ->with('institutions', function ($query)  {
                            $query->select('id', 'name')->orderBy('name', 'asc');
                        })
                        ->orderBy('title', 'asc');

    }

}
