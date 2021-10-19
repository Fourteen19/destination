<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Livewire\Component;
use App\Models\Institution;
use Illuminate\Support\Str;
use App\Exports\RouteExport;
use App\Exports\SectorExport;
use App\Exports\SubjectExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\CareerReadinessExport;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Exports\RouteAllInstitutionsExport;
use App\Exports\SectorAllInstitutionsExport;
use App\Exports\SubjectAllInstitutionsExport;
use App\Exports\CareerReadinessAllInstitutionsExport;

class ReportingSystemTags extends Component
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

    public function mount($reportType)
    {

        $this->reportType = $reportType;

        $this->getInstitutionsList();

    }



    public function getInstitutionsList()
    {

        $this->level = getAdminLevel(Auth::guard('admin')->user());

        if ( ($this->level == 3) || ($this->level == 2) )
        {

            //finds the institutions filtering by client
            $this->institutionsList = Institution::select('uuid', 'name')->where('client_id', '=', session()->get('adminClientSelectorSelected'))->orderBy('name')->get();

        } else {

            $this->institutionsList = Auth::guard('admin')->user()->institutions()->select('uuid', 'name')->get();

        }

    }




    public function adminHasPermissionToAccessInstitution($institutionId)
    {

        return Auth::guard('admin')->user()->adminCanAccessInstitution($institutionId);

    }




    public function checkResults()
    {

        sleep(1);

        $this->resultsPreview = 0;

        $access = False;

        if ($this->institution == 'all_institutions')
        {

            $access = True;
            $institutionId = NULL;

        } elseif ( Uuid::isValid( $this->institution )) {

            $institution = Institution::select('id')->where('uuid', $this->institution)->get();

            $this->resultsPreview = 0;

            if (count($institution) == 1)
            {

                $institutionId = $institution->first()->id;

                if ($this->adminHasPermissionToAccessInstitution($institutionId))
                {

                    $access = True;

                }

            }

        }


        if ($access == True)
        {

            if ($this->reportType == "career-readiness")
            {

                $this->resultsPreview = User::query()->where('type', 'user')
                                                    ->where('client_id', session()->get('adminClientSelectorSelected'))
                                                    ->when($institutionId, function ($q) use ($institutionId) {
                                                        return $q->where('institution_id', $institutionId);
                                                    })
                                                    ->count();

            } elseif ($this->reportType == "sector") {

                $this->resultsPreview = User::query()->where('type', 'user')
                                                    ->where('client_id', session()->get('adminClientSelectorSelected'))
                                                    ->when($institutionId, function ($q) use ($institutionId) {
                                                        return $q->where('institution_id', $institutionId);
                                                    })
                                                    ->count();

            } elseif ($this->reportType == "subject") {

                $this->resultsPreview = User::query()->where('type', 'user')
                                                    ->where('client_id', session()->get('adminClientSelectorSelected'))
                                                    ->when($institutionId, function ($q) use ($institutionId) {
                                                        return $q->where('institution_id', $institutionId);
                                                    })
                                                    ->count();

            } elseif ($this->reportType == "route") {

                $this->resultsPreview = User::query()->where('type', 'user')
                                                    ->where('client_id', session()->get('adminClientSelectorSelected'))
                                                    ->when($institutionId, function ($q) use ($institutionId) {
                                                        return $q->where('institution_id', $institutionId);
                                                    })
                                                    ->count();

            }

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




    public function updated($propertyName)
    {

        if ($propertyName == "institution"){

            if ($this->institution == 'all_institutions')
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



    public function generate()
    {


        //check matching records
        $this->checkResults();

        if ($this->resultsPreview > 0)
        {

            if ($this->institution == 'all_institutions') {

                $institutionId = NULL;
                $this->institutionName = "All Institutions";

            } else {

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
                        $institutionId = $institution->id;

                    }

                }

            }

        }


        if ( ($this->resultsPreview > 0) || ($this->institution == 'all_institutions') )
        {

            if ($this->reportType == "career-readiness")
            {

                $filename = 'career-readiness_'.Str::slug($this->institutionName).'_'.date("dmyHis").'.csv';

                if ($this->institution == 'all_institutions')
                {

                    //runs the export
                    (new CareerReadinessAllInstitutionsExport( session()->get('adminClientSelectorSelected')))->queue($filename, 'exports')->chain([
                        new NotifyUserOfCompletedExport(request()->user(), $filename),
                    ]);

                } else {

                    //runs the export
                    (new CareerReadinessExport( session()->get('adminClientSelectorSelected'), $institutionId))->queue($filename, 'exports')->chain([
                        new NotifyUserOfCompletedExport(request()->user(), $filename),
                    ]);

                }

            } elseif ($this->reportType == "sector") {

                $filename = 'sector-data_'.Str::slug($this->institutionName).'_'.date("dmyHis").'.csv';

                if ($this->institution == 'all_institutions')
                {

                    //runs the export
                    (new SectorAllInstitutionsExport( session()->get('adminClientSelectorSelected')))->queue($filename, 'exports')->chain([
                        new NotifyUserOfCompletedExport(request()->user(), $filename),
                    ]);

                } else {

                    //runs the export
                    (new SectorExport( session()->get('adminClientSelectorSelected'), $institutionId))->queue($filename, 'exports')->chain([
                        new NotifyUserOfCompletedExport(request()->user(), $filename),
                    ]);

                }

            } elseif ($this->reportType == "subject") {

                $filename = 'subject-data_'.Str::slug($this->institutionName).'_'.date("dmyHis").'.csv';

                if ($this->institution == 'all_institutions')
                {

                    //runs the export
                    (new SubjectAllInstitutionsExport( session()->get('adminClientSelectorSelected')))->queue($filename, 'exports')->chain([
                        new NotifyUserOfCompletedExport(request()->user(), $filename),
                    ]);

                } else {

                    //runs the export
                    (new SubjectExport( session()->get('adminClientSelectorSelected'), $institutionId))->queue($filename, 'exports')->chain([
                            new NotifyUserOfCompletedExport(request()->user(), $filename),
                    ]);

                }

            } elseif ($this->reportType == "route") {

                $filename = 'route-data_'.Str::slug($this->institutionName).'_'.date("dmyHis").'.csv';

                if ($this->institution == 'all_institutions')
                {

                    //runs the export
                    (new RouteAllInstitutionsExport( session()->get('adminClientSelectorSelected')))->queue($filename, 'exports')->chain([
                        new NotifyUserOfCompletedExport(request()->user(), $filename),
                    ]);

                } else {

                    //runs the export
                    (new RouteExport( session()->get('adminClientSelectorSelected'), $institutionId))->queue($filename, 'exports')->chain([
                        new NotifyUserOfCompletedExport(request()->user(), $filename),
                    ]);

                }

            }

            $this->reportGeneratedMessage();

        } else {

            $this->noRecordsMessage();

        }

    }



    public function render()
    {
        $this->getInstitutionsList();

        return view('livewire.admin.reporting-system-tags');
    }
}
