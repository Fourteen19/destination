<?php

namespace App\Models;

use App\Models\User;
use App\Models\CvReference;
use App\Models\CvEmploymentSkill;
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
        'first_name', 'last_name', 'address', 'email', 'phone', 'personal_profile', 'additional_interests', 'employment',
        'page_break_before_employment', 'page_break_before_education', 'page_break_before_additional_interests', 'page_break_before_references'
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
    }

    public function educations()
    {
        return $this->hasMany(CvEducation::class, 'cv_id', 'id');

    }

    public function employments()
    {
        return $this->hasMany(CvEmployment::class, 'cv_id', 'id');

    }

    public function employmentSkills()
    {
        return $this->hasMany(CvEmploymentSkill::class, 'cv_id', 'id');

    }


}
