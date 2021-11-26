<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Livewire\Component;
use App\Models\SystemTag;
use App\Models\Institution;
use Illuminate\Support\Str;
use App\Exports\UsersBespokeExport;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Database\Eloquent\Builder;

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
    public $extendedVersion = 0;
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

            if ($this->institution == 'all')
            {
                $this->resultsPreview = 0;
                $this->resultsPreviewMessage = "";
                $this->message = "";
                $this->displayExportButtons = True;
            } elseif ( Uuid::isValid( $this->institution )){
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


        } elseif ($propertyName == "extended"){
            $this->extendedVersion = 1;

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
            'extendedVersion' => $this->extendedVersion,
        ];
    }




    public function checkResults()
    {

        sleep(1);

        $this->resultsPreview = 0;

        $access = False;

        if ($this->institution == 'all')
        {

            $access = True;

            $institutionId = Auth::guard('admin')->user()->compileInstitutionsToArray();

        } elseif ( Uuid::isValid( $this->institution )) {

            $institution = Institution::select('id')->where('uuid', $this->institution)->get();

            if (count($institution) == 1)
            {

                $institutionId = $institution->first()->id;

                if ($this->adminHasPermissionToAccessInstitution($institutionId))
                {

                    $access = True;

                    $institutionId = [$institutionId];

                }

            }

        }





        if ($access == True)
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
  "extendedVersion" => 0
]
*/

            $query = User::query()->whereIn('institution_id', $institutionId)->where('type', 'user');

            $query = $query->where('type', 'user');

            $query = $query->whereIn('school_year', $filters['yearGroupSelected']);

            $query = $query->wherehas('selfAssessment', function ($query) use ($filters) {

                        //CRS
                        if (count($filters['tagsCrsSelected']) > 0)
                        {

                            $query = $query->where(function (Builder $query) use ($filters) {
                                foreach ($filters['tagsCrsSelected'] as $key => $value)
                                {
                                    $tmp = explode("-", $value);
                                    $query->orwhere(function (Builder $query) use ($tmp) {
                                        $query = $query->where('career_readiness_average', '>=', $tmp[0]);
                                        $query = $query->where('career_readiness_average', '<', $tmp[1]);
                                    });
                                }
                            });

                        }

                        //the assessment Must have the same year as the user's school year
                        $query->whereRaw('self_assessments.year = users.school_year');

                        if (count($filters['tagsRoutesSelected']) > 0)
                        {
                            //$query->withAllTagsAndPositiveScore($filters['tagsRoutesSelected'], 'route');
                            $query->withAllTags($filters['tagsRoutesSelected'], 'route');
                        }

                        if (count($filters['tagsSectorsSelected']) > 0)
                        {
                            $query->withAllTags($filters['tagsSectorsSelected'], 'sector');
                        }

                        if (count($filters['tagsSubjectsSelected']) > 0)
                        {
                            $query->withAllSelectedSubjectTags($filters['tagsSubjectsSelected'], 'subject');
                        }

            });

            if ($filters['cvCompleted'] != 0)
            {
                $query = $query->where('cv_builder_completed', $filters['cvCompleted']);
            }

            if ($filters['redFlag'] == 'Y')
            {
                $query = $query->where('nb_red_flag_articles_read', '>', 0);
            } elseif ($filters['redFlag'] == 'N') {
                $query = $query->where('nb_red_flag_articles_read',  0);
            }

            $this->resultsPreview = $query->count();

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


    public function makeFilename($prefix, $institutionName, $extension)
    {
        $filename = $prefix;

        if ($this->extendedVersion == 1)
        {
            $filename .= "_extended";
        }

        $filename .= "_".$institutionName;

        $filename .= "_".date("dmyHis");

        $filename .= $extension;

        return $filename;
    }


    public function generate()
    {

        //check matching records
        $this->checkResults();

        if ($this->institution == 'all')
        {

            $institutionId = Auth::guard('admin')->user()->compileInstitutionsToArray();

            //$filename = 'bespoke_user-data_all_institutions_'.date("dmyHis").'.csv';
            $filename = $this->makeFilename('bespoke_user-data_all_institutions', '', '.csv');
            $this->institutionName = "All Institutions";

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
                    //$filename = 'bespoke_user-data_'.Str::slug($this->institutionName).'_'.date("dmyHis").'.csv';
                    $filename = $this->makeFilename('bespoke_user-data', Str::slug($this->institutionName), '.csv');

                    $institutionId = $institution->id;

                }

            }

        }



        if ( ($this->resultsPreview > 0) || ($this->institution == 'all')  )
        {

            //runs the export
            (new UsersBespokeExport( session()->get('adminClientSelectorSelected'), $institutionId, $this->getBespokeFilters() ))->queue($filename, 'exports')->chain([
                new NotifyUserOfCompletedExport(request()->user(), $filename),
            ]);

            $this->reportGeneratedMessage();

        } else {

            $this->noRecordsMessage();

        }

    }



    public function render()
    {
        return view('livewire.admin.reporting-users-bespoke');
    }
}
