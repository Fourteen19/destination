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




    /**
     * getRelatedEmployer
     * Get a related employer based on the currenly viewed eomployer
     * We pass search for an employer with similar sectors as the employer currently viewed
     *
     * @param  mixed $id
     * @param  mixed $sectors
     * @return void
     */
    public function getRelatedEmployer($id, $sectors)
    {

        //related employer - get employer with matching current employer's sector
        $relatedEmployer = ContentLive::select('id', 'title', 'slug')
                                        ->withAnyTags($sectors, 'sector')
                                        ->whereNotIn('id', [$id]) //not the current viewed employer
                                        ->where('template_id', 4)
                                        ->with('sectorTags:name') //selects the 'sector' tags only
                                        ->limit(1)
                                        ->first();


        //if no employer found
        if (!$relatedEmployer)
        {

            //fetches any employer
            $relatedEmployer = ContentLive::select('id', 'title', 'slug')
                                            ->where('template_id', 4)
                                            ->whereNotIn('id', [$id])  //not the current viewed employer
                                            ->with('sectorTags:name') //selects the 'sector' tags only
                                            ->limit(1)
                                            ->first();

        }

        if ($relatedEmployer)
        {
            return $relatedEmployer;
        } else {
            return NULL;
        }

    }




    /**
     * getRelatedArticle
     * fetches an articles with similar sector as the employer currently viewed
     *
     * @param  mixed $sectors
     * @return ContentLive
     */
    public function getRelatedArticle($sectors)
    {

        //get a related Article
        return ContentLive::select('id', 'summary_heading', 'summary_text', 'slug')
                            ->withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                            ->withAnyTags( [ app('currentTerm') ] , 'term')
                            ->withAnyTags($sectors, 'sector')
                            ->whereIn('template_id', [1,2])
                            ->limit(1)
                            ->first();
    }

}
