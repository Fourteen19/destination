<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Livewire\Component;
use App\Models\ContentLive;
use App\Models\Institution;
use Illuminate\Support\Str;
use App\Exports\UsersExport;
use App\Exports\ArticlesExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\UsersNotLoggedInExport;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReportingArticles extends Component
{

    use AuthorizesRequests;

    public $institutionsList;
    public $institution;
    public $institutionName;
    public $level;
    public $resultsPreview = 0;
    public $resultsPreviewMessage = "";
    public $message = "";
    public $reportType = "";
    public $displayExportButtons = False;

    public $template = "all";
    public $type = "all";

    protected $rules = [
        'type' => 'required|in:all,global,client',
        'template' => 'required|in:all,article,accordion,employer_profile,work_experience',
    ];

    protected $messages = [
        'type.required' => "Please select an article type",
        'type.in' => "Your article type is invalid",
        'template.required' => "Please select an article template",
        'template.in' => "Your article template is invalid",
    ];

    public function mount()
    {

        $this->getInstitutionsList();

    }



    public function getInstitutionsList()
    {

        $this->level = getAdminLevel(Auth::guard('admin')->user());

        if ( ($this->level == 3) || ($this->level == 2) )
        {

            //finds the institutions filtering by client
            $this->institutionsList = Institution::select('id', 'uuid', 'name')->where('client_id', '=', session()->get('adminClientSelectorSelected'))->orderBy('name')->get();

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


            if ($this->institution == 'all')
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

        if ($this->institution == 'all')
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

            $content = ContentLive::query();

            if ($this->type == "client")
            {
                $content = $content->where('client_id', session()->get('adminClientSelectorSelected'));
            } elseif ($this->type == "global") {
                $content = $content->where('client_id', NULL);
            }

            if ($this->template == "article")
            {
                $content = $content->where('template_id', 1);
            } elseif ($this->template == "accordion") {
                $content = $content->where('template_id', 2);
            } elseif ($this->template == "work_experience") {
                $content = $content->where('template_id', 3);
            } elseif ($this->template == "employer_profile") {
                $content = $content->where('template_id', 4);
            }

            $this->resultsPreview = $content->count();

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
            $filename = 'articles_all_institutions_'.date("dmyHis").'.csv';
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
                    $filename = 'articles_'.Str::slug($this->institutionName).'_'.date("dmyHis").'.csv';

                    $institutionId = $institution->id;

                }

            }

        }


        if ( ($this->resultsPreview > 0) || ($this->institution == 'all')  )
        {

            //runs the export
            (new ArticlesExport( session()->get('adminClientSelectorSelected'), $institutionId, $this->type, $this->template, Auth::guard('admin')->user()->uuid))->queue($filename, 'exports')->chain([
                new NotifyUserOfCompletedExport(request()->user(), $filename),
            ]);

            $this->reportGeneratedMessage();

        } else {

            $this->noRecordsMessage();

        }

    }



    public function render()
    {
        return view('livewire.admin.reporting-articles');
    }
}
