<?php

namespace App\Services\Frontend;

use App\Models\ContentLive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;


Class ActivitiesService
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
     * getNbCompletedActivitiesforUser
     * returns the number of activities completed by user
     *
     * @param  mixed $userId
     * @return Int
     */
    public function getNbCompletedActivitiesforUser($userId = NULL) : Int
    {
        if ($userId == NULL){
            $userId = Auth::guard('web')->user()->id;
        }

        //selects activites that have been completed for current User
        return ContentLive::where('template_id', 3)->whereHas('activityUsers', function($query) use ($userId) {
            $query->where('completed', 'Y');
            $query->where('user_id', $userId);
        })->count();

    }



    /**
     * getTotalNumberOfActivitiesInSystem
     * returns the total number activities in the system
     *
     * @return Int
     */
    public function getTotalNumberOfActivitiesInSystem() : Int
    {

        return ContentLive::where('template_id', 3)->count();

    }





    /**
     * getActivitiesCompletedByUser
     * get the last 4 activities completed by user
     *
     * @param  mixed $user
     * @return void
     */
    public function getStripeActivitiesCompletedByUser($userId = NULL)
    {

        if ($userId == NULL){
            $userId = Auth::guard('web')->user()->id;
        }

        //selects activites that have been completed for the User
        //A Join must be user to do the ORDERBY
        return ContentLive::select('contents_live.id', 'summary_heading', 'summary_text', 'slug')
                            ->where('template_id', 3)
                            ->join('content_activity_user', 'contents_live.id', '=', 'content_activity_user.content_live_id')
                            ->where('content_activity_user.completed', 'Y')
                            ->where('user_id', $userId)
                            ->with(['media' => function (MorphMany $query) {
                                $query->where('collection_name', 'banner');
                            }])
                            ->orderByDesc('content_activity_user.updated_at')
                            ->limit(4)
                            ->get();

    }


    /**
     * getActivitiesCompletedByUser
     * get all the activities completed by user
     *
     * @param  mixed $user
     * @return void
     */
    public function getAllActivitiesCompletedByUser($userId = NULL)
    {

        if ($userId == NULL){
            $userId = Auth::guard('web')->user()->id;
        }

        //selects activites that have been completed for the User
        return ContentLive::select('id', 'summary_heading', 'summary_text', 'slug')
                            ->where('template_id', 3)
                            ->whereHas('activityUsers', function($query) use ($userId){
                                $query->where('completed', 'Y');
                                $query->where('user_id', $userId);
                            })
                            ->with(['media' => function (MorphMany $query) {
                                $query->where('collection_name', 'banner');
                            }])
                            ->get();

    }



    /**
     * getStripeActivitiesNotCompletedByUser
     * get limited amount of activities not completed by user
     *
     * @param  mixed $user
     * @return void
     */
    public function getStripeActivitiesNotCompletedByUser($userId = NULL)
    {

        if ($userId == NULL){
            $userId = Auth::guard('web')->user()->id;
        }

        //selects activites that have been completed for the User
        return ContentLive::where('template_id', 3) //activity template
                            ->whereDoesntHave('activityUsers', function (Builder $query) use ($userId) {  //detect if the relationship exists with the current user
                                $query->where('user_id', $userId);
                            })
                            ->orwhereHas('activityUsers', function($query) use ($userId) { //if the relationship exists with the current user, check completed is set to 'Y'
                                $query->where('completed', 'N');
                                $query->where('user_id', $userId);
                            })
                            ->select('id', 'summary_heading', 'summary_text', 'slug')
                            ->with(['media' => function (MorphMany $query) {
                                    $query->where('collection_name', 'banner');
                            }])
                            ->limit(4)
                            ->orderBy('summary_heading', 'ASC')
                            ->get();

    }


    /**
     * getAllActivitiesNotCompletedByUser
     * get all the activities not completed by a user
     *
     * @param  mixed $userId
     * @return void
     */
    public function getAllActivitiesNotCompletedByUser($userId = NULL)
    {

        if ($userId == NULL){
            $userId = Auth::guard('web')->user()->id;
        }

        //selects activites that have been completed for the User
        return ContentLive::where('template_id', 3) //activity template
                            ->whereDoesntHave('activityUsers', function (Builder $query) use ($userId) {  //detect if the relationship exists with the current user
                                $query->where('user_id', $userId);
                            })
                            ->orwhereHas('activityUsers', function($query) use ($userId) { //if the relationship exists with the current user, check completed is set to 'Y'
                                $query->where('completed', 'N');
                                $query->where('user_id', $userId);
                            })
                            ->select('id', 'summary_heading', 'summary_text', 'slug')
                            ->with(['media' => function (MorphMany $query) {
                                    $query->where('collection_name', 'banner');
                            }])
                            ->orderBy('summary_heading', 'ASC')
                            ->get();

    }


}
