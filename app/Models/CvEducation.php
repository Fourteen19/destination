<?php

namespace App\Models;

use App\Models\Cv;
use App\Models\CvEducationGrade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvEducation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'from', 'to',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cv_educations';



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
    public function grades()
    {
        return $this->hasMany(CvEducationGrade::class);
    }
}
