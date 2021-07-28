<?php

namespace App\Models\Admin;

use App\Models\Resource;
use App\Models\Institution;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification as Notification;


class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;


    protected $guard = 'admin';

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'first_name', 'last_name', 'email', 'password', 'user_type', 'client_id', 'contact_me'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    //registers accessor
    protected $appends = [ 'full_name', 'title_full_name', 'first_name', 'last_name' ];


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
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\adminPasswordResetNotification($token));
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
     * Get the user's full name + title
     *
     * @return string
     */
    public function getTitleFullNameAttribute()
    {
        return $this->title." ".ucwords($this->first_name." ".$this->last_name);
    }

    /**
     * Get the user's title + last name
     *
     * @return string
     */
    public function getTitleLastNameAttribute()
    {
        return $this->title." ".ucwords($this->last_name);
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }


    public function institutions()
    {
//        if (\Auth::guard('admin')->user()->hasAnyRole('Advisor') )
//        {
            return $this->belongsToMany('App\Models\Institution');
//        }
    }


    /**
     * GetAdminInstitutions
     * Returns institutions related t a user. User for Avdivers
     *
     * @return void
     */
    public function getAdminInstitutions()
    {
        return $this->institutions()->select('institutions.id', 'institutions.uuid', 'institutions.name')->get()->toArray();
    }


    public function adminCanAccessInstitution($institutionId)
    {

        $level = getAdminLevel($this);

        if ($level == 3)
        {
            return True;

        } elseif ($level == 2) {

            $clientId = $this->client_id; //current admin's client
            $institution = Institution::findOrFail($institutionId)->select('client_id');

            if ($institution)
            {
                if ($clientId == $institution->client_id)
                {
                    return True;
                }

            }

            return False;

        } elseif ($level == 1) {

            $clientId = $this->client_id; //current admin's client
            $institution = Institution::where('id', $institutionId)->select('id', 'client_id')->get();

            if ($institution)
            {

                //dd($institution->first()->client_id);
                if ($clientId == $institution->first()->client_id)
                {

                    if ($this->institutions->contains( $institution->first()->id ) )
                    {
                        return True;
                    }
                }

            }

            return False;
        }

    }


    /**
     * adminTypeFromInstitution
     *
     * @param  mixed $admin_type
     * @param  mixed $institution_id
     * @return void
     */
    public static function adminTypeFromInstitution($admin_type, $institution_id)
    {
        return self::query()->whereHas('roles', function($query) use ($admin_type) {
                        $query->where('name', $admin_type);
                    })->whereHas('institutions', function($query) use ($institution_id) {
                        $query->where('institution_id', $institution_id);
                    });
    }


    /**
     * Get `user` record associated with the admin.
     */
    public function frontendUser()
    {
        return $this->hasOne(\App\Models\User::class);
    }

    /**
     * compileInstitutionsToArray
     *
     * @return void
     */
    public function compileInstitutionsToArray()
    {
        $institutions = $this->getAdminInstitutions();

        $temp = [];
        if ($institutions > 0)
        {
            foreach($institutions as $key => $value)
            {
                $temp[] = $value['id'];
            }
        }

        return $temp;

    }


    /**
     * Get the user uploaded by the user
     */
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

}
