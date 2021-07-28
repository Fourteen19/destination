<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeywordsTagsTotalStats extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tag_id', 'client_id', 'institution_id', 'year_id', 'total', 'year_7',  'year_8',  'year_9',  'year_10',  'year_11',  'year_12',  'year_13',  'year_14',
    ];

    /**
     * Get the tag
     */
    public function tag()
    {
        return $this->belongsTo(App\Models\SystemKeywordTag::class);
    }


        /**
     * Get the tag
     */
/*    public function tagByInstitutionByYear($institution_id, $year_id)
    {
        return $this->belongsTo(App\Models\SystemKeywordTag::class)
                        ->withPivot('school_year', 'nb_read', 'user_feedback', 'timer_15_triggered', 'timer_fully_read_triggered', 'scroll_75_percent', 'scroll_100_percent')
                        ->wherePivot('year', $year_id)
                        ->wherePivot('institution_id', $institution_id)
                        ->withTimestamps();
    }
*/


}
