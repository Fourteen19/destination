<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Livewire\Component;
use App\Models\Institution;
use Illuminate\Support\Str;
use App\Exports\KeywordsExport;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyUserOfCompletedExport;

class ReportingKeywords extends Component
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

    //$reportType
    public function mount()
    {
        $this->reportType = "keywords";

        $this->getInstitutionsList();




/*       $e = SystemKeywordTag::query()->where('type', 'keyword')
                                        ->where('client_id', 1)
                                        ->where('live', 'Y')
                                        ->where('id', 94)
                                        ->with('keywordsTagsTotalStats', function ($query) {

                                            $query->select('tag_id', 'total', 'year_7', 'year_8', 'year_9', 'year_10', 'year_11', 'year_12', 'year_13', 'year_14')
                                                ->where('year_id', 1)
                                                ->where('institution_id', 1);

                                        })
                                        ->limit(3)
                                        ->orderBy('name', 'asc')->get();

dd($e); */

    }



    public function getInstitutionsList()
    {

        $this->level = getAdminLevel(Auth::guard('admin')->user());

        if ( ($this->level == 3) || ($this->level == 2) )
        {

            //finds the institutions filtering by client
            $this->institutionsList = Institution::select('uuid', 'name')->where('client_id', '=', session()->get('adminClientSelectorSelected'))->orderBy('name')->get();

        } else {

            $this->institutionsList = Auth::guard('admin')->user()->institutions()->get();

        }

    }




    public function adminHasPermissionToAccessInstitution($institutionId)
    {

        return Auth::guard('admin')->user()->adminCanAccessInstitution($institutionId);

    }



    public function updated($propertyName)
    {

        if ($propertyName == "institution"){

            if ( Uuid::isValid( $this->institution ))
            {
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

        $institution = Institution::select('id')->where('uuid', $this->institution)->get();

        $this->resultsPreview = 0;

        if (count($institution) == 1)
        {

            $id = $institution->first()->id;

            if ($this->adminHasPermissionToAccessInstitution($id))
            {
                //->where('client_id', session()->get('adminClientSelectorSelected'))
                $this->resultsPreview = SystemKeywordTag::where('type', 'keyword')
                                                          ->where('live', 'Y')
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


    public function generate()
    {
        //check matching records
        $this->checkResults();

        if ($this->resultsPreview > 0)
        {

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
                    $filename = 'keywords_'.Str::slug($this->institutionName).'_'.date("dmyHis").'.csv';

                    if ($this->reportType == "keywords")
                    {

                        //runs the export
                        (new KeywordsExport( session()->get('adminClientSelectorSelected'), $institution->id, app('currentYear')))->queue($filename, 'exports')->chain([
                            new NotifyUserOfCompletedExport(request()->user(), $filename, session()->get('adminClientSelectorSelected')),
                        ]);

                    }

                    $this->reportGeneratedMessage();
                }

            }

        } else {

            $this->noRecordsMessage();

        }

    }



    public function render()
    {
        return view('livewire.admin.reporting-users');
    }
}
