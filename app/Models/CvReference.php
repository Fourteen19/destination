<?php

namespace App\Models;

use App\Models\Cv;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvReference extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'job_role', 'company', 'address_1', 'address_2', 'address_3', 'postcode', 'email', 'phone',
    ];


    /**
     * Get the CV
     */
    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }

}
