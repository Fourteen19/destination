<?php

namespace App\Models;

use App\Models\User;
use App\Models\CvReference;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cv extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'address', 'email', 'phone', 'personal_profile', 'additional_interests'
    ];


    /**
     * Get the owner
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function references()
    {
        return $this->hasMany(CvReference::class, 'cv_id', 'id');
        //->select('id', 'name', 'job_role', 'company', 'address_1', 'address_2', 'address_3', 'postcode', 'email', 'phone');
    }

    public function educations()
    {
        return $this->hasMany(CvEducation::class, 'cv_id', 'id');

    }

}
