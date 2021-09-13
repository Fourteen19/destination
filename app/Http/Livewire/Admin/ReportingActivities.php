<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Livewire\Component;
use App\Models\SystemTag;
use App\Models\ContentLive;
use App\Models\Institution;
use Illuminate\Support\Str;
use App\Exports\UsersExport;
use App\Exports\ActivitiesExport;
use Illuminate\Support\Facades\Auth;
use App\Exports\UsersNotLoggedInExport;
use App\Exports\ActivitiesAnswersExport;
use App\Jobs\NotifyUserOfCompletedExport;

class ReportingActivities extends Component
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
    public $activitiesList;
    public $activity = 'all';
    public $year;

    public function mount($reportType)
    {
        $this->reportType = $reportType;

        $this->getInstitutionsList();

        $this->getActivitiesList();


/*
        $activitiesList = ContentLive::where('template_id', 3)
        ->select('id', 'title')
        ->with('relatedActivityQuestions', function ($query) {
            $query->select('id', 'text', 'activquestionable_id', 'activquestionable_type');
            $query->orderby('order_id', 'ASC');
        })
        ->get()
        ->toArray();
//dd($activitiesList);
        $titles = [];
        foreach($activitiesList as $activity)
        {
            $titles[] = $activity['title'];

            foreach($activity['related_activity_questions'] as $relatedActivityQuestion)
            {

                $titles[] = $relatedActivityQuestion['text'];

            }

        }

//dd($titles);

        $activitiesAnswers = array_fill(0, count($titles), '');
//dd($activitiesAnswers);
//dd($activitiesList = ContentLive::where('template_id', 4)->pluck('title', 'id')->toArray());

        $users = User::query()->select('id', 'first_name', 'last_name', 'school_year')
        ->where('school_year', 8)
        ->where('institution_id', 3)
        ->with('allActivityAllAnswers', function ($query) {
            $query->select('text', 'activquestionable_id', 'activquestionable_type', 'order_id', 'answer');
            $query->withPivot('answer');
        })
        ->get();


        foreach($users as $u)
        {

            if ($u->allActivityAllAnswers)
            {

                foreach ($u->allActivityAllAnswers as $activityAnswer)
                {

print                    $key = array_search($activityAnswer->activquestionable_id, array_column($activitiesList, 'id'));
print "-";
                    if (is_numeric($key))
                    {
                        $activitiesAnswers[ $key * 4 + $activityAnswer->order_id ] = (!empty($activityAnswer->answer)) ? $activityAnswer->answer : "";
                    }

                }

            }

        }

dd($activitiesAnswers);





        //print_r($this->activitiesList);
/*


        $activitiesList = $this->activitiesList = ContentLive::where('template_id', 3)->select('id', 'title')->get()->toArray();
//dd($activitiesList);
        $activitiesListIntersect = array_fill(0, count($activitiesList), 'N');

        foreach($users as $u)
        {

            if ($u->userActivities)
            {
            //    $crsScore = $selfAssessment->career_readiness_average;

                foreach ($u->userActivities as $userActivity)
                {

                    //print $userActivity->pivot->completed;
                    if ($userActivity->pivot->completed == 'N')
                    {
                        //print $userActivity->id;

                        $key = array_search($userActivity->id, array_column($activitiesList, 'id'));
                        if (is_numeric($key))
                        {
                            $activitiesListIntersect[$key] = 'Y';
                        }


                    }

                }

            }

        }
        dd($activitiesListIntersect);
 */

       // userActivities

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




    public function getActivitiesList()
    {

        $this->activitiesList = ContentLive::where('template_id', 3)->pluck('title', 'uuid');

    }



    public function adminHasPermissionToAccessInstitution($institutionId)
    {

        return Auth::guard('admin')->user()->adminCanAccessInstitution($institutionId);

    }





    public function updated($propertyName)
    {

        if ($propertyName == "institution")
        {

            if ( Uuid::isValid( $this->institution ))
            {
                $this->resultsPreview = 0;
                $this->resultsPreviewMessage = "";
                $this->message = "";
                $this->displayExportButtons = True;

            } else {

                $this->displayExportButtons = False;

            }

        } elseif ($propertyName == "activity") {

             if ( ( Uuid::isValid( $this->activity )) || ($this->activity == 'all') )
            {
                $this->resultsPreview = 0;
                $this->resultsPreviewMessage = "";
                $this->message = "";
                $this->displayExportButtons = True;

            } else {

                $this->displayExportButtons = False;

            }

        } elseif ($propertyName == "year") {



        }

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

                $this->resultsPreview = User::query()->where('institution_id', $institutionId)
                                                     ->where('school_year', $this->year)
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



    /**
     * getActivityId
     * returns the activiy to display in report
     *
     * @return void
     */
    public function getActivityId()
    {

        //if the activity is specified
        if ( Uuid::isValid( $this->activity ))
        {

            $activity = ContentLive::select('id')->where('uuid', $this->activity)->limit(1)->get();

            if (count($activity) == 1)
            {

                return $activity->first()->id;

            }

        }

        //if the activity is set to all
        if ( $this->activity == 'all')
        {
            return 'all';
        }

        //return all per default
        return 'all';
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
                    $filename = 'activities_'.Str::slug($this->institutionName).'_'.date("dmyHis").'.csv';


                    if ($this->reportType == "activities")
                    {

                        //runs the export
                        (new ActivitiesExport( session()->get('adminClientSelectorSelected'), $institution->id, $this->year, $this->getActivityId() ))->queue($filename, 'exports')->chain([
                            new NotifyUserOfCompletedExport(request()->user(), $filename),
                        ]);

                    } elseif ($this->reportType == "activities-answers") {

                        //runs the export
                        (new ActivitiesAnswersExport( session()->get('adminClientSelectorSelected'), $institution->id, $this->year, $this->getActivityId() ))->queue($filename, 'exports')->chain([
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
        return view('livewire.admin.reporting-activities');
    }
}
