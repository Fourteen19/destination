<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification as Notification;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Client;
use App\Models\Institution;


class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;
    /*
    const SYSTEMADMIN_TYPE = 'system_admin';
    const ADMIN_TYPE = 'admin';
    const EDITOR_TYPE = 'editor';
*/

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
        'first_name', 'last_name', 'email', 'password', 'user_type', 'client_id'
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
    protected $appends = [ 'full_name', 'first_name', 'last_name' ];


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


    public function client()
    {
       // if (\Auth::guard('admin')->user()->hasAnyRole('Client Admin', 'Client Content Admin', 'Third Party Admin') )
      //  {             
            return $this->belongsTo('App\Models\Client');
      //  }
    }


    public function institution()
    {
//        if (\Auth::guard('admin')->user()->hasAnyRole('Advisor') )
//        {             
            return $this->belongsToMany('App\Models\Institution');
//        }
    }

    /**
     * Checks if user is a system administrator.
     *
     * @return boolean
     */
 /*   public function isSystemAdmin() {
        return $this->role === self::SYSTEMADMIN_TYPE;
    }
 */  

    /**
     * Checks if user is a global content admin.
     *
     * @return boolean
     */
 /*   public function isAdmin() {
        return $this->role === self::ADMIN_TYPE;
    } 
*/
    /**
     * Checks if user is a client admin.
     *
     * @return boolean
     */
 /*   public function isEditor() {
        return $this->role === self::EDITOR_TYPE;
    } 
*/
}

