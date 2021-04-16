<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'work_experience', 'suspended', 'client_id'
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
     * Get the client record associated with the institution.
     */
    public function client()
    {
        return $this->hasOne('App\Models\Client');
    }


    /**
     * Get the users records associated with the institution.
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    /**
     * Get the admins records associated with the institution.
     */
    public function admins()
    {
        return $this->belongsToMany('App\Models\Admin\Admin');
    }


    /**
     * Get the admins records associated with the institution.
     */
    //public function adminsWhichAreAdvisors()
    public function adminsWithRoles()
    {
        return $this->belongsToMany('App\Models\Admin\Admin')->with('roles:name');
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function scopeCanOnlySeeClientInstitutions($query, $clientId)
    {
        return $query->where('client_id', "=", $clientId);
    }

}
