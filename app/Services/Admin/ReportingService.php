<?php

namespace App\Services\Admin;

use App\Models\Client;
use App\Models\Admin\Admin;
use App\Models\ClientSettings;
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




}
