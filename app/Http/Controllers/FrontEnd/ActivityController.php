<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class ActivityController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct() {


    }



    public function suggestedIndex(Request $request)
    {

/*
select('summary_heading', 'summary_text')
                            ->
*/

        //selects activites that have been completed for current User
        $data = ContentLive::where('template_id', 3) //activity template
                            ->where('id', 51)
/*                             ->whereDoesntHave('activitySpecificUser', function (Builder $query) {  //detect if the relationship exists with the current user
                                $query->where('user_id', Auth::guard('web')->user()->id);
                            })
                            ->orwhereHas('activitySpecificUser', function($query) { //if the relationship exists with the current user, check completed is set to 'Y'
                                $query->where('completed', 'N');
                                $query->where('user_id', Auth::guard('web')->user()->id);
                            }) */
                            //->select('summary_heading', 'summary_text')
                            //->with('media')
                            ->with(['media' => function (MorphMany $query) {
                                    $query->where('collection_name', 'banner');
                            }])
                            /* ->has('media', function($q)
                            {
                                $q->where('collection_name','=', 'banner');

                            }) */
                            ->get();

dd($data);
foreach($data as $a)
{
//dd($a);
//print $a->summary_heading;
    $banner = $a->getMedia('banner')->first();//getMedia('banner', 'banner_activity');

}
//dd();
        return view('frontend.pages.activities.suggested.index', ['data' => $data]);

    }



    /**
     * allActivitiesCompleted
     * Displays all activities completed by a user
     *
     * @param  mixed $request
     * @return void
     */
    public function completedIndex()
    {

        //selects activites that have been completed for current User
        $data = ContentLive::select('summary_heading', 'summary_text')->where('template_id', 3)->whereHas('activitySpecificUser', function($query) {
            $query->where('completed', 'Y');
            $query->where('user_id', Auth::guard('web')->user()->id);
        })->get();

        return view('frontend.pages.activities.completed.index', ['data' => $data]);

    }


    /**
     * show
     *
     * @param  mixed $clientSubdomain
     * @param  mixed $article
     * @param  mixed $relatedArticlesService
     * @param  mixed $youMightLikeArticlesService
     * @return void
     */
    public function show(String $clientSubdomain, ContentLive $activity)
    {

        return view('frontend.pages.activities.show', ['content' => $activity]);

    }

}
