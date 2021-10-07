<?php

namespace App\Models;

use Carbon\Carbon;
use \Spatie\Tags\HasTags;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RelatedActivityQuestion;
use Illuminate\Support\Facades\Session;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\userPasswordResetNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasTags;
    use SoftDeletes;


        /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    /* public function getPersonalEmailForPasswordReset()
    {
        return $this->personal_email;
    } */


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'personal_email', 'password', 'client_id', 'institution_id', 'birth_date', 'type', 'school_year',
        'postcode', 'rodi', 'roni', 'nb_red_flag_articles_read', 'nb_logins', 'last_login_date', 'accept_terms', 'password_reset', 'cv_builder_completed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_date' => 'datetime',
    ];

    //registers accessor
    protected $appends = [ 'full_name', 'first_name', 'last_name', 'birth_date', 'system_id', 'last_login_date' ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getFirstNameAttribute($value)
    {
        return ucwords($value);
    }


    /**
     * Get the user's last name.
     *
     * @param  string  $value
     * @return string
     */
    public function getLastNameAttribute($value)
    {
        return ucwords($value);
    }


    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ucwords($this->first_name." ".$this->last_name);
    }



    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getSystemIdAttribute()
    {

        return "CK".str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }




    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        //gets the email from the request as users can use their school email or personal email
        $email = filter_var(request()['email'], FILTER_SANITIZE_EMAIL);

        $this->notify(new userPasswordResetNotification($token, getSubdomain()[0], $email));
    }



    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
