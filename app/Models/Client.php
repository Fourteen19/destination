<?php

namespace App\Models;

use App\Models\Employer;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'subdomain', 'suspended', 'website', 'contact'
    ];


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
     * Get the institutions for the client.
     */
    public function institutions()
    {
        return $this->hasMany('App\Models\Institution');
    }


    /**
     * Get the users for the client.
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    /**
     * Get the admins for the client.
     */
    public function admin()
    {
        return $this->hasMany('App\Models\Admin\Admin');
    }

    /**
     * Get the content for the client.
     */
    public function content()
    {
        return $this->hasMany('App\Models\Content');
    }


    /**
     * Get the static content for the client.
     */
    public function staticClientContent()
    {
        return $this->hasOne('App\Models\StaticClientContent');
    }


    /**
     * Get the client settings.
     */
    public function clientSettings()
    {
        return $this->hasOne('App\Models\ClientSettings');
    }


    /**
     * Get the institutions homepage settings.
     */
    public function homepageSettings()
    {
        return $this->hasMany('App\Models\HomepageSettings');
    }


    /**
     * Get the client resources.
     */
    public function resources()
    {
        return $this->belongsToMany(Resource::class);
    }


    /**
     * Get the client vacancies.
     */
    public function vacancies()
    {
        return $this->belongsToMany(Vacancy::class);
    }


}
