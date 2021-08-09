<?php

namespace App\Http\Livewire\Admin;

use Ramsey\Uuid\Uuid;
use Livewire\Component;
use App\Models\Institution;
use App\Models\VacancyLive;
use Illuminate\Support\Str;
use App\Exports\VacanciesExport;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Database\Eloquent\Builder;

class ReportingVacancies extends Component
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
        $this->reportType = "vacancies-views";

        $this->getInstitutionsList();

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

        if ( ($this->institution == 'all') || ($this->institution == 'public') )
        {

            $access = True;

        } elseif ( Uuid::isValid( $this->institution )) {

            $institution = Institution::select('id')->where('uuid', $this->institution)->get();

            if (count($institution) == 1)
            {

                $id = $institution->first()->id;

                //checks the admin has access to the institution
                if ($this->adminHasPermissionToAccessInstitution($id))
                {

                    $access = True;

                }

            }

        }



        if ($access == True)
        {

            //selects vacancies allocated to all clients AND the ones allocated specifically to the related client
            $data = VacancyLive::query()->where('all_clients', 'Y')
                                        ->orWhere(function (Builder $query) {
                                            $query->where('all_clients', 'N');
                                            $query->wherehas('clients', function (Builder $query) {
                                                $query->where('client_id', session()->get('adminClientSelectorSelected'));
                                            });
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
            $filename = 'vacancies_all_institutions_and_public_'.date("dmyHis").'.csv';
            $this->institutionName = "All Institutions and Public Access";

        } elseif ($this->institution == 'public') {

            $institutionId = -2;
            $filename = 'vacancies_public_'.date("dmyHis").'.csv';
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
                    $filename = 'vacancies_'.Str::slug($this->institutionName).'_'.date("dmyHis").'.csv';

                    $institutionId = $institution->id;

                }

            }

        }


        if ( ($this->resultsPreview > 0) || ($this->institution == 'all')  || ($this->institution == 'public')  )
        {

            if ($this->reportType == "vacancies-views")
            {

                //runs the export
                (new VacanciesExport( session()->get('adminClientSelectorSelected'), $institutionId))->queue($filename, 'exports')->chain([
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
        return view('livewire.admin.reporting-vacancies');
    }
}
