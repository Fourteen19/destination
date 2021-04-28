<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedActivityQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'uuid', 'order_id'
    ];

    public function content()
    {
        return $this->morphTo();
    }




    /**
     * users_activities_answers
     *
     * @return void
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'related_activity_question_user');
    }


}
