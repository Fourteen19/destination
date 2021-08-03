<?php

namespace App\Http\Livewire\Admin;

use Ramsey\Uuid\Uuid;
use Livewire\Component;
use App\Models\EventLive;
use App\Models\Institution;
use App\Models\VacancyLive;
use Illuminate\Support\Str;
use App\Exports\EventsExport;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Database\Eloquent\Builder;

class ReportingEvents extends Component
{

    public $institutionsList;
    public $institution;
    public $institutionName;
    public $level;
    public $resultsPreview = 0;
    public $resultsPreviewMessage = "";
    public $message = "";
    public $reportType = "";
    public $displayExportButtons = False;

    public function mount()
    {
        $this->reportType = "events-views";

        $this->getInstitutionsList();


        $institutionId = -1;
        $clientId = 1;
        $data = EventLive::select('id', 'title', 'client_id', 'all_clients')
                    ->where('all_clients', 'Y')
                    ->orWhere(function (Builder $query)  use ($institutionId, $clientId) {
                        $query->where('all_clients', 'N');
                        $query->where('institution_specific', 'Y');
                        $query->where('client_id', $clientId );

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
                    ->with('eventTotalStats', function ($query) use ($institutionId){
                        $query->where('year_id', app('currentYear'));
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
                        $query->select('id', 'name');
                    });

    $ee = $data->get();

/*                     foreach($ee as $e)
                    {
                        if ($e->client)
                        {
                            print $e->client->name;

                            if ($e->institutions)
                            {
                                print $e->institutions->pluck('name')->implode(', ');
                            } else {
                                print NULL;
                            }


                        } else {
                            print NULL;
                        }

                    }

                    dd($ee); */



    }



    /**
     * getInstitutionsList
     * Loads institutions in dropdown filter
     *
     * @return void
     */
    public function getInstitutionsList()
    {

        $this->level = getAdminLevel(Auth::guard('admin')->user());

        if ( ($this->level == 3) || ($this->level == 2) )
        {

            //finds the institutions filtering by client
            $this->institutionsList = Institution::select('uuid', 'name')->where('client_id', '=', session()->get('adminClientSelectorSelected'))->orderBy('name')->get();

        } else {

            $this->institutionsList = Auth::guard('admin')->user()->institutions();

        }



        /* $data = EventLive::query()->where('all_clients', 'Y')
                                    ->orWhere(function (Builder $query) {
                                        $query->where('all_clients', 'N');
                                        $query->wherehas('clients', function (Builder $query) {
                                            $query->where('client_id', session()->get('adminClientSelectorSelected'));
                                        });
                                    })
                                    ->with('vacancyTotalStats', function ($query) {
                                        $query->where('year_id', app('currentYear'));

                                    })
                                    ->get(); */

        //dd($data);
/*         foreach($data as $stat)
        {
            $total = 0;
            if ($stat->vacancyTotalStats->first())
            {
                foreach($stat->vacancyTotalStats as $stat_elt)
                {

                    $total += $stat_elt->total;
                }print $total;

            }

        } */


       // dd($total);

    }




    /**
     * adminHasPermissionToAccessInstitution
     * checks if admin has access to institution
     *
     * @param  mixed $institutionId
     * @return void
     */
    public function adminHasPermissionToAccessInstitution($institutionId)
    {

        return Auth::guard('admin')->user()->adminCanAccessInstitution($institutionId);

    }



    public function updated($propertyName)
    {

        if ($propertyName == "institution"){


            if ( ($this->institution == 'all') || ($this->institution == 'public') )
            {
                $this->resultsPreview = 0;
                $this->resultsPreviewMessage = "";
                $this->message = "";
                $this->displayExportButtons = True;

            } elseif ( Uuid::isValid( $this->institution )) {

                $this->resultsPreview = 0;
                $this->resultsPreviewMessage = "";
                $this->message = "";
                $this->displayExportButtons = True;

            } else {

                $this->displayExportButtons = False;

            }

        }

    }



    public function checkResults()
    {

        sleep(1);

        $this->resultsPreview = 0;

        $access = False;
        $institutionId = False;

        if ( ($this->institution == 'all') || ($this->institution == 'public') )
        {

            $access = True;

        } elseif ( Uuid::isValid( $this->institution )) {

            $institution = Institution::select('id')->where('uuid', $this->institution)->get();

            if (count($institution) == 1)
            {

                $institutionId = $institution->first()->id;

                //checks the admin has access to the institution
                if ($this->adminHasPermissionToAccessInstitution($institutionId))
                {

                    $access = True;

                }

            }

        }



        if ($access == True)
        {

            //selects events allocated to all clients AND the ones allocated specifically to the related client && related institutions
            $data = EventLive::where('all_clients', 'Y')
                    ->orWhere(function (Builder $query) use ($institutionId) {
                        $query->where('all_clients', 'N');
                        $query->where('institution_specific', 'Y');
                        $query->where('client_id', session()->get('adminClientSelectorSelected') );

                        if ($institutionId)
                        {
                            $query = $query->wherehas('institutions', function (Builder $query) use ($institutionId) {
                                                    $query->where('institution_id', $institutionId);
                                            });
                        }


                    });



            $this->resultsPreview = $data->count();

        }

        $this->updatePreviewMessage($this->resultsPreview);

    }


    public function resetMessage()
    {
        $this->message = "Your report could not be generated";
    }


    public function noRecordsMessage()
    {
        $this->message = "Your report has not be generated as there are no matching records";
    }


    public function reportGeneratedMessage()
    {
        $this->message = "Your \"".$this->institutionName."\" report will now be generated and emailed to you when ready";
    }

    public function updatePreviewMessage($nbMatches)
    {
        $this->resultsPreviewMessage = "There are ".$nbMatches." matching records";
    }



    public function generate()
    {

        //check matching records
        $this->checkResults();

        if ($this->institution == 'all')
        {

            $institutionId = -1;
            $filename = 'events_all_institutions_and_public_'.date("dmyHis").'.csv';
            $this->institutionName = "All Events and Public Access";

        } elseif ($this->institution == 'public') {

            $institutionId = -2;
            $filename = 'events_public_'.date("dmyHis").'.csv';
            $this->institutionName = "Public Access";

        } elseif ($this->resultsPreview > 0) {

            //selects the institution seleted in dropdown
            $institution = Institution::select('id', 'name')
                                            ->where('client_id', '=', session()->get('adminClientSelectorSelected'))
                                            ->where('uuid', '=', $this->institution)
                                            ->orderBy('name')
                                            ->get();

            //reset the message
            $this->resetMessage();

            //if an institution has been found
            if (count($institution) == 1)
            {

                $institution = $institution->first();

                //checks the admin has permission to access the institution selected
                if ($this->adminHasPermissionToAccessInstitution($institution->id))
                {

                    $this->institutionName = $institution->name;
                    $filename = 'events_'.Str::slug($this->institutionName).'_'.date("dmyHis").'.csv';

                    $institutionId = $institution->id;

                }

            }

        }


        if ( ($this->resultsPreview > 0) || ($this->institution == 'all')  || ($this->institution == 'public')  )
        {

            if ($this->reportType == "events-views")
            {

                //runs the export
                (new EventsExport( session()->get('adminClientSelectorSelected'), $institutionId))->queue($filename, 'exports')->chain([
                    new NotifyUserOfCompletedExport(request()->user(), $filename),
                ]);

            }

            $this->reportGeneratedMessage();

        } else {

            $this->noRecordsMessage();

        }

    }



    public function render()
    {
        return view('livewire.admin.reporting-events');
    }
}
