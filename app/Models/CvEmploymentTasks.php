<?php

namespace App\Models;

use App\Models\CvEmployment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvEmploymentTasks extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cv_employments_tasks';



    /**
     * Get the CV Education Grade
     */
    public function employment()
    {
        return $this->belongsTo(CvEmployment::class);
    }

}
