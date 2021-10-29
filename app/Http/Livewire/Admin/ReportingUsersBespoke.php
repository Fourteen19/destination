<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Livewire\Component;
use App\Models\SystemTag;
use App\Models\Institution;
use Illuminate\Support\Str;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Auth;
use App\Exports\UsersNotLoggedInExport;
use App\Jobs\NotifyUserOfCompletedExport;

class ReportingUsersBespoke extends Component
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
    public $tagsSubjects, $tagsYearGroups, $tagsLscs, $tagsRoutes, $tagsSectors, $tagsNeet;
    public $yesNoOptions = ['0' => 'N/A', 'Y' => 'Yes', 'N' => 'No'];
    public $tagsYearGroupsSelected = [];
    public $tagsLscsSelected = [];
    public $tagsSubjectsSelected = [];
    public $tagsRoutesSelected = [];
    public $tagsSectorsSelected = [];
    public $tagsNeetSelected = [];
    public $cvCompleted = 0;
    public $redFlag = 0;
    public $allYears= 1;
    public $allCrsYears = 1;

    public function mount($reportType)
    {
        $this->reportType = $reportType;

        $this->getInstitutionsList();



        $this->tagsYearGroups = SystemTag::select('uuid', 'name')->where('type', 'year')->get()->toArray();
        foreach($this->tagsYearGroups as $key => $value){
            $this->tagsYearGroupsSelected[] = $value['name'][ app()->getLocale() ];
        }


        $this->tagsLscs = SystemTag::select('uuid', 'name')->where('type', 'career_readiness')->where('live', 'Y')->get()->toArray();
        foreach($this->tagsLscs as $key => $value){
            $this->tagsLscsSelected[] = $value['name'][ app()->getLocale() ];
        }

        $this->tagsRoutes = SystemTag::select('uuid', 'name')->where('type', 'route')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $this->tagsSectors = SystemTag::select('uuid', 'name')->where('type', 'sector')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $this->tagsSubjects = SystemTag::select('uuid', 'name')->where('type', 'subject')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();


        $this->tagsNeet = SystemTag::select('uuid', 'name')->where('type', 'neet')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();

    }



    /**
     * AllYearsOn
     * when the "all years" checkbox is selected
     *
     * @return void
     */
    public function AllYearsOn()
    {
        $this->tagsYearGroups = SystemTag::select('uuid', 'name')->where('type', 'year')->get()->toArray();

        $this->tagsYearGroupsSelected = [];
        foreach($this->tagsYearGroups as $key => $value){
            $this->tagsYearGroupsSelected[] = $value['name']['en'];
        }

    }



    public function AllCrsYearsOn()
    {
        $this->tagsLscs = SystemTag::select('uuid', 'name')->where('type', 'career_readiness')->where('live', 'Y')->get()->toArray();

        $this->tagsLscsSelected = [];
        foreach($this->tagsLscs as $key => $value){
            $this->tagsLscsSelected[] = $value['name']['en'];
        }

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

        } elseif ($propertyName == "allYears"){

            if ($this->allYears == 1){
                $this->AllYearsOn();
            }

        } elseif ($propertyName == "allCrsYears"){

            if ($this->allCrsYears == 1){
                $this->AllCrsYearsOn();
            }


           // dd($this->tagsSubjectsSelected);

        }

    }




    public function getBespokeFilters()
    {

        return [
            'allYearGroup' => $this->allYears,
            'yearGroupSelected' => $this->tagsYearGroupsSelected,
            'allCrsYears' => $this->allCrsYears,
            'tagsCrsSelected' => $this->tagsLscsSelected,
            'tagsSubjectsSelected' => $this->tagsSubjectsSelected,
            'tagsRoutesSelected' => $this->tagsRoutesSelected,
            'tagsSectorsSelected' => $this->tagsSectorsSelected,
            'cvCompleted' => $this->cvCompleted,
            'redFlag' => $this->redFlag,
        ];
    }




    public function checkResults()
    {

        sleep(1);

        $institution = Institution::select('id')->where('uuid', $this->institution)->get();

        $this->resultsPreview = 0;

        if (count($institution) == 1)
        {

            $institutionId = $institution->first()->id;

            if ($this->adminHasPermissionToAccessInstitution($institutionId))
            {

                if ($this->reportType == "user-data")
                {

                    $filters = $this->getBespokeFilters();
//dd($filters);
/*
array:9 [▼
  "allYearGroup" => 1
  "yearGroupSelected" => array:8 [▶]
  "allCrsYears" => 1
  "tagsCrsSelected" => array:4 [▶]
  "tagsSubjectsSelected" => []
  "tagsRoutesSelected" => []
  "tagsSectorsSelected" => []
  "cvCompleted" => 0
  "redFlag" => 0
]
*/
//dd($filters['tagsRoutesSelected']);
                    $query = User::query()->where('institution_id', $institutionId)->where('type', 'user');

                    $query = $query->whereIn('school_year', $filters['yearGroupSelected']);
//dd($filters['yearGroupSelected']);
                    $query = $query->wherehas('selfAssessment', function ($query) use ($filters) {

                                //the assessment Must have the same year as the user's school year
                                $query->whereRaw('self_assessments.year = users.school_year');

                                if (count($filters['tagsRoutesSelected']) > 0)
                                {
                                    $query->withAllTags($filters['tagsRoutesSelected'], 'route');
                                }

                                if (count($filters['tagsRoutesSelected']) > 0)
                                {
                                    $query->withAllTags($filters['tagsRoutesSelected'], 'route');
                                }




                    });
/*
                    //$query = $query->withAllTags(['tag 1', 'tag 2'], 'myType')
*/
                    if ($filters['cvCompleted'] != 0)
                    {
                        $query = $query->where('cv_builder_completed', $filters['cvCompleted']);
                    }

dd($query->get());
                    $this->resultsPreview = $query->count();

                }

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


                    if ($this->reportType == "user-data")
                    {

                        $filename = 'user-data_'.Str::slug($this->institutionName).'_'.date("dmyHis").'.csv';

                        //runs the export
                        (new UsersExport( session()->get('adminClientSelectorSelected'), $institution->id))->queue($filename, 'exports')->chain([
                            new NotifyUserOfCompletedExport(request()->user(), $filename),
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
        return view('livewire.admin.reporting-users-bespoke');
    }
}
