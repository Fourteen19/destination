<?php

namespace App\Services\Admin;

use App\Models\Client;
use App\Models\Admin\Admin;
use App\Models\ClientSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Class ReportingService
{


    /**
     * getInstitutionAdvisers
     *
     *
     * @param  mixed $institutionId
     * @return void
     */
    public function getInstitutionAdvisers($institutionId)
    {

        $advisers = Admin::adminTypeFromInstitution(config('global.admin_user_type.Advisor'), $institutionId)->select('admins.first_name', 'admins.last_name')->get();

        $adviserNames = [];

        if (count($advisers) > 0)
        {
            foreach($advisers as $adviser)
            {
                $adviserNames[] = $adviser->first_name." ".$adviser->last_name;
            }
        }
        return implode(";", $adviserNames);

    }


    /**
     * compileTagsHeading
     * Take tags and add them all in an array
     *
     * @param  mixed $tags
     * @return array
     */
    public function compileTagsHeading(array $tags): array
    {
        $tagsList = [];
        foreach($tags as $tag)
        {
            $tagsList[] = $tag['name']['en'];
        }
        return $tagsList;
    }




    /**
     * countNumberOfCompletedSelfAssessment
     *
     * @return void
     */
    public function countNumberOfCompletedSelfAssessment($clientId, $institutionId, $year)
    {

        $result = DB::table('self_assessments')
                    ->select(DB::raw('COUNT(completed) AS nb_completed_assessment'))
                    ->join('users', 'users.id', '=', 'self_assessments.user_id')
                    ->where('users.type', '=', 'user')
                    ->where('users.client_id', '=', $clientId)
                    ->where('users.institution_id', '=', $institutionId)
                    ->where('users.school_year', '=', $year)
                    ->where('self_assessments.year', '=', $year)
                    ->where('self_assessments.completed', '=', 'Y')
                    ->where('users.deleted_at', '=', NULL)
                    ->first();

        return $result->nb_completed_assessment;

    }




    /**
     * countNumberOfUsersInYearGroup
     *
     * @param  mixed $clientId
     * @param  mixed $institutionId
     * @param  mixed $year
     * @return void
     */
    public function countNumberOfUsersInYearGroup($clientId, $institutionId, $year)
    {
        //Number users in year group
        $result = DB::table('users')
                ->select(DB::raw('COUNT(school_year) AS nb_users'))
                ->where('users.school_year', '=', $year)
                ->where('users.type', '=', 'user')
                ->where('users.client_id', '=', $clientId)
                ->where('users.institution_id', '=', $institutionId)
                ->where('users.deleted_at', NULL)
                ->first();

        return $result->nb_users;

    }




    /**
     * calculatePercentageOfCompletedAssessment
     *
     * @param  mixed $nbUsers
     * @param  mixed $nbCompletedAssessment
     * @return void
     */
    public function calculatePercentageOfCompletedAssessment($nbUsers, $nbCompletedAssessment)
    {
        //Percentage of completed assessments
        if ($nbUsers > 0)
        {
            $percentageCompleted = round( ($nbCompletedAssessment * 100) / $nbUsers, 2) ."%";
        } else {
            $percentageCompleted = "N/A";
        }

        return $percentageCompleted;
    }



    /**
     * countNbTimesTagIsSelected
     * counts the number of times a tag is selected in an assessment
     *
     * @param  mixed $clientId
     * @param  mixed $institutionId
     * @param  mixed $year
     * @param  mixed $tagId
     * @return void
     */
    public function countNbTimesTagIsSelected($clientId, $institutionId, $nbCompletedAssessment, $year, $tagId)
    {

        if ($nbCompletedAssessment == 0)
        {
            return "N/A";

        } else {

            $result = DB::table('self_assessments')
                        ->select(DB::raw('COUNT(tag_id) AS nb_times_tag_selected'))
                        ->join('users', 'users.id', '=', 'self_assessments.user_id')
                        ->join('taggables', 'self_assessments.id', '=', 'taggables.taggable_id')
                        ->where('taggables.taggable_type', '=', 'App\\Models\\SelfAssessment')
                        ->where('taggables.tag_id', '=', $tagId)
                        ->where('users.type', '=', 'user')
                        ->where('users.client_id', '=', $clientId)
                        ->where('users.institution_id', '=', $institutionId)
                        ->where('users.school_year', '=', $year)
                        ->where('self_assessments.year', '=', $year)
                        ->where('self_assessments.completed', '=', 'Y')
                        ->where('users.deleted_at', '=', NULL)
                        ->first();

            return (String)$result->nb_times_tag_selected;

        }

    }


}
