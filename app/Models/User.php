<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use \Spatie\Tags\HasTags;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasTags;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'personal_email', 'password', 'institution_id', 'birth_date', 'school_year', 'postcode', 'rodi', 'roni'
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
    ];

    //registers accessor
    protected $appends = [ 'full_name', 'first_name', 'last_name', 'birth_date', 'system_id' ];

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


    /**
     * Get the user's date of birth.
     *
     * @param  string  $value
     * @return string
     */
    public function getBirthDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
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
     * Get the institution record associated with the user.
     */
    public function institution()
    {
       return $this->belongsTo(\App\Models\Institution::class);
    }


    /**
     * Get the self assessment readiness record associated with the user.
     */
    public function selfAssessment()
    {

        return $this->hasMany(\App\Models\SelfAssessment::class);

    }


    /**
     * Get articles read
     */
    public function articles()
    {
        return $this->belongsToMany(\App\Models\ContentLive::class)
                    ->withPivot('nb_read')
                    ->withTimestamps();
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
}
