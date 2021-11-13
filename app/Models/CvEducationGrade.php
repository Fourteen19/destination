<?php

namespace App\Models;

use App\Models\CvEducation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvEducationGrade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'grade', 'predicted',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cv_educations_grades';



    /**
     * Get the CV Education Grade
     */
    public function education()
    {
        return $this->belongsTo(CvEducation::class);
    }

}
