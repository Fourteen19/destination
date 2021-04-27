<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WorkExperienceController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        //selects activites that have been completed for current User
        $nbCompletedActivities = ContentLive::where('template_id', 3)->whereHas('activitySpecificUser', function($query) {
            $query->where('completed', 'Y');
            $query->where('user_id', Auth::guard('web')->user()->id);
        })->count();

        ContentLive::where('template_id', 3)->whereHas('activitySpecificUser', function($query) {
            $query->where('completed', 'Y');
            $query->where('user_id', Auth::guard('web')->user()->id);
        })
        ->limit(4);

        return view('frontend.pages.work-experience.show', compact('nbCompletedActivities') );

    }
}
