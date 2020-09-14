<?php

namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification as Notification;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    const SYSTEMADMIN_TYPE = 'system_admin';
    const ADMIN_TYPE = 'admin';
    const EDITOR_TYPE = 'editor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'user_type'
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
     * Custom password reset notification.
     */
    public function sendPasswordResetNotification($token){
        $this->notify(new Notification($token));
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


    public function isSystemAdmin() {
        return $this->role === self::SYSTEMADMIN_TYPE;
    }
   
    public function isAdmin() {
        return $this->role === self::ADMIN_TYPE;
    } 

    public function isEditor() {
        return $this->role === self::EDITOR_TYPE;
    } 

}

