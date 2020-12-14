<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfAssessment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'year', 'career1_readiness_average', 'career_readiness_score_1', 'career_readiness_score_2', 'career_readiness_score_3', 'career_readiness_score_4', 'career_readiness_score_5'
    ];


    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }



}
