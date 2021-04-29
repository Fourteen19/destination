<?php

namespace App\Services\Frontend;

use App\Models\ContentLive;
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
     * getFeaturedEmployers
     * get 4 featured employers based on tags
     *
     * @param  mixed $user
     * @return void
     */
    public function getFeaturedEmployers()
    {

        //get the assessment tags
        $routes = app('selfAssessmentSingleton')->getAllocatedTags('route');
        $sectors = app('selfAssessmentSingleton')->getAllocatedTags('sector');
        $subject = app('selfAssessmentSingleton')->getAllocatedTags('subject');

        //Compiles the tags in a collection and shuffles it


        //route
        //sector
        //subject




//dd(ContentLive::where('template_id', 4)->get());
        return ContentLive::where('template_id', 4)->limit(4)->get();

    }

}