/*     public function routeNotificationForMail($notification)
    {
        if ($notification instanceof userPasswordResetNotification)
        {
            // Return the email address used in the notification
            return $notification->emailTo;
        }

        // Return email
        return [$this->email];
    } */



    /**
     * getTransactionDateAttribute
     * display the last login date
     *
     * @param  mixed $value
     * @return void
     */
    public function getLastLoginDateAttribute($value)
    {
        if (is_null($value))
        {
            return "This user has not accessed the system yet";
        } else {
            return Carbon::parse($value)->format('d/m/Y H:i:s');
        }
    }



    /**
     * Get the full assessment.
     * if the year is NOT passed to the function, then we return the student current year assessment
     * Eager loads the `tags` relations
     *
     * @param  Integer  $year
     * @return \App\Models\SelfAssessment::class
     */
    public function getSelfAssessment($year = NULL)
    {
        return $this->selfAssessment()->where('year', (is_null($year)) ? $this->school_year : $year )->with('tags')->first();
    }



    public function getAllSelfAssessments()
    {
        return $this->selfAssessment()->with('tags')->orderBy('year')->get();
    }


    /**
     * countNbAssessmentsCompleted
     * counts the number of self assessments completed by a user
     *
     * @return void
     */
    public function countNbAssessmentsCompleted()
    {
        return $this->selfAssessment()->where('completed', 'Y')->count();
    }


    /**
     * isReturningUser
     * Checks if the user is a returning user, ie. this user has completed at least one assessment
     *
     * @return void
     */
    public function isReturningUserCheck()
    {
        if ($this->countNbAssessmentsCompleted() > 0)
        {
            Session::put('returning_user', True);
        } else {
            Session::put('returning_user', False);
        }
    }


    /**
     * checkIfUserisReturning
     * Checks if a user is returning
     *
     * @return void
     */
    public function checkIfUserisReturning()
    {
        return Session::get('returning_user', False);
    }


    /**
     * Get the user's date of birth.
     *
     * @param  string  $value
     * @return string
     */
    public function getBirthDateAttribute($value)
    {
        if (!empty($value))
        {
            return Carbon::parse($value)->format('d/m/Y');
        }

        return NULL;

    }

    /**
     * Change Date format when persisting user
     *
     * @return string
     */
    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }



    /**
     * clearDashborad
     * Resets all articles from the dashboard
     *
     * @return void
     */
    public function clearOrCreateDashboard()
    {

        Auth::guard('web')->user()->dashboard()->updateorCreate(
            ['user_id' =>  Auth::guard('web')->user()->id],
            ['slot_1'=> NULL,
            'slot_2'=> NULL,
            'slot_3'=> NULL,
            'slot_4'=> NULL,
            'slot_5'=> NULL,
            'slot_6'=> NULL,
            'ria_slot_1'=> NULL,
            'ria_slot_2'=> NULL,
            'ria_slot_3'=> NULL,
            'sd_slot_1'=> NULL,
            'sd_slot_2'=> NULL,
            'sd_slot_3'=> NULL,
            'hrn_slot_1'=> NULL,
            'hrn_slot_2'=> NULL,
            'hrn_slot_3'=> NULL,
            'hrn_slot_4'=> NULL,
            ]
        );

    }



    /**
     * createDashboardForUser
     * creates a dashboard for the current user
     *
     * @return void
     */
 /*   public function createDashboardForUser()
    {
        $this->dashboard()->create();
    }
*/

    /**
     * getUserDashboardDetails
     * loads the articles ID for each dashborad
     * If the user has no dashboard, we create it
     *
     * @return void
     */
    public function getUserDashboardDetails()
    {

        //if no dashboard exists
        if ( !$this->dashboard()->exists() )
        {
            //create one
            $this->clearOrCreateDashboard();
        }

        //return the solts of the dashboard
        return $this->getAllDashboardSlots()->get()->first();

    }



    /**
     * clearDashboardSlot
     * reset a dashboard slot
     *
     * @return void
     */
    public function clearUserDashboardSlot($slotId, String $slotPrefix="")
    {

        $this->dashboard()->update([
            $slotPrefix.'slot_'.$slotId => NULL
        ]);

    }



    /**
     * Get the institution record associated with the user.
     */
    public function institution()
    {
       return $this->belongsTo(\App\Models\Institution::class);
    }




    /**
     * Get the institution record associated with the user.
     */
    public function client()
    {
       return $this->belongsTo(\App\Models\Client::class);
    }



    /**
     * Get the dashboard associated with the user.
     */
    public function dashboard()
    {
        return $this->hasOne(\App\Models\Dashboard::class);
    }


    public function getAllDashboardSlots()
    {
        return $this->hasOne(\App\Models\Dashboard::class)->select('slot_1', 'slot_2', 'slot_3', 'slot_4', 'slot_5', 'slot_6', 'sd_slot_1', 'sd_slot_2', 'sd_slot_3', 'ria_slot_1', 'ria_slot_2', 'ria_slot_3', 'hrn_slot_1', 'hrn_slot_2', 'hrn_slot_3', 'hrn_slot_4');
    }


    public function getDashboardSlots()
    {
        return $this->hasOne(\App\Models\Dashboard::class)->select('slot_1', 'slot_2', 'slot_3', 'slot_4', 'slot_5', 'slot_6');
    }


    public function getUserDashboardSomethingDifferentDetails()
    {
        return $this->hasOne(\App\Models\Dashboard::class)->select('sd_slot_1', 'sd_slot_2', 'sd_slot_3');
    }


    public function getUserDashboardReadItAgainDetails()
    {
        return $this->hasOne(\App\Models\Dashboard::class)->select('ria_slot_1', 'ria_slot_2', 'ria_slot_3');
    }

    public function getUserDashboardHotRightNowDetails()
    {
        return $this->hasOne(\App\Models\Dashboard::class)->select('hrn_slot_1', 'hrn_slot_2', 'hrn_slot_3', 'hrn_slot_4');
    }

    /**
     * Get the self assessment readiness record associated with the user.
     */
    public function selfAssessment()
    {

        return $this->hasMany(\App\Models\SelfAssessment::class);

    }



    /**
     * Get all articles read accross all years
     */
    public function articles()
    {
        return $this->belongsToMany(\App\Models\ContentLive::class)
                    ->withTimestamps();
    }


    /**
     * Get all articles read accross all years
     */
    public function allArticles()
    {
        return $this->belongsToMany(\App\Models\ContentLive::class)
                    ->withPivot('nb_read')
                    ->withTimestamps();
    }


    /**
     * articlesReadThisYear
     * Get all articles read for current user year in the current year
     *
     * @param  mixed $yearParam
     * @return void
     */
    public function articlesReadThisYear($yearParam = NULL)
    {

        $year = ($yearParam === NULL) ? Auth::guard('web')->user()->school_year : $yearParam;

        return $this->belongsToMany(\App\Models\ContentLive::class)
                    ->withPivot('nb_read', 'user_feedback')
                    ->wherePivot('school_year', $year)
                    ->withTimestamps();
    }



    /**
     * articlesReadThisYearForCount
     * used to count the number of articles read in a specific year
     * used in reporting to count the number of articles read
     *
     * @param  mixed $yearParam
     * @return void
     */
    public function articlesReadForYear($yearParam)
    {
        return $this->belongsToMany(\App\Models\ContentLive::class)
                    ->wherePivot('school_year', $yearParam);
    }

    /**
     * articleReadThisYear
     * Get the article read for current user
     *
     * @param  mixed $articleId
     * @param  mixed $yearParam
     * @return void
     */
    public function articleReadThisYear(int $articleId, $yearParam = NULL)
    {

        $year = ($yearParam === NULL) ? Auth::guard('web')->user()->school_year : $yearParam;

        return $this->belongsToMany(\App\Models\ContentLive::class)
                    ->withPivot('school_year', 'nb_read', 'user_feedback', 'timer_15_triggered', 'timer_fully_read_triggered', 'scroll_75_percent', 'scroll_100_percent')
                    ->wherePivot('school_year', $year)
                    ->wherePivot('content_live_id', $articleId)
                    ->withTimestamps();
    }



    /**
     * ArticlesWithTagReadThisYear
     * loads the articles that have been read for a specific year
     * the article has a tag specified
     *
     * @param  mixed $yearParam
     * @param  mixed $tagName
     * @param  mixed $tagType
     * @return void
     */
    public function ArticlesWithTagReadThisYear($yearParam, $tagName, $tagType)
    {

        $year = ($yearParam === NULL) ? Auth::guard('web')->user()->school_year : $yearParam;

        return $this->belongsToMany(\App\Models\ContentLive::class)
                    ->wherePivot('school_year', $year)
                    ->withAllTags([$tagName], $tagType);
    }




    /**
     * userHasReadArticleRead
     * checks if the user has read the article independant of the year the user is in
     *
     * @param  mixed $articleId
     * @return void
     */
    public function userHasReadArticleRead(int $articleId)
    {

        return $this->belongsToMany(\App\Models\ContentLive::class)
                    ->wherePivot('content_live_id', $articleId)
                    ->exists();

    }




    public function searchedKeywords()
    {
        return $this->belongsToMany(\App\Models\SystemKeywordTag::class);
    }


    public function searchedKeywordsName()
    {
        return $this->belongsToMany(\App\Models\SystemKeywordTag::class)->select('name');
    }


    //USE THIS FOR SCOPES
    //dd($request->session()->get('adminAccessLevel'));

    /**
     * Determines if a user is redirected to the welcome screen or dashboard when logging in the frontend
     *
     * @return boolean
     */
    public function canGoToDashboard(){
//if ( (Auth::user()->first_time_login()) || () ){

        return FALSE;

    }



    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function scopeCanOnlySeeClient($query, $clientId)
    {
        return $query->where('client_id', "=", $clientId);
    }




    /**
     * Get the admin related to this model.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }





    /**
     * userActivities
     * returns content activities related to the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userActivities()
    {
        return $this->belongsToMany(ContentLive::class, 'content_activity_user')
                    ->withPivot('completed')
                    ->withTimestamps();
    }



    /**
     * userActivity
     * returns content activitie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userActivity($activityId)
    {
        return $this->belongsToMany(ContentLive::class, 'content_activity_user')
                    ->withPivot('completed')
                    ->where('content_live_id', $activityId)
                    ->withTimestamps();
    }


    public function userActivitiesCompleted()
    {
        return $this->belongsToMany(ContentLive::class, 'content_activity_user')
                    ->withPivot('completed')
                    ->where('completed', 'Y')
                    ->withTimestamps();
    }



    /**
     * activities_answers
     * collects ALL the activities && activities answers
     * @return void
     */
    public function allActivityAnswers()
    {
        return $this->belongsToMany(RelatedActivityQuestion::class, 'related_activity_question_user');
    }



    /**
     * activityAnswers
     * collects an activity answers
     * @return void
     */
    public function activityAnswers($activityId)
    {
        return $this->belongsToMany(RelatedActivityQuestion::class, 'related_activity_question_user')
                    ->withPivot('answer')
                    ->where('activquestionable_id', $activityId)
                    ->withTimestamps();
    }



    public function allActivityAllAnswers()
    {
        return $this->belongsToMany(RelatedActivityQuestion::class, 'related_activity_question_user')
                    ->withPivot('answer');
    }



    /**
     * canAccessWorkExperience
     * detects if the user can access the work experience section of the site
     *
     * @return void
     */
    public function canAccessWorkExperience()
    {


        //if the user is an admin user
        if (Auth::guard('web')->user()->type == 'admin')
        {

            if (Auth::guard('web')->user()->admin->hasAnyRole( config('global.admin_user_type.System_Administrator'),
                                                        config('global.admin_user_type.Global_Content_Admin'),
                                                        config('global.admin_user_type.Advisor'),
                                                        config('global.admin_user_type.Client_Admin'),
                                                        config('global.admin_user_type.Client_Content_Admin'),
                                                        ) )
            {

                return TRUE;

            //check if the user is a teacher
            } elseif (Auth::guard('web')->user()->admin->hasAnyRole( config('global.admin_user_type.Teacher') ) ){

                //get the institutions allocated to the admin
                $institutions = Auth::guard('web')->user()->admin->institutions;

                //if any
                if (count($institutions) > 0)
                {

                    //get the first one. There should ony be one as the user is a teacher
                    $institution = $institutions->first();

                    return $institution->work_experience;

                } else {

                    return False;

                }

            } else {

                return FALSE;

            }

        //if the user type is `user` and has an institution allocated
        } else if (!is_null($this->institution)){

            //if the user's institution "Work Experience" flag is set `ON`
            if ($this->institution->work_experience == 'Y'){
                return TRUE;
            } else {
                return FALSE;
            }

        } else {
            return FALSE;
        }

    }


}
