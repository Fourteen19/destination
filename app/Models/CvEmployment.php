<?php

namespace App\Models;

use App\Models\Cv;
use App\Models\CvEmploymentTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvEmployment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organisation', 'job_role', 'job_type', 'from', 'to', 'tasks_type', 'tasks_txt'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cv_employments';



    /**
     * Get the CV
     */
    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }


    /**
     * Get the CV Education Grades
     */
    public function tasks()
    {
        return $this->hasMany(CvEmploymentTask::class);
    }
}
