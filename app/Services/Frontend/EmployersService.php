<?php

namespace App\Services\Frontend;

use App\Models\ContentLive;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

Class EmployersService
{

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct() {
        //
    }




    /**
     * getAllEmployers
     * Fetches all the employers
     *
     * @return void
     */
    public function getAllEmployers()
    {

        return ContentLive::select('id', 'summary_heading', 'summary_text', 'slug')
                            ->where('template_id', 4)
                            ->get();

    }


    /**
     * getFeaturedEmployers
     * get 4 featured employers based on tags
     *
     * @param  mixed $user
     * @return void
     */
    public function getFeaturedEmployers()
    {

        //get the assessment tags
         //gets the live sector tags allocated to the user
        $sectors = app('selfAssessmentSingleton')->getAllocatedTags('sector');

        //Compiles the tag names
        $sectorNames = $sectors->pluck('name')->toArray();

        //convert associcative array to simple array && shuffles
        $sectorNames = Arr::shuffle( array_values($sectorNames) );

        //fetches 4 employers matching the user sector tags
        $employers = ContentLive::select('id', 'summary_heading', 'summary_text', 'slug')
                            ->withAnyTags($sectorNames, 'sector')
                            ->where('template_id', 4)
                            ->limit(4)
                            ->get();


        //counts the number of employers found
        $nbEmployersFound = count($employers);

        //if less 4 employers found
        if ($nbEmployersFound < 4)
        {

            //counts the number of extra employers to find
            $nbEmployersRequired = 4 - $nbEmployersFound;

            //gets the Ids of selected employers
            $employersIds = $employers->pluck('id')->toArray();

            //selects X employers to have a list of 4 different employers
            $extraEmployers = ContentLive::select('id', 'summary_heading', 'summary_text', 'slug')
                            ->where('template_id', 4)
                            ->whereNotIn('id', $employersIds)
                            ->limit($nbEmployersRequired)
                            ->get();

            //adds the extra employers to the collection of employers
            foreach($extraEmployers as $key => $extraEmployer)
            {
                $employers->push($extraEmployer);
            }

        }

        return $employers;

    }

}
