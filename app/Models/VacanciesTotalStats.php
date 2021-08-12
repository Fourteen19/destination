<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacanciesTotalStats extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vacancy_id', 'client_id', 'institution_id', 'year_id', 'year_7',  'year_8',  'year_9',  'year_10',  'year_11',  'year_12',  'year_13',  'year_14',
    ];


    /**
     * Get the content
     */
    public function vacancy()
    {
        return $this->belongsTo(App\Models\Vacancy::class);
    }

}
